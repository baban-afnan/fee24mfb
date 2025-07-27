<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ModificationField;
use App\Models\SendVnin;
use App\Models\Transaction;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;

class SendVninController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = SendVnin::with(['modificationField', 'transaction'])
                    ->where('user_id', $user->id);

        if ($request->filled('search')) {
            $query->where('request_id', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $crmSubmissions = $query->orderByDesc('submission_date')
                            ->paginate(3)
                            ->withQueryString();

        $bvnService = Service::where('name', 'VNIN TO NIBSS')
                        ->where('is_active', true)
                        ->first();

        $modificationFields = $bvnService 
            ? $bvnService->modificationFields()
                ->where('is_active', true)
                ->get()
            : collect();

        return view('send-vnin', [
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
        'request_id' => 'required|string|size:7|regex:/^[0-9]{7}$/',
        'bvn' => 'required|string|size:11|regex:/^[0-9]{11}$/',
        'nin' => 'required|string|size:11|regex:/^[0-9]{11}$/',
        'field' => 'required',
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
                'message' => 'Insufficient wallet balance. You need NGN ' . 
                    number_format($servicePrice - $wallet->wallet_balance, 2) . ' more.'
            ])->withInput();
        }

        DB::beginTransaction();

        try {
            // Generate a unique reference
            $reference = 'VNIN-' . time() . '-' . mt_rand(100, 999);

            
             // Create transaction record
        $transaction = Transaction::create([
             'transaction_ref' => $reference,
                'user_id' => $user->id,
                'amount' => $servicePrice,
                'description' => "IPE for {$modificationField->field_name}",
                'type' => 'debit',
                'status' => 'completed',
                'metadata' => [
                    'service' => 'Tracking_id',
                    'modification_field' => $modificationField->field_name,
                    'field_code' => $modificationField->field_code,
                    'request_id' => $validated['request_id'],
                    'user_role' => $user->role,
                    'price_details' => [
                        'base_price' => $modificationField->base_price,
                        'user_price' => $servicePrice,
                    ],
                ],
            ]);

        // Create BVN CRM record with ALL required fields
        SendVnin::create([
            'reference' => $reference,
            'user_id' => $user->id,
            'modification_field_id' => $modificationField->id,
            'service_id' => $modificationField->service_id,
             'request_id' => $validated['request_id'],
             'nin' => $validated['nin'],
             'bvn' => $validated['bvn'],
             'field' => $validated['field'],
            'transaction_id' => $transaction->id,
            'submission_date' => now(), // Make sure this is included
            'status' => 'pending',
        ]);


            // Debit wallet
            $wallet->decrement('wallet_balance', $servicePrice);

            DB::commit();

            return redirect()->route('send-vnin.index')->with([
                'status' => 'success',
                'message' => 'BVN CRM request was successfully submitted. Reference: ' . $reference . 
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
            'base_price' => $field->base_price,
        ]);
    }

    public function showDetails($id)
    {
        try {
            $submission = CRMSubmission::with([
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