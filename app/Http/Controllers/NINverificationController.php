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
            ? $ninService->modificationFields()->where('is_active', true)->get()
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
            'number_nin' => 'required|string|size:11|regex:/^[0-9]{11}$/',
        ]);

        $modificationField = ModificationField::with('service')->findOrFail($validated['modification_field_id']);
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
                'message' => 'Insufficient wallet balance. You need NGN ' . number_format($servicePrice - $wallet->wallet_balance, 2)
            ])->withInput();
        }

        // Call external API
        try {
            $apiResponse = Http::timeout(30)->withHeaders([
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'x-api-key' => env('PREMBLY_API_KEY'),
                'app-id' => env('PREMBLY_APP_ID'),
            ])->post('https://api.prembly.com/identitypass/verification/vnin', [
                'number_nin' => $validated['number_nin']
            ]);
        } catch (\Exception $e) {
            return back()->with([
                'status' => 'error',
                'message' => 'API connection failed: ' . $e->getMessage()
            ])->withInput();
        }

        $responseData = $apiResponse->json();

        if ($apiResponse->status() !== 200 || ($responseData['status'] ?? false) !== true) {
            return back()->with([
                'status' => 'error',
                'message' => 'NIN verification failed: ' . ($responseData['detail'] ?? 'Unknown error')
            ])->withInput();
        }

        $ninData = $responseData['nin_data'] ?? [];

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
                    'nin' => $validated['number_nin'],
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
                'firstname' => $ninData['firstname'] ?? null,
                'middlename' => $ninData['middlename'] ?? null,
                'surname' => $ninData['surname'] ?? null,
                'gender' => $ninData['gender'] ?? null,
                'birthdate' => $ninData['birthdate'] ?? null,
                'birthstate' => $ninData['birthstate'] ?? null,
                'birthlga' => $ninData['birthlga'] ?? null,
                'birthcountry' => $ninData['birthcountry'] ?? null,
                'maritalstatus' => $ninData['maritalstatus'] ?? null,
                'email' => $ninData['email'] ?? null,
                'telephoneno' => $ninData['telephoneno'] ?? null,
                'residence_address' => $ninData['residence_address'] ?? null,
                'residence_state' => $ninData['residence_state'] ?? null,
                'residence_lga' => $ninData['residence_lga'] ?? null,
                'residence_town' => $ninData['residence_town'] ?? null,
                'religion' => $ninData['religion'] ?? null,
                'employmentstatus' => $ninData['employmentstatus'] ?? null,
                'educationallevel' => $ninData['educationallevel'] ?? null,
                'profession' => $ninData['profession'] ?? null,
                'heigth' => $ninData['heigth'] ?? null,
                'title' => $ninData['title'] ?? null,
                'number_nin' => $validated['number_nin'],
                'vnin' => $ninData['vnin'] ?? null,
                'photo_path' => $ninData['photo'] ?? null,
                'signature_path' => $ninData['signature'] ?? null,
                'trackingId' => $ninData['trackingId'] ?? null,
                'userid' => $ninData['userid'] ?? null,
                'nok_firstname' => $ninData['nok_firstname'] ?? null,
                'nok_middlename' => $ninData['nok_middlename'] ?? null,
                'nok_surname' => $ninData['nok_surname'] ?? null,
                'nok_address1' => $ninData['nok_address1'] ?? null,
                'nok_address2' => $ninData['nok_address2'] ?? null,
                'nok_lga' => $ninData['nok_lga'] ?? null,
                'nok_state' => $ninData['nok_state'] ?? null,
                'nok_town' => $ninData['nok_town'] ?? null,
                'nok_postalcode' => $ninData['nok_postalcode'] ?? null,
                'self_origin_state' => $ninData['self_origin_state'] ?? null,
                'self_origin_lga' => $ninData['self_origin_lga'] ?? null,
                'self_origin_place' => $ninData['self_origin_place'] ?? null,
                'transaction_id' => $transaction->id,
                'submission_date' => now(),
                'status' => 'resolved',
            ]);

            $wallet->decrement('wallet_balance', $servicePrice);

            DB::commit();

            return redirect()->route('nin.verification.index')->with([
                'status' => 'success',
                'message' => 'NIN search successful. Reference: ' . $transactionRef . '. Charged: NGN ' . number_format($servicePrice, 2),
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
