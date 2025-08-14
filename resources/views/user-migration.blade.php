<x-app-layout>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">

           

            <!-- Main Content -->
            <div class="comingsoon bg-light min-vh-100 d-flex align-items-center">
                <div class="comingsoon-inner text-center w-100 py-3 py-md-4 py-lg-5">
                    <!-- Logo - Responsive sizing -->
                    <div class="logo-container mb-3 mb-md-4 mb-lg-5 px-2">
                        <img class="for-light img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt="logo" style="max-width: 30px; height: auto;" />
                        <img class="for-dark img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt="logo" style="max-width: 30px; height: auto;" />
                    </div>
                    
                    <!-- Heading - Responsive typography -->
                    <div class="container px-2">
                        <h1 class="display-4 fw-bold text-gradient-primary mb-2 mb-md-3" style="font-size: clamp(1.0rem, 5vw, 1.5rem);">WELCOME ONBOARD SIR</h1>
                        <p class="lead text-muted mb-3 mb-md-4" style="font-size: clamp(1rem, 2vw, 1.25rem);">Exciting upgrades and new features are on their way!</p>
                    </div>
                    
                    
                    <!-- Upgrade CTA Section - Responsive padding -->
                    <div class="upgrade-cta bg-white p-3 p-md-4 rounded shadow-sm mb-4 mb-md-5 mx-auto" style="max-width: 600px;">
                        <h3 class="mb-2 mb-md-3" style="font-size: clamp(1.25rem, 3vw, 1.75rem);">
                            <i class="bi bi-rocket-takeoff text-primary me-2"></i> Upgrade to Agent Status
                        </h3>
                        <p class="text-muted mb-3 mb-md-4" style="font-size: clamp(0.875rem, 2vw, 1rem);">
                            Unlock powerful features and grow your business exponentially
                        </p>

                         <!-- Message Display Section - Top of page -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-2 mb-md-3" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-2 mb-md-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-2 mb-md-3" role="alert">
                        <i class="bi bi-exclamation-octagon-fill me-2"></i>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                        
                        <!-- Action Buttons - Stack on mobile -->
                        <div class="d-flex flex-column flex-sm-row justify-content-center gap-2 gap-md-3">
                            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#migrationBenefitsModal" style="font-size: clamp(0.875rem, 2vw, 1rem); padding: 0.5rem 1.25rem;">
                                <i class="bi bi-stars me-2"></i> See Benefits
                            </button>
                            <button type="button" class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#migrationFormModal" style="font-size: clamp(0.875rem, 2vw, 1rem); padding: 0.5rem 1.25rem;">
                                <i class="bi bi-pencil-square me-2"></i> Apply Now
                            </button>
                        </div>
                    </div>
                    
                    <!-- Quick Benefits Preview - Stack on mobile -->
                    <div class="quick-benefits row justify-content-center g-2 g-md-3 px-2 mx-auto" style="max-width: 1200px;">
                        <div class="col-6 col-sm-6 col-md-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center p-2 p-md-3">
                                    <div class="icon-circle bg-primary bg-opacity-10 text-primary mb-2 mb-md-3 mx-auto" style="width: clamp(40px, 8vw, 60px); height: clamp(40px, 8vw, 60px);">
                                        <i class="fs-3" style="font-size: clamp(1.25rem, 3vw, 1.75rem) !important;"></i>
                                    </div>
                                    <h5 class="card-title mb-1 mb-md-2" style="font-size: clamp(0.875rem, 2vw, 1.15rem);">Higher Commissions</h5>
                                    <p class="card-text text-muted small" style="font-size: clamp(0.75rem, 1.5vw, 0.875rem);">Earn significantly more with our agent-level rates</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center p-2 p-md-3">
                                    <div class="icon-circle bg-success bg-opacity-10 text-success mb-2 mb-md-3 mx-auto" style="width: clamp(40px, 8vw, 60px); height: clamp(40px, 8vw, 60px);">
                                        <i class="bi bi-people-fill fs-3" style="font-size: clamp(1.25rem, 3vw, 1.75rem) !important;"></i>
                                    </div>
                                    <h5 class="card-title mb-1 mb-md-2" style="font-size: clamp(0.875rem, 2vw, 1.15rem);">Team Building</h5>
                                    <p class="card-text text-muted small" style="font-size: clamp(0.75rem, 1.5vw, 0.875rem);">Build your own team and earn from their performance</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center p-2 p-md-3">
                                    <div class="icon-circle bg-info bg-opacity-10 text-info mb-2 mb-md-3 mx-auto" style="width: clamp(40px, 8vw, 60px); height: clamp(40px, 8vw, 60px);">
                                        <i class="bi bi-shield-lock fs-3" style="font-size: clamp(1.25rem, 3vw, 1.75rem) !important;"></i>
                                    </div>
                                    <h5 class="card-title mb-1 mb-md-2" style="font-size: clamp(0.875rem, 2vw, 1.15rem);">Priority Support</h5>
                                    <p class="card-text text-muted small" style="font-size: clamp(0.75rem, 1.5vw, 0.875rem);">Dedicated support team for all your needs</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center p-2 p-md-3">
                                    <div class="icon-circle bg-warning bg-opacity-10 text-warning mb-2 mb-md-3 mx-auto" style="width: clamp(40px, 8vw, 60px); height: clamp(40px, 8vw, 60px);">
                                        <i class="bi bi-award-fill fs-3" style="font-size: clamp(1.25rem, 3vw, 1.75rem) !important;"></i>
                                    </div>
                                    <h5 class="card-title mb-1 mb-md-2" style="font-size: clamp(0.875rem, 2vw, 1.15rem);">Exclusive Tools</h5>
                                    <p class="card-text text-muted small" style="font-size: clamp(0.75rem, 1.5vw, 0.875rem);">Access to premium analytics and marketing tools</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @include('forms.upgradebenefits')
            @include('forms.migrationform')



        </div>
    </div>

    <style>
        .text-gradient-primary {
            background: linear-gradient(90deg, #4e73df 0%, #224abe 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .countdown-list {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.75rem;
            padding: 0;
        }
        
        @media (min-width: 576px) {
            .countdown-list {
                gap: 1.5rem;
            }
        }
        
        .countdown-item {
            text-align: center;
            flex: 1 0 auto;
            max-width: calc(50% - 0.75rem);
        }
        
        @media (min-width: 576px) {
            .countdown-item {
                max-width: none;
                flex: 0 0 auto;
            }
        }
        
        .countdown-card {
            min-width: 70px;
            width: 100%;
        }
        
        @media (min-width: 576px) {
            .countdown-card {
                min-width: 90px;
            }
        }
        
        @media (min-width: 768px) {
            .countdown-card {
                min-width: 100px;
            }
        }
        
        .icon-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        
        .upgrade-cta {
            border-top: 3px solid #4e73df;
            width: calc(100% - 2rem);
        }
        
        @media (min-width: 576px) {
            .upgrade-cta {
                width: 100%;
            }
        }
        
        /* Touch target sizing for mobile */
        .btn {
            min-height: 44px; /* Recommended minimum touch target size */
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Prevent zooming on form inputs in mobile */
        @media (max-width: 768px) {
            input, select, textarea {
                font-size: 16px !important;
            }
        }
    </style>
</x-app-layout>