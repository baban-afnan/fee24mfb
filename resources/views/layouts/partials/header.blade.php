<header class="page-header row">
  <div class="logo-wrapper d-flex align-items-center col-auto">
    <img class="light-logo img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt="logo" style="max-width: 30px; height: auto;"/>
    <img class="dark-logo img-fluid" src="{{ asset('assets/images/logo/logo-dark.png') }}" alt="logo" style="max-width: 30px; height: auto;"/>
    <a class="lose-btn toggle-sidebar" href="javascript:void(0)">
      <i class="fas fa-times"></i>
    </a>
  </div>

  <div class="page-main-header col">
    <div class="header-left">
      <form class="form-inline search-full col" action="#" method="get">
        <div class="form-group w-100">
          <div class="Typeahead Typeahead--twitterUsers">
            <div class="u-posRelative">
              <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Search..." name="q" />
              <div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">Loading...</span></div>
              <i class="close-search" data-feather="x"></i>
            </div>
          </div>
        </div>
      </form>
    </div>

    <div class="nav-right">
      <ul class="header-right">
        <!-- Language Dropdown -->
        <li class="custom-dropdown">
          <div class="translate_wrapper">
            <div class="current_lang">
              <a class="lang" href="javascript:void(0)">
                <i class="flag-icon flag-icon-us"></i>
                <h6 class="lang-txt f-w-700">ENG</h6>
              </a>
            </div>
          </div>
        </li>

        <li class="search d-lg-none d-flex">
          <a href="javascript:void(0)"><i class="fas fa-search"></i></a>
        </li>
        <li><a class="dark-mode" href="javascript:void(0)"><i class="fas fa-moon"></i></a></li>
        <li><a class="full-screen" href="javascript:void(0)"><i class="fas fa-expand"></i></a></li>

        <!-- Profile Dropdown -->
        <li class="profile-nav custom-dropdown">
          <div class="user-wrap">
            <div class="user-img">
             <img class="img-70 rounded-circle border border-2 shadow-sm" src="{{ Auth::user()->photo }}" alt="User Photo">
            </div>
            <div class="user-content">
              <h6>{{ Auth::user()->first_name ?? 'User' }}</h6>
              <p class="mb-0">{{ Auth::user()->role ?? 'Role' }}<i class="fas fa-chevron-down"></i></p>
            </div>
          </div>
          <div class="custom-menu overflow-hidden">
            <ul class="profile-body">
              <li class="d-flex">
                <i class="fas fa-user"></i>
                <a class="ms-2" href="#">Profile</a>
              </li>
              <li class="d-flex">
                <i class="fas fa-envelope"></i>
                <a class="ms-2" href="#">Inbox</a>
              </li>
              <li class="d-flex">
                <i class="fas fa-tasks"></i>
                <a class="ms-2" href="#">Task</a>
              </li>
              <li class="d-flex">
                <i class="fas fa-sign-out-alt"></i>
                <a class="ms-2" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
              </li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>
        </li>
      </ul>
    </div>
  </div>
</header>


<style>
/* Base Styles */
.icon-main {
    padding: 20px 0;
}

.icon-lists {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}

.icons-item {
    width: calc(50% - 20px); /* Two per row */
    perspective: 1000px;
    transition: all 0.3s ease;
}

.icons-item a {
    display: block;
    padding: 25px 15px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,0.2);
    color: #34495e;
    text-decoration: none !important;
}

.icons-item a::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    transition: all 0.3s ease;
}

.icons-item a:hover {
    transform: translateY(-10px) scale(1.03);
    box-shadow: 0 15px 30px rgba(0,0,0,0.12);
}

.icons-item a:hover::before {
    height: 10px;
}

.icons-item a:active {
    transform: translateY(-5px) scale(0.98);
}

.icons-item img {
    transition: all 0.3s ease;
    filter: grayscale(30%);
}

.icons-item a:hover img {
    transform: scale(1.1) rotate(5deg);
    filter: grayscale(0%);
}

.icons-item i {
    color: #3498db;
    transition: all 0.3s ease;
}

.icons-item a:hover i {
    color: #9b59b6;
    transform: translateY(-5px);
}

.icons-item h5 {
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
}

.icons-item a:hover h5 {
    color: #2c3e50;
}

.icons-item h5::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 2px;
    transition: all 0.3s ease;
}

.icons-item a:hover h5::after {
    width: 40px;
}

/* Click Animation */
.icons-item a:active {
    animation: clickEffect 0.4s ease;
}

@keyframes clickEffect {
    0% { transform: translateY(-10px) scale(1.03); }
    50% { transform: translateY(-10px) scale(0.95); }
    100% { transform: translateY(-10px) scale(1.03); }
}

/* Responsive Design */
@media (max-width: 767.98px) {
    .icons-item {
        width: calc(50% - 20px); /* Two items per row */
    }
    
    .card-header h3 {
        font-size: 1.5rem;
    }

    .icons-item h5 {
        font-size: 1rem;
    }

    /* Sidebar behavior */
    .sidebar {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 220px;
        height: 100%;
        box-shadow: 2px 0 5px rgba(0,0,0,0.2);
        z-index: 1000;
        transition: transform 0.3s ease-in-out;
        transform: translateX(-100%);
    }

    .sidebar.open {
        transform: translateX(0);
    }

    .sidebar-toggle {
        display: block;
        position: fixed;
        top: 10px;
        left: 10px;
        color: #fff;
        padding: 10px 15px;
        border: none;
        z-index: 1100;
        border-radius: 4px;
    }
}

@media (max-width: 575.98px) {
    .icons-item {
        width: 100%; /* Stack items */
    }

    .icon-lists {
        gap: 15px;
    }

    .icons-item a {
        padding: 25px 15px;
    }

    .icons-item a:hover {
        transform: translateY(-5px) scale(1.02);
    }
}

/* Special Effects for Different Services */
.icons-item:nth-child(1) a::before { background: linear-gradient(90deg, #3498db, #2ecc71); }
.icons-item:nth-child(2) a::before { background: linear-gradient(90deg, #e74c3c, #f39c12); }
.icons-item:nth-child(3) a::before { background: linear-gradient(90deg, #9b59b6, #3498db); }
.icons-item:nth-child(4) a::before { background: linear-gradient(90deg, #1abc9c, #2ecc71); }
.icons-item:nth-child(5) a::before { background: linear-gradient(90deg, #f1c40f, #e67e22); }
.icons-item:nth-child(6) a::before { background: linear-gradient(90deg, #e74c3c, #9b59b6); }
.icons-item:nth-child(7) a::before { background: linear-gradient(90deg, #34495e, #3498db); }
.icons-item:nth-child(8) a::before { background: linear-gradient(90deg, #16a085, #27ae60); }
.icons-item:nth-child(9) a::before { background: linear-gradient(90deg, #d35400, #f39c12); }
.icons-item:nth-child(10) a::before { background: linear-gradient(90deg, #c0392b, #e74c3c); }

.icons-item:nth-child(odd) a:hover {
    background: linear-gradient(135deg, #f9f9f9, #ffffff);
}

.icons-item:nth-child(even) a:hover {
    background: linear-gradient(135deg, #ffffff, #f9f9f9);
}
</style>

<style>
.icon-main {
    padding: 20px 0;
}

.icon-lists {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}

.icons-item {
    width: calc(50% - 20px);
    perspective: 1000px;
    transition: all 0.3s ease;
    position: relative;
}

.icons-item a {
    display: block;
    padding: 25px 15px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.05);
    color: #34495e;
    text-decoration: none !important;
    position: relative;
    z-index: 1;
}

/* Ripple Effect on Click */
.icons-item a::after {
    content: "";
    position: absolute;
    background: rgba(52, 152, 219, 0.3);
    border-radius: 50%;
    transform: scale(0);
    opacity: 0;
    pointer-events: none;
    z-index: 0;
    transition: transform 0.5s ease-out, opacity 0.8s ease-out;
}

.icons-item a:active::after {
    transform: scale(3);
    opacity: 1;
    transition: 0s;
    top: 50%;
    left: 50%;
    width: 100px;
    height: 100px;
    margin-top: -50px;
    margin-left: -50px;
}

/* Hover Glow and Bounce */
.icons-item a:hover {
    transform: translateY(-10px) scale(1.03) rotate(-1deg);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15), 0 0 10px rgba(52, 152, 219, 0.3);
}

.icons-item a:hover::before {
    height: 10px;
}

.icons-item a:hover img {
    transform: scale(1.08) rotate(3deg);
    filter: grayscale(0%);
}

.icons-item img {
    transition: all 0.3s ease;
    filter: grayscale(30%);
    max-width: 60px;
}

.icons-item i {
    color: #3498db;
    transition: all 0.3s ease;
    font-size: 1.8rem;
}

.icons-item a:hover i {
    color: #9b59b6;
    transform: translateY(-5px);
}

.icons-item h5 {
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    margin-top: 10px;
}

.icons-item a:hover h5 {
    color: #2c3e50;
    letter-spacing: 0.5px;
}

.icons-item h5::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 2px;
    background: #3498db;
    transition: all 0.3s ease;
}

.icons-item a:hover h5::after {
    width: 40px;
}

/* Gradient Highlights */
.icons-item a::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, #3498db, #2ecc71);
    transition: height 0.3s ease;
    z-index: 2;
}

.icons-item:nth-child(odd) a:hover {
    background: linear-gradient(135deg, #fefefe, #f9f9f9);
}

.icons-item:nth-child(even) a:hover {
    background: linear-gradient(135deg, #ffffff, #fafafa);
}

/* Responsive Adjustments */
@media (max-width: 767.98px) {
    .icons-item {
        width: calc(50% - 20px);
    }

    .card-header h3 {
        font-size: 1.5rem;
    }

    .icons-item h5 {
        font-size: 1rem;
    }

    /* Sidebar toggle setup */
    .sidebar {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 220px;
        height: 100%;
        background-color: #fff;
        box-shadow: 2px 0 5px rgba(0,0,0,0.2);
        z-index: 1000;
        transform: translateX(-100%);
        transition: transform 0.3s ease-in-out;
    }

    .sidebar.open {
        transform: translateX(0);
    }

    .sidebar-toggle {
        display: block;
        position: fixed;
        top: 10px;
        left: 10px;
        background: #3498db;
        color: #fff;
        padding: 10px 15px;
        border: none;
        z-index: 1100;
        border-radius: 4px;
    }
}

@media (max-width: 575.98px) {
    .icons-item {
        width: 100%;
    }

    .icon-lists {
        gap: 15px;
    }

    .icons-item a {
        padding: 25px 15px;
    }

    .icons-item a:hover {
        transform: translateY(-5px) scale(1.02);
    }
}
</style>
