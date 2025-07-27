<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\ModificationField;
use App\Models\PhoneSearch;
use App\Models\Transaction;
use App\Models\Service;
use App\Models\Wallet;

class PhoneSearchController extends Controller
{
   public function index(Request $request)
    {
        $user = auth()->user();
        $query = PhoneSearch::with(['modificationField', 'transaction'])
                    ->where('user_id', $user->id);

        if ($request->filled('search')) {
            $query->where('bvn', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $crmSubmissions = $query->orderByDesc('submission_date')
                            ->paginate(10)
                            ->withQueryString();

        $bvnService = Service::where('name', 'BVN SEARCH')
                        ->where('is_active', true)
                        ->first();

        $modificationFields = $bvnService 
            ? $bvnService->modificationFields()
                ->where('is_active', true)
                ->get()
            : collect();


        return view('phone-search', [
            'modificationFields' => $modificationFields,
            'crmSubmissions' => $crmSubmissions,
            'services' => Service::where('is_active', true)->get()
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'modification_field_id' => 'required|exists:modification_fields,id',
            'number' => 'required|string|size:11|regex:/^[0-9]{11}$/',
        ]);

        $modificationField = ModificationField::with('service')
                            ->findOrFail($validated['modification_field_id']);

        $servicePrice = $modificationField->getPriceForUserType($user->role);

        if ($servicePrice === null) {
            return back()->with(['status' => 'error', 'message' => 'Service price not configured for your user type.'])->withInput();
        }

        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();

        if ($wallet->status !== 'active') {
            return back()->with(['status' => 'error', 'message' => 'Your wallet is not active.'])->withInput();
        }

        if ($wallet->wallet_balance < $servicePrice) {
            return back()->with([
                'status' => 'error',
                'message' => 'Insufficient wallet balance. You need NGN ' . number_format($servicePrice - $wallet->wallet_balance, 2) . ' more.'
            ])->withInput();
        }

        $apiResponse = Http::withHeaders([
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'x-api-key' => env('PREMBLY_API_KEY'),
            'app-id' => env('PREMBLY_APP_ID'),
        ])->post('https://api.prembly.com/identitypass/verification/bvn_with_phone', [
            'number' => $validated['number']
        ]);

        if ($apiResponse->status() !== 200 || $apiResponse['status'] !== true) {
            return back()->with([
                'status' => 'error',
                'message' => 'BVN search failed. No charge applied. Reason: ' . ($apiResponse['detail'] ?? 'NO BVN Link to phone number')
            ])->withInput();
        }

        $bvnData = $apiResponse['data'];
        $verification = $apiResponse['verification'] ?? [];

        DB::beginTransaction();

        try {
            $transactionRef = 'PNS-' . (time() % 1000000000) . '-' . mt_rand(100, 999);

            $transaction = Transaction::create([
                'transaction_ref' => $transactionRef,
                'user_id' => $user->id,
                'amount' => $servicePrice,
                'description' => "BVN Search for {$modificationField->field_name}",
                'type' => 'debit',
                'status' => 'completed',
                'metadata' => [
                    'service' => 'number',
                    'modification_field' => $modificationField->field_name,
                    'field_code' => $modificationField->field_code,
                    'number' => $validated['number'],
                    'api_verification' => $verification,
                    'user_role' => $user->role,
                    'price_details' => [
                        'base_price' => $modificationField->base_price,
                        'user_price' => $servicePrice,
                    ],
                ],
            ]);

            PhoneSearch::create([
                'reference' => $transactionRef,
                'user_id' => $user->id,
                'modification_field_id' => $modificationField->id,
                'service_id' => $modificationField->service_id,
                'number' => $validated['number'],
                'transaction_id' => $transaction->id,
                'submission_date' => now(),
                'status' => 'resolved',
                'bvn' => $bvnData['bvn'],
                'first_name' => $bvnData['firstName'] ?? null,
                'last_name' => $bvnData['lastName'] ?? null,
                'middle_name' => $bvnData['middleName'] ?? null,
                'gender' => $bvnData['gender'] ?? null,
                'dob' => $bvnData['dateOfBirth'] ?? null,
                'lga' => $bvnData['lgaOfOrigin'] ?? null,
                'state' => $bvnData['stateOfOrigin'] ?? null,
                'email' => $bvnData['email'] ?? null,
                'comment' => $bvnData['comment'] ?? null,
            ]);

            $wallet->decrement('wallet_balance', $servicePrice);

            DB::commit();

            return redirect()->route('phone.search.index')->with([
                'status' => 'success',
                'message' => 'BVN search successful. Reference: ' . $transactionRef . '. Charged: NGN ' . number_format($servicePrice, 2),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);

            return back()->with(['status' => 'error', 'message' => 'Submission failed: ' . $e->getMessage()])->withInput();
        }
    }
}
