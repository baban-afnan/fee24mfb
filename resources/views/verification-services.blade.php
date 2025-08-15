<x-app-layout>
  <x-slot name="title">Verification Services</x-slot>

  <div class="container-fluid">
    <!-- Verification Services Section -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-white border-0 pb-0">
            <h4 class="fw-bold text-primary">
              <i class="fas fa-shield-alt me-2"></i> Our Verification Services
            </h4>
            <p class="text-muted mb-0">Comprehensive identity verification solutions</p>
          </div>
          
          <div class="card-body">
            <div class="row g-4">
              <!-- Verify NIN Service -->
              <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <a href="{{ route('nin.verification.index') }}" class="card service-card h-100 text-decoration-none">
                  <div class="card-body text-center p-3">
                    <div class="icon-wrapper bg-primary-light mb-3 mx-auto">
                      <img src="../assets/images/apps/nimc1.png" alt="Verify NIN" class="img-fluid" style="width: 40px; height: 40px;">
                    </div>
                    <h5 class="mb-0 fw-bold">Verify NIN</h5>
                    <small class="text-muted">National ID Check</small>
                  </div>
                </a>
              </div>
              
              <!-- Verify BVN Service -->
              <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <a href="{{ route('validation') }}" class="card service-card h-100 text-decoration-none">
                  <div class="card-body text-center p-3">
                    <div class="icon-wrapper bg-info-light mb-3 mx-auto">
                      <img src="../assets/images/apps/bvnlogo.png" alt="Verify BVN" class="img-fluid" style="width: 40px; height: 40px;">
                    </div>
                    <h5 class="mb-0 fw-bold">Verify BVN</h5>
                    <small class="text-muted">Bank Verification</small>
                  </div>
                </a>
              </div>
              
              <!-- Verify Phone No Service -->
              <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <a href="{{ route('ipe') }}" class="card service-card h-100 text-decoration-none">
                  <div class="card-body text-center p-3">
                    <div class="icon-wrapper bg-success-light mb-3 mx-auto">
                      <img src="../assets/images/apps/nimc1.png" alt="Verify Phone No" class="img-fluid" style="width: 40px; height: 40px;">
                    </div>
                    <h5 class="mb-0 fw-bold">Verify Phone No</h5>
                    <small class="text-muted">Number Validation</small>
                  </div>
                </a>
              </div>
              
              <!-- Verify Account Service -->
              <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <a href="{{ route('ipe') }}" class="card service-card h-100 text-decoration-none">
                  <div class="card-body text-center p-3">
                    <div class="icon-wrapper bg-warning-light mb-3 mx-auto">
                      <img src="../assets/images/apps/agent.jpg" alt="Verify Account" class="img-fluid" style="width: 40px; height: 40px;">
                    </div>
                    <h5 class="mb-0 fw-bold">Verify Account</h5>
                    <small class="text-muted">Account Authentication</small>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>