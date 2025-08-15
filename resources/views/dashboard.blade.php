<x-app-layout>
    <x-slot name="title">User Dashboard</x-slot>
    
    <div class="container-fluid">
        <!-- Greeting and User Info Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        @php
                            $hour = now()->format('H');
                            if ($hour < 12) {
                                $greeting = 'Good Morning 🌅';
                                $bgClass = 'bg-morning';
                            } elseif ($hour < 17) {
                                $greeting = 'Good Afternoon ☀️';
                                $bgClass = 'bg-afternoon';
                            } else {
                                $greeting = 'Good Evening 🌙';
                                $bgClass = 'bg-evening';
                            }
                        @endphp

                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-4">
                            <div>
                                <h2 class="fw-bold text-primary mb-2">
                                    {{ $greeting }}, {{ Auth::user()->first_name ?? 'User' }}!
                                </h2>
                                <p class="mb-0 text-muted">
                                    Welcome back to your dashboard. Here's what's happening today.
                                </p>
                            </div>
                            
                            <!-- Wallet Balance -->
                            <div class="d-flex align-items-center gap-3 bg-light p-3 rounded-3 shadow-sm">
                                <a href="{{ route('wallet') }}" class="text-decoration-none" title="Go to Wallet">
                                    <i class="fas fa-wallet fs-2 text-primary"></i>
                                </a>
                                
                                @if($wallets->isNotEmpty())
                                    @php
                                        $wallet = $wallets->firstWhere('currency', 'NGN') ?? $wallets->first();
                                        $currencySymbol = $wallet->currency === 'NGN' ? '₦' : '$';
                                    @endphp
                                    
                                    <div class="text-center">
                                        <span class="fw-bold text-primary fs-4">
                                            {{ $currencySymbol }}{{ number_format($wallet->wallet_balance ?? 0, 2) }}
                                        </span>
                                        <span class="badge bg-{{ $wallet->status === 'active' ? 'success' : 'warning' }} ms-2">
                                            {{ ucfirst($wallet->status) }}
                                            @if($wallets->count() > 1)
                                                ({{ $wallets->count() }} wallets)
                                            @endif
                                        </span>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <span class="fw-bold fs-4">₦0.00</span>
                                        <span class="badge bg-danger ms-2">No Wallet</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <h4 class="fw-bold text-primary">
                            <i class="fas fa-cubes me-2"></i> Our Services
                        </h4>
                        <p class="text-muted mb-0">Access all available services with one click</p>
                    </div>
                    
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- BVN Services -->
                            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                                <a href="{{ route('bvn.services') }}" class="card service-card h-100 text-decoration-none">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper bg-primary-light mb-3 mx-auto">
                                            <img src="../assets/images/apps/bvnlogo.png" alt="BVN Services" class="img-fluid" style="width: 40px; height: 40px;">
                                        </div>
                                        <h5 class="mb-0 fw-bold">BVN Services</h5>
                                        <small class="text-muted">Bank Verification</small>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- NIN Services -->
                            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                                <a href="{{ route('nin.services') }}" class="card service-card h-100 text-decoration-none">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper bg-info-light mb-3 mx-auto">
                                            <img src="../assets/images/apps/nimc1.png" alt="NIN Services" class="img-fluid" style="width: 40px; height: 40px;">
                                        </div>
                                        <h5 class="mb-0 fw-bold">NIN Services</h5>
                                        <small class="text-muted">National ID</small>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- Verifications -->
                            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                                <a href="{{ route('verification.services') }}" class="card service-card h-100 text-decoration-none">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper bg-success-light mb-3 mx-auto">
                                            <img src="../assets/images/apps/identity.png" alt="Verifications" class="img-fluid" style="width: 40px; height: 40px;">
                                        </div>
                                        <h5 class="mb-0 fw-bold">Verifications</h5>
                                        <small class="text-muted">Identity Checks</small>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- VIP Services -->
                            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                                <a href="{{ route('vip.services') }}" class="card service-card h-100 text-decoration-none">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper bg-warning-light mb-3 mx-auto">
                                            <img src="../assets/images/apps/bvnlogo.png" alt="VIP Services" class="img-fluid" style="width: 40px; height: 40px;">
                                        </div>
                                        <h5 class="mb-0 fw-bold">VIP Services</h5>
                                        <small class="text-muted">Premium Features</small>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- BVN Report -->
                            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                                <a href="{{ route('enrollments.index') }}" class="card service-card h-100 text-decoration-none">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper bg-danger-light mb-3 mx-auto">
                                            <img src="../assets/images/apps/bvnlogo.png" alt="BVN Report" class="img-fluid" style="width: 40px; height: 40px;">
                                        </div>
                                        <h5 class="mb-0 fw-bold">BVN Report</h5>
                                        <small class="text-muted">Agent Records</small>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- Support -->
                            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                                <a href="{{ route('support.services') }}" class="card service-card h-100 text-decoration-none">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper bg-secondary-light mb-3 mx-auto">
                                            <img src="../assets/images/apps/support.png" alt="Support" class="img-fluid" style="width: 40px; height: 40px;">
                                        </div>
                                        <h5 class="mb-0 fw-bold">Support</h5>
                                        <small class="text-muted">Help Center</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications Section -->
        <div class="row">
            <div class="col-12">
                @include('forms.notification')
            </div>
        </div>
    </div>
</x-app-layout>