<aside class="page-sidebar">
  <div class="main-sidebar" id="main-sidebar">
    <ul class="sidebar-menu" id="simple-bar">
      <li class="sidebar-main-title">
        <div><h5 class="sidebar-title f-w-700">General</h5></div>
      </li>

      <li class="sidebar-list">
        <a class="sidebar-link sidebar-link-active" href="{{ route('dashboard') }}">
          <i class="fas fa-home fa-lg sidebar-icon"></i>
          <h6 class="sidebar-text">Dashboard</h6>
        </a>
      </li>

      <li class="sidebar-main-title">
        <div><h5 class="sidebar-title f-w-700">Menu</h5></div>
      </li>

      <!-- Wallet Section -->
      <li class="sidebar-main-title">
        <div>
          <h5 class="f-w-700 sidebar-title pt-3">Wallet</h5>
        </div>
      </li>
      <li class="sidebar-list">
        <a class="sidebar-link" href="{{ route('wallet') }}">
          <i class="fas fa-wallet fa-lg sidebar-icon"></i>
          <h6 class="sidebar-text f-w-600">Fund Wallet</h6>
        </a>
      </li>

      <li class="sidebar-list">
        <a class="sidebar-link" href="#">
          <i class="fas fa-money-bill-wave fa-lg sidebar-icon"></i>
          <h6 class="sidebar-text f-w-600">Withdraw</h6>
        </a>
      </li>
      
      <!-- Services Section -->
      <li class="sidebar-main-title">
        <div>
          <h5 class="f-w-700 sidebar-title pt-3">Services</h5>
        </div>
      </li>
      <li class="sidebar-list">
        <a class="sidebar-link" href="{{ route('bvn.services') }}">
          <i class="fas fa-user fa-lg sidebar-icon"></i>
          <h6 class="sidebar-text f-w-600">BVN Services</h6>
        </a>
      </li>
      <li class="sidebar-list">
        <a class="sidebar-link" href="{{ route('nin.services') }}">
          <i class="fas fa-id-card fa-lg sidebar-icon"></i>
          <h6 class="sidebar-text f-w-600">NIN Services</h6>
        </a>
      </li>
      <li class="sidebar-list">
        <a class="sidebar-link" href="{{ route('verification.services') }}">
          <i class="fas fa-file-alt fa-lg sidebar-icon"></i>
          <h6 class="sidebar-text f-w-600">Verifications</h6>
        </a>
      </li>
      <li class="sidebar-list">
        <a class="sidebar-link" href="{{ route('vip.services') }}">
          <i class="fas fa-paper-plane fa-lg sidebar-icon"></i>
          <h6 class="sidebar-text f-w-600">VIP Services</h6>
        </a>
      </li>
      
      <!-- Account Section -->
      <li class="sidebar-main-title">
        <div>
          <h5 class="f-w-700 sidebar-title pt-3">Account</h5>
        </div>
      </li>
      <li class="sidebar-list">
         <a class="sidebar-link" href="{{ route('profile.edit') }}">
          <i class="fas fa-cog fa-lg sidebar-icon"></i>
          <h6 class="sidebar-text f-w-600">Settings</h6>
        </a>
      </li>
      <li class="sidebar-list">
        <a class="sidebar-link" href="{{ route('transactions.index') }}">
          <i class="fas fa-list-alt fa-lg sidebar-icon"></i>
          <h6 class="sidebar-text f-w-600">Transactions</h6>
        </a>
      </li>
      <li class="sidebar-list">
        <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="sidebar-link d-flex align-items-center bg-transparent border-0 w-100 text-start">
            <i class="fas fa-sign-out-alt fa-lg sidebar-icon"></i>
            <h6 class="sidebar-text f-w-600 mb-0">Log Out</h6>
          </button>
        </form>
      </li>
    </ul>
  </div>
</aside>

<style>
    /* ========== Global Service Card Styles ========== */
    .service-card, .vip-service-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 10px;
        overflow: hidden;
    }
    
    .service-card:hover, .vip-service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .service-card:hover {
        border-color: rgba(13, 110, 253, 0.2);
    }
    
    .vip-service-card {
        border: 1px solid rgba(212, 175, 55, 0.3);
    }
    
    .vip-service-card:hover {
        box-shadow: 0 10px 20px rgba(212, 175, 55, 0.1);
        border-color: rgba(212, 175, 55, 0.5);
    }

    /* ========== Icon Wrapper Styles ========== */
    .icon-wrapper, .vip-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        margin: 0 auto 1rem;
    }
    
    .service-card:hover .icon-wrapper,
    .vip-service-card:hover .vip-icon-wrapper {
        transform: scale(1.1);
    }

    /* ========== Background Color Variants ========== */
    .bg-primary-light { background-color: rgba(13, 110, 253, 0.1); }
    .bg-info-light { background-color: rgba(23, 162, 184, 0.1); }
    .bg-success-light { background-color: rgba(40, 167, 69, 0.1); }
    .bg-warning-light { background-color: rgba(255, 193, 7, 0.1); }
    .bg-danger-light { background-color: rgba(220, 53, 69, 0.1); }
    .bg-secondary-light { background-color: rgba(108, 117, 125, 0.1); }
    .bg-gold-light { background-color: rgba(212, 175, 55, 0.1); }
    
    .vip-icon-wrapper {
        background-color: rgba(212, 175, 55, 0.1);
    }
    
    .vip-service-card:hover .vip-icon-wrapper {
        background-color: rgba(212, 175, 55, 0.2);
    }

    /* ========== Time-based Greeting Backgrounds ========== */
    .bg-morning { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); }
    .bg-afternoon { background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%); }
    .bg-evening { background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%); }

    /* ========== Wallet Display Styles ========== */
    .wallet-display {
        background: rgba(13, 110, 253, 0.05);
        border-radius: 10px;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }
    
    .wallet-display:hover {
        background: rgba(13, 110, 253, 0.1);
    }

    /* ========== Card Header Styles ========== */
    .card-header {
        background: transparent;
        border-bottom: none;
        padding-bottom: 0;
    }
    
    /* ========== Responsive Adjustments ========== */
    @media (max-width: 768px) {
        .icon-wrapper, .vip-icon-wrapper {
            width: 50px;
            height: 50px;
        }
    }
</style>
