<x-app-layout>
    <x-slot name="title">NIN Validation</x-slot>

    <div class="container-fluid">
        <div class="row">
            <!-- NIN Validation Form -->
            <div class="col-xl-6 mb-4">
                <div class="card">
                    <div class="card-header card-no-border pb-0">
                        <h3>NIN Validation Form</h3>
                        <p class="mt-1 mb-0">Request for NIN Validation. Note that the modification is treated based on NIBSS regulation.</p>

                        <!-- Message Display Section -->
                        @if (session('status'))
                            <div class="alert alert-{{ session('status') === 'success' ? 'success' : 'danger' }} alert-dismissible fade show mt-3" role="alert">
                                {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    </div>

                    <div class="card-body custom-input form-validation">
                        <form class="row g-3" method="POST" action="{{ route('validation.store') }}">
                            @csrf

                            <div class="col-12">
                                <label class="form-label">Select Modification Field <span class="text-danger">*</span></label>
                                <select class="form-control" name="modification_field_id" id="modification_field" required>
                                    <option value="">-- Select Modification Field --</option>
                                    @foreach ($modificationFields as $field)
                                        <option value="{{ $field->id }}" 
                                            data-price="{{ $field->getPriceForUserType(auth()->user()->role) }}"
                                            data-description="{{ $field->description }}"
                                            {{ old('modification_field_id') == $field->id ? 'selected' : '' }}>
                                            {{ $field->field_name }} - ₦{{ number_format($field->getPriceForUserType(auth()->user()->role), 2) }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted" id="field-description"></small>
                            </div>

                            <div class="col-12">
                                <label class="form-label">NIN ID <span class="text-danger">*</span></label>
                                 <button type="button" class="btn btn-outline-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#sampleInfoModal">
                                        <i class="bi bi-info-circle"></i> View Guidelines
                                    </button>
                                <input class="form-control" name="nin" type="text" required placeholder="Enter 11 Digit BVN number" maxlength="11" minlength="11" 
                                       pattern="[0-9]{11}" title="11-digit NIN number" 
                                       required value="{{ old('nin') }}">
                            </div>

                            <div class="col-12">
                                <div class="alert alert-info">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Service Fee:</span>
                                        <strong id="service-fee">₦0.00</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 checkbox-checked">
                                <div class="form-check">
                                    <input class="form-check-input" id="termsCheckbox" type="checkbox" required>
                                    <label class="form-check-label" for="termsCheckbox">
                                        I agree to the NIN Validation policies and confirm the information provided is accurate
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-send-fill me-2"></i> Submit Request
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Report Section -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header card-no-border pb-0">
                        <h3>Submission History</h3>
                    </div>
                    <div class="card-body">
                        <form class="row g-3" method="GET">
                            <div class="col-md-6">
                                <input class="form-control" name="search" type="text" placeholder="Search by NIN" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" name="status">
                                    <option value="">All Status</option>
                                    @foreach(['pending', 'processing', 'resolved', 'rejected'] as $status)
                                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary w-100" type="submit">Filter</button>
                            </div>
                        </form>

                        <div class="table-responsive mt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NIN</th>
                                        <th>Field</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($crmSubmissions as $index => $submission)
                                        <tr>
                                            <td>{{ $loop->iteration + $crmSubmissions->firstItem() - 1 }}</td>
                                            <td>{{ $submission->nin }}</td>
                                            <td>{{ $submission->modification_field_id }}</td>
                                            <td>
                                                <span class="badge bg-{{ match($submission->status) {
                                                    'resolved' => 'success',
                                                    'processing' => 'primary',
                                                    'rejected' => 'danger',
                                                    default => 'warning'
                                                } }}">{{ ucfirst($submission->status) }}</span>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-primary"
                                                    title="View Comment"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#commentModal"
                                                    data-comment="{{ $submission->comment ?? 'No comment yet.' }}">
                                                    <i class="bi bi-chat-left-text"></i> View
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No submissions found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                           </div>

                          <div class="mt-3">
                            {{ $crmSubmissions->withQueryString()->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Modal -->
    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-chat-left-text me-2"></i>Submission Comment</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="commentModalBody" style="font-size: 1rem; white-space: pre-wrap;">
                    Loading comment...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<!-- NIN Validation Guidelines Modal -->
<div class="modal fade" id="sampleInfoModal" tabindex="-1" aria-labelledby="sampleInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">NIN Verification Guidelines</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body px-4 py-4">
                <p class="fs-6 mb-3 text-muted">
                    Please read the following instructions carefully before submitting a request for NIN validation. Non-compliance may lead to rejection without refund.
                </p>

                <div class="bg-light p-4 rounded-3 mb-4 border-start border-4 border-primary">
                    <h6 class="fw-semibold mb-3 text-primary">
                        <i class="bi bi-info-circle-fill me-2"></i> Key Instructions
                    </h6>
                    <ul class="fs-6 mb-3 text-muted">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> All validations are processed and approved by <strong>NIMC</strong>.</li>
                        <li class="mb-2"><i class="bi bi-clock-fill text-warning me-2"></i> Validation takes <strong>2 to 3 working days</strong>, subject to NIMC’s response time.</li>
                        <li class="mb-2"><i class="bi bi-x-circle-fill text-danger me-2"></i> Requests with <strong>multiple NINs for the same person will be rejected</strong>.</li>
                        <li class="mb-2"><i class="bi bi-cash-stack text-danger me-2"></i> <strong>No refunds</strong> for rejected submissions due to multiple or fake NINs.</li>
                        <li class="mb-2"><i class="bi bi-exclamation-octagon-fill text-danger me-2"></i> <strong>Registering more than one NIN is a criminal offense</strong>.</li>
                        <li class="mb-2"><i class="bi bi-card-checklist text-info me-2"></i> Ensure all submitted data matches your NIMC record.</li>
                        <li class="mb-2"><i class="bi bi-shield-lock-fill text-secondary me-2"></i> Only valid and verifiable NINs should be used.</li>
                        <li class="mb-2"><i class="bi bi-person-x-fill text-danger me-2"></i> Deliberate false info will be reported to appropriate authorities.</li>
                    </ul>
                </div>

                <div class="alert alert-warning d-flex align-items-center py-3 px-4 rounded-3">
                    <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                    <div>
                        <strong>Important:</strong> All NIN validations are subject to national identity laws and cannot be reversed. Ensure your request is truthful and compliant with regulations.
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer py-3">
                <button type="button" class="btn btn-outline-primary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="bi bi-check-circle me-2"></i> Understood
                </button>
            </div>
        </div>
    </div>
</div>




    <!-- Modal Script -->
    <script>
        document.getElementById('commentModal').addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const comment = button.getAttribute('data-comment') || 'No comment yet.';
            document.getElementById('commentModalBody').innerText = comment.trim();
        });
   
        // Update price display when modification field changes
        document.getElementById('modification_field').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.getAttribute('data-price') || '0';
            const description = selectedOption.getAttribute('data-description') || '';
            
            document.getElementById('service-fee').textContent = '₦' + parseFloat(price).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            document.getElementById('field-description').textContent = description;
        });

        // Initialize price display if field is preselected
        document.addEventListener('DOMContentLoaded', function() {
            const modificationField = document.getElementById('modification_field');
            if (modificationField.value) {
                modificationField.dispatchEvent(new Event('change'));
            }
        });

    </script>
   

    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</x-app-layout>