<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\ModificationField;
use App\Models\Ninverification;
use App\Models\Transaction;
use App\Models\Service;
use App\Models\Wallet;

class NINverificationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Ninverification::with(['modificationField', 'transaction'])
                    ->where('user_id', $user->id);

        if ($request->filled('search')) {
            $query->where('nin', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $crmSubmissions = $query->orderByDesc('submission_date')
                            ->paginate(10)
                            ->withQueryString();

        $ninService = Service::where('name', 'Verification of NIN')
                        ->where('is_active', true)
                        ->first();

        $modificationFields = $ninService 
            ? $ninService->modificationFields()
                ->where('is_active', true)
                ->get()
            : collect();

        return view('nin-verification', [
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
            'nin' => 'required|string|size:11|regex:/^[0-9]{11}$/',
        ]);

        $modificationField = ModificationField::with('service')
                            ->findOrFail($validated['modification_field_id']);

        $servicePrice = $modificationField->getPriceForUserType($user->role);

        if ($servicePrice === null) {
            return back()->with([
                'status' => 'error',
                'message' => 'Service price not configured for your user type.'
            ])->withInput();
        }

        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();

        if ($wallet->status !== 'active') {
            return back()->with([
                'status' => 'error',
                'message' => 'Your wallet is not active.'
            ])->withInput();
        }

        if ($wallet->wallet_balance < $servicePrice) {
            return back()->with([
                'status' => 'error',
                'message' => 'Insufficient wallet balance. You need NGN ' . nin_format($servicePrice - $wallet->wallet_balance, 2) . ' more.'
            ])->withInput();
        }

        // Call external API
        $apiResponse = Http::withHeaders([
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'x-api-key' => env('PREMBLY_API_KEY'),
            'app-id' => env('PREMBLY_APP_ID'),
        ])->post('https://api.prembly.com/identitypass/verification/vnin', [
            'nin' => $validated['nin']
        ]);

        $responseData = $apiResponse->json();

        if ($apiResponse->status() !== 200 || ($responseData['status'] ?? false) !== true) {
            return back()->with([
                'status' => 'error',
                'message' => 'NIN search failed. No charge applied. Reason: ' . ($responseData['detail'] ?? '400')
            ])->withInput();
        }

        $ninData = $responseData['data'] ?? [];
        $verification = $responseData['verification'] ?? [];

        DB::beginTransaction();

        try {
            $transactionRef = 'Ver-' . (time() % 1000000000) . '-' . mt_rand(100, 999);

            $transaction = Transaction::create([
                'transaction_ref' => $transactionRef,
                'user_id' => $user->id,
                'amount' => $servicePrice,
                'description' => "NIN Search for {$modificationField->field_name}",
                'type' => 'debit',
                'status' => 'completed',
                'metadata' => [
                    'service' => 'nin',
                    'modification_field' => $modificationField->field_name,
                    'field_code' => $modificationField->field_code,
                    'nin' => $validated['nin'],
                    'api_verification' => $verification,
                    'user_role' => $user->role,
                    'price_details' => [
                        'base_price' => $modificationField->base_price,
                        'user_price' => $servicePrice,
                    ],
                ],
            ]);

            Ninverification::create([
                'reference' => $transactionRef,
                'user_id' => $user->id,
                'modification_field_id' => $modificationField->id,
                'service_id' => $modificationField->service_id,
                'nin' => $validated['nin'],
                'transaction_id' => $transaction->id,
                'submission_date' => now(),
                'status' => 'resolved',
                'first_name' => $ninData['firstName'] ?? null,
                'last_name' => $ninData['lastName'] ?? null,
                'middle_name' => $ninData['middleName'] ?? null,
                'gender' => $ninData['gender'] ?? null,
                'dob' => $ninData['dateOfBirth'] ?? null,
                'lga' => $ninData['lgaOfOrigin'] ?? null,
                'state' => $ninData['stateOfOrigin'] ?? null,
                'email' => $ninData['email'] ?? null,
                'comment' => $ninData['comment'] ?? null,
            ]);

            $wallet->decrement('wallet_balance', $servicePrice);

            DB::commit();

            return redirect()->route('phone.search.index')->with([
                'status' => 'success',
                'message' => 'NIN search successful. Reference: ' . $transactionRef . '. Charged: NGN ' . nin_format($servicePrice, 2),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            report($e);

            return back()->with([
                'status' => 'error',
                'message' => 'Submission failed: ' . $e->getMessage()
            ])->withInput();
        }
    }
}
