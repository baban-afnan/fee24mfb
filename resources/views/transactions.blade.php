<x-app-layout>
    <x-slot name="title">Transaction History</x-slot>

    <div class="container-fluid row">
        <div class="col-12">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Error:</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Transaction Records</h6>
                    <div class="text-end">
                        <h6 class="m-0 font-weight-bold text-primary">Balance: ₦{{ number_format($totalAmount, 2) }}</h6>
                        <a href="{{ route('transactions.export.pdf', request()->query()) }}" class="btn btn-outline-primary btn-sm mt-2">
                            <i class="fas fa-file-pdf"></i> Download PDF
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="GET" class="row g-3 mb-3">
                        <div class="col-md-3">
                            <input type="text" name="search_transaction_id" class="form-control" placeholder="Search by Transaction Ref..." value="{{ request('search_transaction_id') }}">
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>
                        <div class="col-md-3 text-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="mb-3 d-flex justify-content-end">
                        <div class="btn-group">
                            <a href="{{ route('transactions.index', array_merge(request()->except('record_type'), ['record_type' => 'credit'])) }}" class="btn btn-outline-success {{ $recordType === 'credit' ? 'active' : '' }}">Credits</a>
                            <a href="{{ route('transactions.index', array_merge(request()->except('record_type'), ['record_type' => 'debit'])) }}" class="btn btn-outline-danger {{ $recordType === 'debit' ? 'active' : '' }}">Debits</a>
                            <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary {{ is_null($recordType) ? 'active' : '' }}">All</a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Amount</th>
                                    <th>Transaction Ref</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $txn)
                                    <tr>
                                        <td>{{ $txn->id }}</td>
                                        <td>₦{{ number_format($txn->amount, 2) }}</td>
                                        <td>{{ $txn->transaction_ref }}</td>
                                        <td>{{ $txn->description }}</td>
                                        <td>
                                            <span class="badge bg-{{ $txn->type === 'credit' ? 'success' : 'danger' }}">
                                                {{ ucfirst($txn->type) }}
                                            </span>
                                        </td>
                                        <td>{{ ucfirst($txn->status) }}</td>
                                        <td>{{ $txn->created_at->format('M j, Y g:i A') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">No transactions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

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
</x-app-layout>
