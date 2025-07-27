<x-app-layout>

  <div class="page-body">
    <div class="container-fluid">
      <div class="page-title">
        <div class="row">
          <div class="col-sm-6 col-12">
            <h2>Wallet funding</h2>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">

        <!-- Automatic Funding Card -->
        <div class="col-xl-6 mb-lg-3">
          <div class="card">
            <div class="card-header card-no-border pb-0">
              <h3>Automatic wallet funding</h3>
              <p class="mt-1 mb-0">
                Fund your wallet using a virtual account. It will be credited instantly after payment confirmation.
              </p>
            </div>

            @if (session('success'))
              <div class="alert alert-success">
          {{ session('success') }}
                </div>
               @endif

             @if (session('error'))
               <div class="alert alert-danger">
                {{ session('error') }}
                 </div>
              @endif

            <div class="card-body custom-input form-validation">
              @if($virtualAccount)
              <form class="row g-3">
                <div class="col-12">
                  <label class="form-label">Account Name</label>
                  <input class="form-control" type="text" readonly value="{{ $virtualAccount->accountName }}">
                </div>
                <div class="col-12">
                  <label class="form-label">Account Number</label>
                  <input class="form-control" type="text" readonly value="{{ $virtualAccount->accountNo }}">
                </div>
                <div class="col-12">
                  <label class="form-label">Bank Name</label>
                  <input class="form-control" type="text" readonly value="{{ $virtualAccount->bankName }}">
                </div>
              </form>
              @else
              <div class="col-12 mt-2">
                <a href="#" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#virtualAccountModal">
                  <i class="fas fa-user"></i> No virtual account? Create
                </a>
              </div>
              @endif
            </div>
          </div>
        </div>

        <!-- Manual Funding Card -->
        <div class="col-xl-6">
          <div class="card">
            <div class="card-header card-no-border pb-0">
              <h3>Manual funding</h3>
              <p class="mt-1 mb-0">
                Transfer funds to your unique Wallet account below. Your Wallet will be credited instantly after payment confirmation.
              </p>
            </div>
            <div class="card-body">
              <form class="row g-3 needs-validation custom-input validation-forms" novalidate>
                <div class="col-12">
                  <label class="form-label">Account Name</label>
                  <input class="form-control" value="{{ $account['account_name'] ?? '' }}" readonly>
                </div>
                <div class="col-12">
                  <label class="form-label">Account Number</label>
                  <input class="form-control" value="{{ $account['account_number'] ?? '' }}" readonly>
                </div>
                <div class="col-12">
                  <label class="form-label">Bank Name</label>
                  <input class="form-control" value="{{ $account['bank_name'] ?? '' }}" readonly>
                </div>
                <div class="col-12 mt-2">
                  <a href="#" class="btn btn-primary btn-lg">
                    <i class="fas fa-headset me-2"></i> Need Help? Contact Support
                  </a>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Modal for Virtual Account Creation -->
  <div class="modal fade" id="virtualAccountModal" tabindex="-1" aria-labelledby="virtualAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content shadow rounded-4">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Create Virtual Account</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body px-4 py-4">
          <form method="POST" action="{{ route('virtual.account.create') }}" class="row g-4">
            @csrf
            <div class="col-md-6">
              <label class="form-label">Full Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="name" required value="{{ auth()->user()->first_name." ".auth()->user()->last_name}}" readonly/>
            </div>
            <div class="col-md-6">
              <label class="form-label">Phone Number <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="phone" required value="{{ auth()->user()->phone_no }}">
            </div>
            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="confirmCheck" required>
                <label class="form-check-label" for="confirmCheck">
                  I confirm that the above details are accurate and consent to create a virtual account.
                </label>
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-send-fill me-2"></i> Submit Request
              </button>
            </div>
          </form>
        </div>

        <div class="modal-footer bg-light rounded-bottom-4 py-3">
          <small class="text-muted">Account will be generated instantly and linked to your wallet.</small>
        </div>
      </div>
    </div>
  </div>

</x-app-layout>
