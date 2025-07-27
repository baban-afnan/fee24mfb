<x-app-layout>
    <x-slot name="title">NIN Modification</x-slot>

    <div class="container-fluid">
        <div class="row">
            <!-- NIN Modification Form -->
            <div class="col-xl-6 mb-4">
                <div class="card">
                    <div class="card-header card-no-border pb-0">
                        <h3>NIN Modification Form</h3>
                        <p class="mt-1 mb-0">Request for NIN modification. Note that the modification is treated based on NIBSS regulation.</p>

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
                        <form class="row g-3" method="POST" action="{{ route('nin-modification.store') }}">
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
                                <input class="form-control" name="nin" type="text"required placeholder="Enter 11 Digit NIN Number" maxlength="11" minlength="11" 
                                       pattern="[0-9]{11}" title="11-digit NIN number" 
                                       required value="{{ old('nin') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">
                                    New Data Information <span class="text-danger">*</span>
                                    <button type="button" class="btn btn-outline-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#sampleInfoModal">
                                        <i class="bi bi-info-circle"></i> View Guidelines
                                    </button>
                                </label>
                                <textarea class="form-control" name="description" rows="4" placeholder="New Information you want to update on NIN" required>{{ old('description') }}</textarea>
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
                                        I agree to the NIN modification policies and confirm the information provided is accurate
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


     <!-- Guidelines Modal -->
<div class="modal fade" id="sampleInfoModal" tabindex="-1" aria-labelledby="sampleInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white py-3 rounded-top-4">
                <h4 class="modal-title fw-bold" id="sampleInfoModalLabel">
                    <i class="bi bi-pencil-square me-2"></i> NIN Modification Guidelines
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-4 py-4">
                <p class="fs-6 text-muted mb-3">
                    Please follow the steps below when submitting a request to modify your NIN details. Incomplete or incorrect requests may be delayed or rejected.
                </p>

                <div class="bg-light p-4 rounded-3 mb-4 border-start border-4 border-primary">
                    <h6 class="fw-semibold mb-3 text-primary">
                        <i class="bi bi-list-check me-2"></i> Modification Instructions
                    </h6>
                    <ul class="fw-semibold mb-3 text-primary">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Clearly state the specific information you want to modify (e.g., name, date of birth).</li>
                        <li class="mb-2"><i class="bi bi-arrow-repeat text-warning me-2"></i> Provide the correct and updated information to be used.</li>
                        <li class="mb-2"><i class="bi bi-chat-left-text-fill text-info me-2"></i> Include a brief and valid reason justifying the requested modification.</li>
                    </ul>
                </div>

                <div class="p-4 mb-4 bg-white border rounded-3 shadow-sm">
                    <h6 class="fw-bold text-secondary mb-3">
                        <i class="bi bi-lightbulb-fill me-2 text-warning"></i> Example: Name Correction
                    </h6>
                    <p class="mb-1"><strong>New First Name:</strong> ADEBAYO</p>
                    <p class="mb-1"><strong>New Surname:</strong>   ADEKUNLE</p>
                    <p class="mb-1"><strong>New Middle Name:</strong>   BOLA</p>
                    <p class="mb-0"><strong>Reason:</strong> Spelling error during initial registration</p>
                </div>

                <div class="alert alert-info d-flex align-items-center py-3 px-4 rounded-3">
                    <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                    <div>
                        <strong>Note:</strong> All modification requests are thoroughly reviewed and must be approved by the National Identity Management Commission (NIMC).
                    </div>
                </div>
            </div>

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