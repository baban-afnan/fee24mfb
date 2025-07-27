<x-app-layout>
   <div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6 col-12">
                    <div>
                        <h2>
                            Hello, {{ Auth::user()->first_name }} {{ Auth::user()->last_name ?? 'User' }}!
                        </h2>
                        <p class="mb-0 text-title-gray">"Welcome back! Continue your journey."</p>
                    </div>
                </div>
        


         <!-- Start wallet_balance (inline layout) -->
<div class="row my-4 text-center align-items-center">
    <div class="col-12">
        <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
            <!-- Wallet icon with link (Font Awesome) -->
            <a href="{{ route('wallet') }}" class="me-2" title="Go to Wallet">
                <i class="fas fa-wallet fs-2 text-primary"></i>
            </a>

            <!-- Wallet balance display -->
            @if($wallets->isNotEmpty())
                @php
                    $wallet = $wallets->firstWhere('currency', 'NGN') ?? $wallets->first();
                    $currencySymbol = $wallet->currency === 'NGN' ? '₦' : '$';
                @endphp

                <span class="fw-light fs-3 mb-0" style="transition: color 0.2s;">
                    {{ $currencySymbol }}{{ number_format($wallet->wallet_balance ?? 0, 2) }}
                </span>

                <span class="badge bg-{{ $wallet->status === 'active' ? 'success' : 'warning' }}">
                    {{ ucfirst($wallet->status) }}
                    @if($wallets->count() > 1)
                        ({{ $wallets->count() }})
                    @endif
                </span>
            @else
                <span class="fw-light fs-3 mb-0">&#8358; 0.00</span>
                <span class="badge bg-danger">No Wallet</span>
            @endif
        </div>
    </div>
</div>



          </div>
         <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row icon-main">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header card-no-border pb-0">
                    <h3 class="m-b-0 f-w-700">Our Services</h3>
                  </div>
                  <div class="card-body">
                    <div class="row icon-lists"> 
                      <div class="col-10 col-xxl-2 col-lg-4 col-md-6 icons-item">
                        <a href="{{ route('bvn.services') }}" class="d-block text-center text-decoration-none">
                          <img src="../assets/images/apps/bvnlogo.png" alt="Arrow Up Service" class="mb-2" style="width:40px;height:40px;object-fit:contain;">
                          <h5 class="mt-0">BVN Services</h5>
                        </a>
                      </div>
                      <div class="col-10 col-xxl-2 col-lg-4 col-md-6 icons-item">
                         <a href="{{ route('nin.services') }}" class="d-block text-center text-decoration-none">
                          <img src="../assets/images/apps/nimc1.png" alt="Arrow Up Service" class="mb-2" style="width:40px;height:40px;object-fit:contain;">
                          <h5 class="mt-0">NIN Services</h5>
                        </a>
                      </div>
                      <div class="col-10 col-xxl-2 col-lg-4 col-md-6 icons-item">
                        <a href="#" class="d-block text-center text-decoration-none">
                          <img src="../assets/images/apps/identity.png" alt="Arrow Up Service" class="mb-2" style="width:40px;height:40px;object-fit:contain;">
                          <h5 class="mt-0">Verifications</h5>
                        </a>
                      </div>
                    <div class="col-10 col-xxl-2 col-lg-4 col-md-6 icons-item">
                        <a href="bvn.php" class="d-block text-center text-decoration-none">
                          <img src="../assets/images/apps/bvnlogo.png" alt="Arrow Up Service" class="mb-2" style="width:40px;height:40px;object-fit:contain;">
                          <h5 class="mt-0">VIP Services</h5>
                        </a>
                      </div>


                        <div class="col-10 col-xxl-2 col-lg-4 col-md-6 icons-item">
                        <a href="#" class="d-block text-center text-decoration-none">
                          <img src="../assets/images/apps/support.png" alt="Arrow Up Service" class="mb-2" style="width:40px;height:40px;object-fit:contain;">
                          <h5 class="mt-0">Support</h5>
                        </a>
                      </div>
                    </div>
                  </div>
               </div>
           </div>
         </div>
      </div>
        

       

</x-app-layout>
