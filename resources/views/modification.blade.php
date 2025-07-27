<x-app-layout>
    <x-slot name="title">BVN Modification</x-slot>

    <div class="container-fluid">
        <div class="row">
            <!-- BVN Modification Form -->
            <div class="col-xl-6 mb-4">
                <div class="card">
                    <div class="card-header card-no-border pb-0">
                        <h3>BVN Modification Form</h3>
                        <p class="mt-1 mb-0">Request for BVN modification. Note that the modification is treated based on NIBSS regulation.</p>

                        @if (session('message'))
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
                        <form class="row g-3" method="POST" action="{{ route('modification.store') }}" enctype="multipart/form-data">
                            @csrf

                           <div class="col-12">
                           <label for="enrolment_bank" class="form-label">Select Bank <span class="text-danger">*</span></label>
                              <select name="enrolment_bank" id="enrolment_bank" class="form-control" required>
                             <option value="">-- Select Bank --</option>
                              @foreach($bankServices as $service)
                              <option value="{{ $service->id }}">{{ $service->name }}</option>
                               @endforeach
                             </select>
                           </div>

                           <div class="col-12">
                          <label class="form-label">Select Modification Field <span class="text-danger">*</span></label>
                        <select class="form-control" name="modification_field" id="modification_field" required>
                             <option value="">-- Select Modification Field --</option>
                          <!-- Options will be loaded via JavaScript -->
                             </select>
                            <small class="text-muted" id="field-description"></small>
                               </div>
                            <div class="col-12">
                                <label class="form-label">BVN <span class="text-danger">*</span></label>
                                <input class="form-control" name="bvn" type="text" maxlength="11" minlength="11" required value="{{ old('bvn') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">NIN ID <span class="text-danger">*</span></label>
                                <input class="form-control" name="nin" type="text" maxlength="11" minlength="11" required value="{{ old('nin') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">
                                    New Data Information <span class="text-danger">*</span>
                                    <button type="button" class="btn btn-outline-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#sampleInfoModal">
                                        View Sample
                                    </button>
                                </label>
                                <textarea class="form-control" name="description" rows="4" required>{{ old('description') }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Affidavit <span class="text-danger">*</span></label>
                                <select class="form-control" name="affidavit" id="affidavit" required>
                                    <option value="">-- Select Affidavit Type --</option>
                                    <option value="available" {{ old('affidavit') === 'available' ? 'selected' : '' }}>Affidavit is Available</option>
                                    <option value="not_available" {{ old('affidavit') === 'not_available' ? 'selected' : '' }}>Affidavit Not Available</option>
                                </select>
                            </div>

                            <div class="col-12" id="affidavit_upload_wrapper" style="display: none;">
                                <label class="form-label">Upload Affidavit (PDF only)</label>
                                <input class="form-control" type="file" name="affidavit_file" accept="application/pdf">
                            </div>

                            <div class="col-12 checkbox-checked">
                                <input class="form-check-input" id="flexCheckDefault" type="checkbox" required>
                                <label class="form-check-label" for="flexCheckDefault">I agree to the BVN modification policies</label>
                            </div>

                            <div class="col-12 mt-2">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Submission Report -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header card-no-border pb-0">
                        <h3>Submission History</h3>
                    </div>
                    <div class="card-body">
                        <form class="row g-3" method="GET">
                            <div class="col-md-6">
                                <input class="form-control" name="search" type="text" placeholder="Search by BVN or BVN" value="{{ request('search') }}">
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
                                        <th>Request ID</th>
                                        <th>BVN</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($crmSubmissions as $index => $submission)
                                        <tr>
                                            <td>{{ $loop->iteration + $crmSubmissions->firstItem() - 1 }}</td>
                                            <td>{{ $submission->reference }}</td>
                                            <td>{{ $submission->bvn }}</td>
                                            <td>
                                                <span class="badge bg-{{ match($submission->status) {
                                                    'resolved' => 'success',
                                                    'processing' => 'primary',
                                                    'rejected' => 'danger',
                                                    default => 'warning'
                                                } }}">{{ ucfirst($submission->status) }}</span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary" title="View Comment"
                                                    data-bs-toggle="modal" data-bs-target="#commentModal"
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

    <!-- Comment Modal -->
    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-chat-left-text me-2"></i>Submission Comment</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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

    <!-- Sample Info Modal -->
    <div class="modal fade" id="sampleInfoModal" tabindex="-1" aria-labelledby="sampleInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white py-3 rounded-top-4">
                    <h4 class="modal-title fw-bold">
                        <i class="bi bi-pencil-square me-2"></i> BVN Modification Guidelines
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 py-4">
                    <p class="fs-6 text-muted mb-3">
                        Please follow the steps below when submitting a request to modify your BVN details.
                    </p>
                    <div class="bg-light p-4 rounded-3 mb-4 border-start border-4 border-primary">
                        <h6 class="fw-semibold mb-3 text-primary">
                            <i class="bi bi-list-check me-2"></i> Modification Instructions
                        </h6>
                        <ul class="fw-semibold mb-3 text-primary">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i> Clearly state the specific information to modify.</li>
                            <li><i class="bi bi-arrow-repeat text-warning me-2"></i> Provide the correct and updated information.</li>
                            <li><i class="bi bi-chat-left-text-fill text-info me-2"></i> Include a valid reason for the request.</li>
                        </ul>
                    </div>

                    <div class="p-4 mb-4 bg-white border rounded-3 shadow-sm">
                        <h6 class="fw-bold text-secondary mb-3">
                            <i class="bi bi-lightbulb-fill me-2 text-warning"></i> Example: Name Correction
                        </h6>
                        <p><strong>New First Name:</strong> ADEBAYO</p>
                        <p><strong>New Surname:</strong> ADEKUNLE</p>
                        <p><strong>New Middle Name:</strong> BOLA</p>
                        <p><strong>Reason:</strong> Spelling error during initial registration</p>
                    </div>

                    <div class="alert alert-info d-flex align-items-center py-3 px-4 rounded-3">
                        <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                        <div>
                            <strong>Note:</strong> All modification requests are thoroughly reviewed by NIBSS.
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

    <!-- Scripts -->
    <script>
        document.getElementById('commentModal').addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const comment = button.getAttribute('data-comment') || 'No comment yet.';
            document.getElementById('commentModalBody').innerText = comment.trim();
        });

        document.getElementById('affidavit').addEventListener('change', function () {
            const uploadDiv = document.getElementById('affidavit_upload_wrapper');
            const fileInput = uploadDiv.querySelector('input');
            uploadDiv.style.display = this.value === 'available' ? 'block' : 'none';
            fileInput.required = this.value === 'available';
        });

        window.addEventListener('DOMContentLoaded', () => {
            if (document.getElementById('affidavit').value === 'available') {
                document.getElementById('affidavit_upload_wrapper').style.display = 'block';
            }
        });




        document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('enrolment_bank').addEventListener('change', function () {
        const bankId = this.value;
        const fieldSelect = document.getElementById('modification_field');
        fieldSelect.innerHTML = '<option value="">Loading...</option>';

        if (bankId) {
            fetch(`/modification-fields/${bankId}`)
                .then(response => response.json())
                .then(data => {
                    fieldSelect.innerHTML = '<option value="">-- Select Modification Field --</option>';
                    data.forEach(field => {
                        const price = parseFloat(field.price).toLocaleString('en-NG', {
                            style: 'currency',
                            currency: 'NGN'
                        });
                        fieldSelect.innerHTML += `<option value="${field.id}" data-price="${field.price}" data-description="${field.description}">${field.field_name} - ${price}</option>`;
                    });
                })
                .catch(() => {
                    fieldSelect.innerHTML = '<option value="">Error loading fields</option>';
                });
        }
    });
});
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</x-app-layout>
