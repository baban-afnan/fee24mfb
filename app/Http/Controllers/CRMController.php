<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ModificationField;
use App\Models\CRMSubmission;
use App\Models\Transaction;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;

class CRMController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = CRMSubmission::with(['modificationField', 'transaction'])
                    ->where('user_id', $user->id);

        if ($request->filled('search')) {
            $query->where('ticket_id', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $crmSubmissions = $query->orderByDesc('submission_date')
                            ->paginate(3)
                            ->withQueryString();

        $bvnService = Service::where('name', 'CRM')
                        ->where('is_active', true)
                        ->first();

        $modificationFields = $bvnService 
            ? $bvnService->modificationFields()
                ->where('is_active', true)
                ->get()
            : collect();

        return view('bvn-crm', [
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
        'batch_id' => 'required|string|size:7|regex:/^[0-9]{7}$/',
        'ticket_id' => 'required|string|size:8|regex:/^[0-9]{8}$/',
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
            $reference = 'CRM-' . time() . '-' . mt_rand(100, 999);

            // Create transaction record
             // Create transaction record
        $transaction = Transaction::create([
            'transaction_ref' => $reference,
            'user_id' => $user->id,
            'amount' => $servicePrice,
            'description' => "BVN CRM Request for {$modificationField->field_name}",
            'type' => 'debit',
            'status' => 'completed',
            'metadata' => [
                'service' => 'BVN_CRM',
                'modification_field' => $modificationField->field_name,
                'ticket_id' => $validated['ticket_id'],
                'batch_id' => $validated['batch_id'],
            ],
        ]);

        // Create BVN CRM record with ALL required fields
        CRMSubmission::create([
            'reference' => $reference,
            'user_id' => $user->id,
            'modification_field_id' => $modificationField->id,
            'service_id' => $modificationField->service_id,
            'ticket_id' => $validated['ticket_id'],
            'batch_id' => $validated['batch_id'],
            'transaction_id' => $transaction->id,
            'submission_date' => now(), // Make sure this is included
            'status' => 'pending',
        ]);


            // Debit wallet
            $wallet->decrement('wallet_balance', $servicePrice);

            DB::commit();

            return redirect()->route('bvn-crm')->with([
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