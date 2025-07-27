<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Filters
        $search = $request->input('search_transaction_id');
        $recordType = $request->input('record_type');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // Base query
        $transactionsQuery = Transaction::where('user_id', $user->id);

        if ($search) {
            $transactionsQuery->where('transaction_ref', 'like', "%{$search}%");
        }

        if ($recordType) {
            $transactionsQuery->where('type', $recordType);
        }

        if ($fromDate && $toDate) {
            $transactionsQuery->whereBetween('created_at', [$fromDate, $toDate]);
        } elseif ($fromDate) {
            $transactionsQuery->whereDate('created_at', '>=', $fromDate);
        } elseif ($toDate) {
            $transactionsQuery->whereDate('created_at', '<=', $toDate);
        }

        $transactions = $transactionsQuery->orderBy('created_at', 'desc')->paginate(10);

        // Calculate total balance
        $totalAmount = Transaction::where('user_id', $user->id)->get()->sum(function ($txn) {
            return $txn->type === 'credit' ? $txn->amount : -$txn->amount;
        });

        return view('transactions', [
            'transactions' => $transactions,
            'totalAmount' => $totalAmount,
            'search' => $search,
            'recordType' => $recordType,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
        ]);
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();

        // Filter logic
        $transactionsQuery = Transaction::where('user_id', $user->id);

        if ($request->filled('search_transaction_id')) {
            $transactionsQuery->where('transaction_ref', 'like', '%' . $request->input('search_transaction_id') . '%');
        }

        if ($request->filled('record_type')) {
            $transactionsQuery->where('type', $request->input('record_type'));
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $transactionsQuery->whereBetween('created_at', [$request->input('from_date'), $request->input('to_date')]);
        } elseif ($request->filled('from_date')) {
            $transactionsQuery->whereDate('created_at', '>=', $request->input('from_date'));
        } elseif ($request->filled('to_date')) {
            $transactionsQuery->whereDate('created_at', '<=', $request->input('to_date'));
        }

        $transactions = $transactionsQuery->latest()->get();

        // Balance summary
        $totalAmount = $transactions->sum(function ($txn) {
            return $txn->type === 'credit' ? $txn->amount : -$txn->amount;
        });

        // Generate PDF
        $pdf = Pdf::loadView('pdf', [
            'transactions' => $transactions,
            'totalAmount' => $totalAmount,
            'user' => $user,
        ])->setPaper('A4', 'portrait');

        return $pdf->download('transaction_history.pdf');
    }
}
