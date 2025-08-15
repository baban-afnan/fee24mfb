<x-app-layout>
    <x-slot name="title">Transaction History</x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Error:</strong> {{ session('error') }}
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                @endif

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <div class="mb-2 mb-md-0">
                            <h5 class="fw-bold text-primary mb-1">
                                <i class="fas fa-exchange-alt me-2"></i> Transaction Records
                            </h5>
                            <p class="text-muted small mb-0">Your complete financial activity history</p>
                        </div>
                        <div class="d-flex flex-column align-items-end">
                            <div class="badge bg-light text-dark fs-6 mb-2 px-3 py-2">
                                <i class="fas fa-wallet text-primary me-2"></i>
                                <span class=" text-primary fs-6">
                                Balance: ₦{{ number_format($totalAmount, 2) }}
                                 </span>
                            </div>
                            <a href="{{ route('transactions.export.pdf', request()->query()) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-file-pdf me-1"></i> Export PDF
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Filter Section -->
                        <div class="card mb-4 shadow-sm border-0">
                            <div class="card-body">
                                <form method="GET" class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label small text-muted">Transaction Reference</label>
                                        <input type="text" name="search_transaction_id" class="form-control form-control-sm" 
                                               placeholder="Search by Transaction Ref..." value="{{ request('search_transaction_id') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small text-muted">From Date</label>
                                        <input type="date" name="from_date" class="form-control form-control-sm" value="{{ request('from_date') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small text-muted">To Date</label>
                                        <input type="date" name="to_date" class="form-control form-control-sm" value="{{ request('to_date') }}">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <div class="d-flex gap-2 w-100">
                                            <button type="submit" class="btn btn-primary btn-sm flex-grow-1">
                                                <i class="fas fa-filter me-1"></i> Filter
                                            </button>
                                            <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary btn-sm">
                                                <i class="fas fa-sync-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Transaction Type Tabs -->
                        <div class="mb-4">
                            <ul class="nav nav-tabs nav-tabs-custom" id="transactionTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ is_null($recordType) ? 'active' : '' }}" 
                                       href="{{ route('transactions.index') }}">
                                        All Transactions
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ $recordType === 'credit' ? 'active' : '' }}" 
                                       href="{{ route('transactions.index', array_merge(request()->except('record_type'), ['record_type' => 'credit'])) }}">
                                        <i class="fas fa-arrow-down text-success me-1"></i> Credits
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ $recordType === 'debit' ? 'active' : '' }}" 
                                       href="{{ route('transactions.index', array_merge(request()->except('record_type'), ['record_type' => 'debit'])) }}">
                                        <i class="fas fa-arrow-up text-danger me-1"></i> Debits
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Transactions Table -->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-bold">ID</th>
                                        <th class="fw-bold">Reference</th>
                                        <th class="fw-bold text-end">Amount</th>
                                        <th class="fw-bold">Description</th>
                                        <th class="fw-bold">Type</th>
                                        <th class="fw-bold">Status</th>
                                        <th class="fw-bold">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $txn)
                                        <tr class="transaction-row">
                                            <td class="text-muted">#{{ $txn->id }}</td>
                                            <td>
                                                <span class="text-monospace">{{ $txn->transaction_ref }}</span>
                                            </td>
                                            <td class="text-end fw-bold {{ $txn->type === 'credit' || $txn->type === 'refund' ? 'text-success' : 'text-danger' }}">
                                                ₦{{ number_format($txn->amount, 2) }}
                                            </td>
                                            <td>{{ Str::limit($txn->description, 40) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $txn->type === 'credit' ? 'success-light text-success' : ($txn->type === 'refund' ? 'primary-light text-primary' : 'danger-light text-danger') }}">
                                                    {{ ucfirst($txn->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $txn->status === 'successful' || $txn->status === 'completed' ? 'success-light text-success' : ($txn->status === 'pending' ? 'warning-light text-warning' : 'danger-light text-danger') }}">
                                                    {{ ucfirst($txn->status) }}
                                                </span>
                                            </td>
                                            <td class="text-muted small">{{ $txn->created_at->format('M j, Y g:i A') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">No transactions found</h5>
                                                    <p class="text-muted small">Your transaction history will appear here</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($transactions->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $transactions->withQueryString()->links("vendor.pagination.bootstrap-5") }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('styles')
    <style>
        /* Transaction Page Specific Styles */
        .nav-tabs-custom .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 0.5rem 1rem;
            margin-right: 0.5rem;
            border-radius: 0.375rem;
        }
        .nav-tabs-custom .nav-link.active {
            color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.1);
            border-bottom: 2px solid #0d6efd;
        }
        .nav-tabs-custom .nav-link:hover:not(.active) {
            background-color: #f8f9fa;
        }
        
        /* Table styling */
        .transaction-row:hover {
            background-color: #f8fafc;
        }
        
        /* Badge variants */
        .bg-success-light {
            background-color: rgba(25, 135, 84, 0.1);
        }
        .bg-danger-light {
            background-color: rgba(220, 53, 69, 0.1);
        }
        .bg-warning-light {
            background-color: rgba(255, 193, 7, 0.1);
        }
        .bg-primary-light {
            background-color: rgba(13, 110, 253, 0.1);
        }
        
        /* Text monospace for reference numbers */
        .text-monospace {
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 0.875rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .card-header > div {
                margin-top: 0.5rem;
            }
        }
    </style>
    @endpush
</x-app-layout>