<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ModificationField;
use App\Models\BvnUser;
use App\Models\Transaction;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;

class BvnUserController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = BvnUser::with(['modificationField', 'transaction'])
                    ->where('user_id', $user->id);

        if ($request->filled('search')) {
            $query->where('bvn', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $crmSubmissions = $query->orderByDesc('submission_date')
                            ->paginate(3)
                            ->withQueryString();

        $bvnService = Service::where('name', 'BVN USER')
                        ->where('is_active', true)
                        ->first();

                      

        $modificationFields = $bvnService 
            ? $bvnService->modificationFields()
                ->where('is_active', true)
                ->get()
            : collect();


        return view('bvn-user', [
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
    'bvn' => 'required|string|size:11|regex:/^[0-9]{11}$/',
    'first_name' => 'required|string|max:500',
    'last_name' => 'required|string|max:500',
    'middle_name' => 'nullable|string|max:500', 
    'account_no' => 'required|string|max:500',
    'bank_name' => 'required|string|max:500',
    'account_name' => 'required|string|max:500',
    'email' => 'required|string|max:500',
    'phone_no' => 'required|string|max:500',
    'dob' => 'required|string|max:500',
    'state' => 'required|string|max:500',
    'lga' => 'required|string|max:500',
    'address' => 'required|string|max:500',
    'agent_location' => 'required|string|max:500',
]);

// 🔐 Check if email already exists
if (BvnUser::where('email', $request->email)->exists()) {
    return redirect()->route('bvn.index')->with([
        'status' => 'error',
        'message' => 'This email has already been used for a BVN User request.'
    ]);
}

// 🔐 Check if phone_no already exists
if (BvnUser::where('phone_no', $request->phone_no)->exists()) {
    return redirect()->route('bvn.index')->with([
        'status' => 'error',
        'message' => 'This phone number has already been used for a BVN User request.'
    ]);
}



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
                'message' => 'Insufficient wallet balance. You need NGN ' . 
                    number_format($servicePrice - $wallet->wallet_balance, 2) . ' more.'
            ])->withInput();
        }

        DB::beginTransaction();

        try {
            // Generate a unique reference
            $transactionRef = 'AGN-' . time() % 1000000000 . '-' . mt_rand(100, 999);

            // Create transaction record
            $transaction = Transaction::create([
                'transaction_ref' => $transactionRef,
                'user_id' => $user->id,
                'amount' => $servicePrice,
                'description' => "BVN User for {$modificationField->field_name}",
                'type' => 'debit',
                'status' => 'completed',
                'metadata' => [
                    'service' => 'BVN USER',
                    'modification_field' => $modificationField->field_name,
                    'field_code' => $modificationField->field_code,
                    'bvn' => $validated['bvn'],
                    'user_role' => $user->role,
                    'price_details' => [
                        'base_price' => $modificationField->base_price,
                        'user_price' => $servicePrice,
                    ],
                ],
            ]);

            // Create NIN modification record
            Bvnuser::create([
                'reference' => $transactionRef,
                'user_id' => $user->id,
                'modification_field_id' => $modificationField->id,
                'service_id' => $modificationField->service_id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'middle_name' => $validated['middle_name'],
                'bvn' => $validated['bvn'],
                'account_no' => $validated['account_no'],
                'bank_name' => $validated['bank_name'],
                'account_name' => $validated['account_name'],
                'email' => $validated['email'],
                'phone_no' => $validated['phone_no'],
                'dob' => $validated['dob'],
                'state' => $validated['state'],
                'lga' => $validated['lga'],
                'address' => $validated['address'],
                'agent_location' => $validated['agent_location'],
                'transaction_id' => $transaction->id,
                'submission_date' => now(),
                'status' => 'pending',
            ]);

            // Debit wallet
            $wallet->decrement('wallet_balance', $servicePrice);

            DB::commit();

            return redirect()->route('bvn.index')->with([
                'status' => 'success',
                'message' => 'BVN User Request was Successfully. Reference: ' . $transactionRef . 
                             '. Charged: NGN ' . number_format($servicePrice, 2),
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

    public function getFieldPrice(Request $request)
    {
        $request->validate([
            'field_id' => 'required|exists:modification_fields,id'
        ]);

        $user = Auth::user();
        $field = ModificationField::findOrFail($request->field_id);
        
        return response()->json([
            'success' => true,
            'price' => $field->getPriceForUserType($user->role),
            'formatted_price' => 'NGN ' . number_format($field->getPriceForUserType($user->role), 2),
            'field_name' => $field->field_name,
            'description' => $field->description,
            'base_price' => $field->base_price,
        ]);
    }

    public function showDetails($id)
    {
        try {
            $submission = NinModification::with([
                'modificationField',
                'transaction',
                'user'
            ])->findOrFail($id);

            // Authorization check
            if (auth()->id() !== $submission->user_id && !auth()->user()->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to submission details'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'submission' => $submission,
                'field_name' => $submission->modificationField->field_name,
                'field_description' => $submission->modificationField->description
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Submission not found or error occurred'
            ], 404);
        }
    }
}

