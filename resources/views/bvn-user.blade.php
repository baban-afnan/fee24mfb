<x-app-layout>
    <x-slot name="title">BVN User Request</x-slot>

    {{-- BVN Form Section --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header card-no-border pb-0">
                    <h3>BVN User Creation Form</h3>
                    <p class="mt-1 mb-0">
                        Fill the form <code>note that field * is compulsory</code>. You must agree with our terms and conditions.
                    </p>
                </div>

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
                @endif


                 <button type="button" class="btn btn-outline-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#sampleInfoModal">
                                        <i class="bi bi-info-circle"></i> View Guidelines
                                    </button>
                <div class="card-body">
                    <form class="row g-3 needs-validation custom-input tooltip-valid validation-forms" method="POST" action="{{ route('bvn.store') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        @include('forms.bvn_user_form')

                        <div class="col-12 d-flex justify-content-center">
                            <button class="btn btn-primary btn-lg" type="submit">Submit form</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




      <!-- Report Section -->
                <div class="card">
                    <div class="card-header card-no-border pb-0">
                        <h3>User Request History</h3>
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
                                        <th>Request ID</th>
                                        <th>Name</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($crmSubmissions as $index => $submission)
                                        <tr>
                                            <td>{{ $loop->iteration + $crmSubmissions->firstItem() - 1 }}</td>
                                            <td>{{ $submission->reference }}</td>
                                            <td>{{ $submission->account_name }}</td>
                                            <td>{{ $submission->phone_no }}</td>
                                            <td>{{ $submission->email }}</td>
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
                    <i class="bi bi-info-circle me-2"></i> BVN User Guidelines
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-4 py-4">
                <p class="fs-6 text-muted mb-3">
                    Please review the following guidelines carefully. Your access and pricing depend on your role, and all BVN operations are subject to NIBSS approval.
                </p>

                <div class="bg-light p-4 rounded-3 mb-4 border-start border-4 border-primary">
                    <h6 class="fw-semibold mb-3 text-primary">
                        <i class="bi bi-people-fill me-2"></i> Role-Based Access
                    </h6>
                    <ul class="fw-semibold text-primary">
                        <li class="mb-2">
                            <i class="bi bi-person-badge-fill text-success me-2"></i>
                            <strong>User:</strong> Can submit BVN requests using available services.
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-person-workspace text-info me-2"></i>
                            <strong>Agent:</strong> Access to discounted BVN service prices. BVN enrollments are typically processed within 2 to 3 working days.
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-shield-lock-fill text-warning me-2"></i>
                            <strong>Admin:</strong> Can onboard new users, access CRM services for free, and enjoy discounted BVN pricing. Receives ₦100 per successful BVN enrollment.
                        </li>
                    </ul>
                </div>

                <div class="alert alert-info d-flex align-items-center py-3 px-4 rounded-3">
                    <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                    <div>
                        <strong>Note:</strong> Commission payouts depend on NIBSS settlement. All BVN requests are subject to verification and approval by NIBSS.
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


   
    {{-- Comment Modal Script --}}
    <script>
        document.getElementById('commentModal').addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const comment = button.getAttribute('data-comment') || 'No comment yet.';
            document.getElementById('commentModalBody').innerText = comment.trim();
        });
    </script>

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</x-app-layout>
