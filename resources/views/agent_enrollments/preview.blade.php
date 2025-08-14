@extends('x-app-layout')

@section('content')
<div class="container">
    <h3>Enrollment Preview</h3>
    <ul>
        <li><strong>Ticket:</strong> {{ $record->ticket_number }}</li>
        <li><strong>BVN:</strong> {{ $record->bvn }}</li>
        <li><strong>BMS ID:</strong> {{ $record->bms_import_id }}</li>
        <li><strong>Status:</strong> {{ $record->validation_status }}</li>
        <li><strong>Message:</strong> {{ $record->validation_message }}</li>
    </ul>
</div>
@endsection
