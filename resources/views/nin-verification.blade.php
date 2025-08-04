<x-app-layout>
    <x-slot name="title">Verify NIN</x-slot>

    <div class="container-fluid">
        <div class="row">
            <!-- Number Validation Form -->
            <div class="col-xl-6 mb-4">
                <div class="card">
                    <div class="card-header card-no-border pb-0">
                        <h3>NIN Verification Form</h3>
                        <p class="mt-1 mb-0">NIN verification is instant and we charge 20% on failed search</p>

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
                        <form class="row g-3" method="POST" action="{{ route('nin.verification.store') }}">
                            @csrf

                            <div class="col-12">
                                <label class="form-label">Select Verification Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="modification_field_id" id="modification_field" required>
                                    <option value="">-- Select Verification Type --</option>
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
                                <label class="form-label">NIN number <span class="text-danger">*</span></label>
                                <input class="form-control" name="number_nin" type="text" required placeholder="Enter 11 Digit Phone nin" maxlength="11" minlength="11" 
                                       pattern="[0-9]{11}" title="11-digit number_nin" 
                                       required value="{{ old('number_nin') }}">
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
                                        I agree to the Number Validation policies and confirm the information provided is accurate
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
                                <input class="form-control" name="search" type="text" placeholder="Search by Number" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" name="status">
                                    <option value="">All Status</option>
                                    @foreach(['pending', 'processing', 'Verified', 'resolved', 'rejected'] as $status)
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
                                        <th>NIN NO</th>
                                        <th>Full Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($crmSubmissions as $index => $submission)
                                        <tr>
                                            <td>{{ $loop->iteration + $crmSubmissions->firstItem() - 1 }}</td>
                                            <td>{{ $submission->number_nin }}</td>
                                            <td>{{ $submission->firstname }} {{ $submission->surname }}</td>
                                            <td>
                                                <span class="badge bg-{{ match($submission->status) {
                                                    'resolved' => 'success',
                                                    'processing' => 'primary',
                                                    'Verified' => 'primary',
                                                    'rejected' => 'danger',
                                                    default => 'warning'
                                                } }}">{{ ucfirst($submission->status) }}</span>
                                            </td>
                                            <td>
                                              
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-success"
                                                    title="View ID Card"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#idCardModal"
                                                    data-firstname="{{ $submission->firstname }}"
                                                    data-middlename="{{ $submission->middlename }}"
                                                    data-surname="{{ $submission->surname }}"
                                                    data-gender="{{ $submission->gender }}"
                                                    data-maritalstatus="{{ $submission->maritalstatus }}"
                                                    data-birthdate="{{ $submission->birthdate }}"
                                                    data-email="{{ $submission->email }}"
                                                    data-telephoneno="{{ $submission->telephoneno }}"
                                                    data-residence_address="{{ $submission->residence_address }}"
                                                    data-residence_state="{{ $submission->residence_state }}"
                                                    data-residence_lga="{{ $submission->residence_lga }}"
                                                    data-residence_town="{{ $submission->residence_town }}"
                                                    data-religion="{{ $submission->religion }}"
                                                    data-number_nin="{{ $submission->number_nin }}"
                                                    data-photo_path="{{ $submission->photo_path }}"
                                                    data-signature_path="{{ $submission->signature_path }}"
                                                    data-trackingid="{{ $submission->trackingId }}">
                                                    <i class="bi bi-person-badge"></i> ID Card
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
        <div class="modal-dialog modal-dialog-centered">
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

    <!-- ID Card Modal -->
    <div class="modal fade" id="idCardModal" tabindex="-1" aria-labelledby="idCardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-person-badge me-2"></i>ID Card Information</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="idCardModalBody">
                    <!-- ID Card Container with background -->
                  <div class="id-card-container" style="
                  background-image: url('../assets/images/apps/nimc1.png'); 
                   background-size: 50% auto; 
                   background-repeat: no-repeat; 
                   background-position: center center;
                   padding: 20px; 
                   border-radius: 10px; 
                   position: relative;
                   min-height: 300px; /* Ensures container has enough height to show centered image */
                         ">
                        <div class="row">
                            <!-- Photo Column -->
                            <div class="col-md-4 text-center">
                                <div class="id-photo-container mb-3" style="background: white; padding: 5px; border-radius: 5px; border: 1px solid #ddd;">
                                    <img id="idPhoto" src="" alt="ID Photo" style="max-width: 100%; height: auto; max-height: 200px;" class="img-fluid">
                                    <div class="text-center mt-2" style="font-size: 0.8rem;">PHOTO</div>
                                </div>
                                <div class="signature-container" style="background: white; padding: 5px; border-radius: 5px; border: 1px solid #ddd;">
                                    <img id="idSignature" src="" alt="Signature" style="max-width: 100%; height: auto; max-height: 80px;" class="img-fluid">
                                    <div class="text-center mt-2" style="font-size: 0.8rem;">SIGNATURE</div>
                                </div>
                            </div>
                            
                            <!-- Information Column -->
                            <div class="col-md-8">
                                <div class="id-info-container" style="background: rgba(255, 255, 255, 0.9); padding: 15px; border-radius: 5px;">
                                   <div class="text-center mb-2">
                                     <img src="../assets/images/apps/nimc1.png" alt="Organization Logo" 
                                     style="max-height: 70px; width: auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                                      </div>
                                     <h4 class="text-center mb-3" style="color: #0056b3; font-weight: 700; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                                      NATIONAL IDENTITY CARD
                                    </h4>
                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Tracking ID:</div>
                                        <div class="col-md-8" id="trackingId"></div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">NIN Number:</div>
                                        <div class="col-md-8" id="number_nin"></div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Full Name:</div>
                                        <div class="col-md-8" id="fullName"></div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Gender:</div>
                                        <div class="col-md-8" id="gender"></div>
                                    </div>

                                     <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Date of Birth:</div>
                                        <div class="col-md-8" id="birthdate"></div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Marital Status:</div>
                                        <div class="col-md-8" id="maritalstatus"></div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Email:</div>
                                        <div class="col-md-8" id="email"></div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Phone:</div>
                                        <div class="col-md-8" id="telephoneno"></div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Address:</div>
                                        <div class="col-md-8" id="residence_address"></div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">State/LGA/Town:</div>
                                        <div class="col-md-8" id="location"></div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Religion:</div>
                                        <div class="col-md-8" id="religion"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="printIdCard()"><i class="bi bi-printer me-2"></i>Print</button>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <script>
        // Comment Modal Handler
        document.getElementById('commentModal').addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const comment = button.getAttribute('data-comment') || 'No comment yet.';
            document.getElementById('commentModalBody').innerText = comment.trim();
        });

        // ID Card Modal Handler
        document.getElementById('idCardModal').addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            
            // Get all data attributes
            const data = {
                firstname: button.getAttribute('data-firstname') || '',
                middlename: button.getAttribute('data-middlename') || '',
                surname: button.getAttribute('data-surname') || '',
                gender: button.getAttribute('data-gender') || '',
                maritalstatus: button.getAttribute('data-maritalstatus') || '',
                birthdate: button.getAttribute('data-birthdate') || '',
                email: button.getAttribute('data-email') || '',
                telephoneno: button.getAttribute('data-telephoneno') || '',
                residence_address: button.getAttribute('data-residence_address') || '',
                residence_state: button.getAttribute('data-residence_state') || '',
                residence_lga: button.getAttribute('data-residence_lga') || '',
                residence_town: button.getAttribute('data-residence_town') || '',
                religion: button.getAttribute('data-religion') || '',
                number_nin: button.getAttribute('data-number_nin') || '',
                photo_path: button.getAttribute('data-photo_path') || '',
                signature_path: button.getAttribute('data-signature_path') || '',
                trackingId: button.getAttribute('data-trackingid') || ''
            };

            // Display the full name
            document.getElementById('fullName').textContent = 
                `${data.surname} ${data.firstname} ${data.middlename}`.trim();
            
            // Display other text information
            document.getElementById('trackingId').textContent = data.trackingId;
            document.getElementById('number_nin').textContent = data.number_nin;
            document.getElementById('gender').textContent = data.gender;
            document.getElementById('maritalstatus').textContent = data.maritalstatus;
            document.getElementById('birthdate').textContent = data.birthdate;
            document.getElementById('email').textContent = data.email;
            document.getElementById('telephoneno').textContent = data.telephoneno;
            document.getElementById('residence_address').textContent = data.residence_address;
            document.getElementById('location').textContent = 
                `${data.residence_state} / ${data.residence_lga} / ${data.residence_town}`;
            document.getElementById('religion').textContent = data.religion;
            
            // Display images (assuming they are stored as base64 encoded strings)
            if (data.photo_path) {
                document.getElementById('idPhoto').src = `data:image/jpeg;base64,${data.photo_path}`;
            }
            
            if (data.signature_path) {
                document.getElementById('idSignature').src = `data:image/jpeg;base64,${data.signature_path}`;
            }
        });

        // Print ID Card Function
        function printIdCard() {
            const printContent = document.getElementById('idCardModalBody').innerHTML;
            const originalContent = document.body.innerHTML;
            
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
            
            // Reinitialize modal if needed
            const modal = new bootstrap.Modal(document.getElementById('idCardModal'));
            modal.show();
        }

        // Service Fee Calculator
        document.getElementById('modification_field').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.getAttribute('data-price') || '0';
            const description = selectedOption.getAttribute('data-description') || '';

            document.getElementById('service-fee').textContent = '₦' + parseFloat(price).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            document.getElementById('field-description').textContent = description;
        });

        // Initialize service fee on page load
        document.addEventListener('DOMContentLoaded', function () {
            const modificationField = document.getElementById('modification_field');
            if (modificationField.value) {
                modificationField.dispatchEvent(new Event('change'));
            }
        });
    </script>

    <style>
          .id-card-container {
            border: 2px solid #0056b3;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-family: Arial, sans-serif;
            background-image: url('../assets/images/apps/nimc1.png');
            background-size: 50% auto;
            background-repeat: no-repeat;
            background-position: center center;
            padding: 20px;
            border-radius: 10px;
            position: relative;
            min-height: 400px;
        }

        .id-card-container {
            border: 2px solid #0056b3;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-family: Arial, sans-serif;
        }
        
        .id-info-container {
            font-size: 0.9rem;
        }
        
        @media print {
            body * {
                visibility: hidden;
            }
            .id-card-container, .id-card-container * {
                visibility: visible;
            }
            .id-card-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                background-image: none !important;
            }
            .modal-footer {
                display: none !important;
            }
        }
    </style>
</x-app-layout>