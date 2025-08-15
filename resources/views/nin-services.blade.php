<x-app-layout>
  <x-slot name="title">NIN Services</x-slot>

  <div class="container-fluid">
    <!-- NIN Services Section -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-white border-0 pb-0">
            <h4 class="fw-bold text-primary">
              <i class="fas fa-id-card-alt me-2"></i> Our NIN Services
            </h4>
            <p class="text-muted mb-0">Comprehensive National Identity Number solutions</p>
          </div>
          
          <div class="card-body">
            <div class="row g-4">
              <!-- Modification Service -->
              <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <a href="{{ route('nin-modification') }}" class="card service-card h-100 text-decoration-none">
                  <div class="card-body text-center p-3">
                    <div class="icon-wrapper bg-primary-light mb-3 mx-auto">
                      <img src="../assets/images/apps/nimc1.png" alt="Modification" class="img-fluid" style="width: 40px; height: 40px;">
                    </div>
                    <h5 class="mb-0 fw-bold">Modification</h5>
                    <small class="text-muted">NIN Updates</small>
                  </div>
                </a>
              </div>
              
              <!-- Validation Service -->
              <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <a href="{{ route('validation') }}" class="card service-card h-100 text-decoration-none">
                  <div class="card-body text-center p-3">
                    <div class="icon-wrapper bg-info-light mb-3 mx-auto">
                      <img src="../assets/images/apps/nimc1.png" alt="Validation" class="img-fluid" style="width: 40px; height: 40px;">
                    </div>
                    <h5 class="mb-0 fw-bold">Validation</h5>
                    <small class="text-muted">NIN Verification</small>
                  </div>
                </a>
              </div>
              
              <!-- IPE Service -->
              <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <a href="{{ route('ipe') }}" class="card service-card h-100 text-decoration-none">
                  <div class="card-body text-center p-3">
                    <div class="icon-wrapper bg-success-light mb-3 mx-auto">
                      <img src="../assets/images/apps/nimc1.png" alt="IPE" class="img-fluid" style="width: 40px; height: 40px;">
                    </div>
                    <h5 class="mb-0 fw-bold">IPE</h5>
                    <small class="text-muted">Identity Platform</small>
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