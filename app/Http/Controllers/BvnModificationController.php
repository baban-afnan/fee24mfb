<?php

namespace App\Http\Controllers;

use App\Models\AvailableBank;
use App\Models\ModificationField;
use App\Models\BvnModification;
use App\Models\Transaction;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BvnModificationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Fetch all bank services (banks are stored in services table)
        $bankServices = Service::with(['modificationFields' => function ($query) {
            $query->where('is_active', 1);
        }])->where('name', 'like', '%Bank')->get();

        $query = BvnModification::where('user_id', $user->id);

        if ($request->filled('search')) {
            $query->where('bvn', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $crmSubmissions = $query->orderByDesc('submission_date')->paginate(10)->withQueryString();

        return view('modification', [
            'banks' => AvailableBank::all(),
            'crmSubmissions' => $crmSubmissions,
            'bankServices' => $bankServices,
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'enrolment_bank'     => 'required|exists:services,id',
            'modification_field' => 'required|exists:modification_fields,id',
            'bvn'                => 'required|string|size:11',
            'nin'                => 'required|string|size:11',
            'description'        => 'required|string',
            'affidavit'          => 'required|in:available,not_available',
            'affidavit_file'     => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $wallet = $user->wallet;
        if (!$wallet || $wallet->status !== 'active') {
            return redirect()->route('modification')->withErrors(['wallet' => 'Wallet not found or not active.'])->withInput();
        }

        $role = $user->role ?? 'user';

        // Fetch selected modification field
        $modificationField = ModificationField::findOrFail($validated['modification_field']);
        $modificationFee = $modificationField->getPriceForUserType($role);

        // Fetch affidavit field
        $affidavitField = ModificationField::where('field_name', 'Affidavit')->first();
        if (!$affidavitField) {
            return redirect()->route('modification')->withErrors(['affidavit' => 'Affidavit field not found in the database.'])->withInput();
        }

        $affidavitFee = $affidavitField->getPriceForUserType($role);

        $affidavitUploaded = $request->hasFile('affidavit_file');
        $chargeAffidavit = !$affidavitUploaded;

        $totalAmount = $modificationFee + ($chargeAffidavit ? $affidavitFee : 0);

        if ($wallet->wallet_balance < $totalAmount) {
            $msg = "Insufficient wallet balance. Required: NGN " . number_format($totalAmount, 2);
            return redirect()->route('modification')->withErrors(['wallet' => $msg])->withInput();
        }

        DB::beginTransaction();

        try {
            // Handle affidavit file upload
            $fileName = null;
            if ($affidavitUploaded) {
                $file = $request->file('affidavit_file');
                $fileName = 'affidavit_' . Str::slug($user->email) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/affidavits'), $fileName);
            }

            // Debit wallet
            $wallet->decrement('wallet_balance', $totalAmount);

            $transactionRef = 'MOD-' . time() . '-' . mt_rand(100, 999);

            $performedBy = auth()->check() ? auth()->user()->first_name . ' ' . auth()->user()->last_name : 'System';

            $transaction = Transaction::create([
                'transaction_ref' => $transactionRef,
                'user_id'         => $user->id,
                'amount'          => $totalAmount,
                'description'     => "BVN modification for {$modificationField->field_name}",
                'type'            => 'debit',
                'status'          => 'completed',
                'performed_by'    => $performedBy, 
                'metadata'        => [
                    'service' => 'BVN',
                    'modification_field' => $modificationField->field_name,
                    'field_code' => $modificationField->field_code,
                    'bvn' => $validated['bvn'],
                    'user_role' => $user->role,
                    'price_details' => [
                        'modification_fee' => $modificationFee,
                        'affidavit_fee' => $chargeAffidavit ? $affidavitFee : 0,
                        'performed_by' => $performedBy,
                    ],
                ],
            ]);

            // Save BVN modification
            BvnModification::create([
                'reference'             => $transactionRef,
                'user_id'               => $user->id,
                'modification_field_id' => $modificationField->id,
                'service_id'            => $validated['enrolment_bank'],
                'bvn'                   => $validated['bvn'],
                'nin'                   => $validated['nin'],
                'description'           => $validated['description'],
                'affidavit_file'        => $fileName,
                'affidavit'             => $validated['affidavit'],
                'affidavit_file_url'    => $fileName ? asset('uploads/affidavits/' . $fileName) : null,
                'transaction_id'        => $transaction->id,
                'submission_date'       => now(),
                'status'                => 'pending',
                'comment'               => null,
            ]);

            DB::commit();

            $msg = "BVN Modification Submitted Successfully. Charged: NGN " . number_format($modificationFee, 2);
            if ($chargeAffidavit) {
                $msg .= " + NGN " . number_format($affidavitFee, 2) . " (affidavit fee)";
            }
            $msg .= " = NGN " . number_format($totalAmount, 2);

            return redirect()->route('modification')->with([
                'status' => 'success',
                'message' => $msg
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($fileName) && file_exists(public_path('uploads/affidavits/' . $fileName))) {
                @unlink(public_path('uploads/affidavits/' . $fileName));
            }

            return redirect()->route('modification')->withErrors([
                'error' => 'Something went wrong: ' . $e->getMessage()
            ])->withInput();
        }
    }

    // AJAX: Fetch modification fields for selected bank/service
    public function getModificationFields($serviceId)
    {
        $role = auth()->user()->role ?? 'user';

        $fields = ModificationField::where('service_id', $serviceId)
            ->where('is_active', 1)
            ->get()
            ->map(function ($field) use ($role) {
                return [
                    'id' => $field->id,
                    'field_name' => $field->field_name,
                    'description' => $field->description,
                    'price' => $field->getPriceForUserType($role),
                ];
            });

        return response()->json($fields);
    }
}