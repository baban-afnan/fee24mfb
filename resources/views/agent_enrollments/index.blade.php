<x-app-layout>


<div class="container">
    <div class="logo text-center mb-3">
        <a href="/"><img src="{{ asset('logo2.png') }}" alt="Zepa Logo" style="max-width: 70px;"></a>
    </div>

    <h2 class="text-center text-danger"><i class="fa-solid fa-user-shield"></i> Agent Enrollment Records</h2>

    <form method="GET" action="{{ route('enrollments.index') }}" class="text-center my-3">
        <input type="text" name="agent_code" placeholder="Enter Agent Code" value="{{ $agentCode }}" required class="form-control d-inline-block w-auto">
        <button type="submit" class="btn btn-danger"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
    </form>

    @if ($agentCode && $agentInfo)
        <div class="info-box bg-light p-3 border-left border-danger mb-3">
            <div><strong>Agent Name:</strong> {{ $agentInfo->agent_name }}</div>
            <div><strong>Agent Code:</strong> {{ $agentInfo->agent_code }}</div>
        </div>

        <table id="recordsTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Ticket #</th>
                    <th>BVN</th>
                    <th>BMS ID</th>
                    <th>Validation Status</th>
                    <th>Validation Message</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    @elseif($agentCode)
        <p class="text-center text-muted">No records found for this Agent Code.</p>
    @endif
</div>


@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
@if ($agentCode && $agentInfo)
$('#recordsTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "{{ route('enrollments.data') }}",
        data: {
            agent_code: "{{ $agentCode }}"
        }
    },
    columns: [
        { data: 'ticket_number' },
        { data: 'bvn' },
        { data: 'bms_import_id' },
        { data: 'validation_status' },
        { data: 'validation_message' },
        { data: 'action', orderable: false, searchable: false }
    ]
});
@endif
</script>
@endpush

</x-app-layout>
