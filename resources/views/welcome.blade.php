<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admiro admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Admiro admin template, best javascript admin, dashboard template, bootstrap admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <title>FEE24MFB &mdash; AGENCY BANKING</title>
    <meta name="theme-color" content="#4f8cff">
    <!-- Favicon icon-->
    <link rel="icon" href="../assets/images/logo/logo-dark.png" type="image/x-icon">
    <link rel="shortcut icon" href="../assets/images/logo/logo-dark.png" type="image/x-icon">
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,500;6..12,600;6..12,700;6..12,800;6..12,900;6..12,1000&amp;display=swap" rel="stylesheet">
    <!-- Flag icon css -->
    <link rel="stylesheet" href="../assets/css/vendors/flag-icon.css">
    <!-- iconly-icon-->
    <link rel="stylesheet" href="../assets/css/iconly-icon.css">
    <link rel="stylesheet" href="../assets/css/bulk-style.css">
    <!-- iconly-icon-->
    <link rel="stylesheet" href="../assets/css/themify.css">
    <!--fontawesome-->
    <link rel="stylesheet" href="../assets/css/fontawesome-min.css">
    <!-- Whether Icon css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/weather-icons/weather-icons.min.css">
    <!-- App css -->
    <link id="color" rel="stylesheet" href="../assets/css/color-1.css" media="screen">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/buttons.css">
    <!-- Font Awesome 6 (Free Version) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
    <!-- tap on top starts-->
    <div class="tap-top"><i class="iconly-Arrow-Up icli"></i></div>
    <!-- tap on tap ends-->

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
            --light-gray: #e2e8f0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Nunito Sans', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            color: var(--dark);
            line-height: 1.6;
            background-color: #f8fafc;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        /* Header */
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            z-index: 100;
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 0;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .logo i {
            font-size: 2rem;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 600;
            transition: color 0.3s;
            font-size: 1.05rem;
        }
        
        .nav-links a:hover {
            color: var(--primary);
        }
        
        .cta-button {
            background-color: var(--primary);
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 0.3rem;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .cta-button:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.2);
        }
        
        /* Hero Section */
        .hero {
            padding: 10rem 0 6rem;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0) 70%);
            z-index: 0;
        }
        
        .hero-content {
            display: flex;
            align-items: center;
            gap: 3rem;
            position: relative;
            z-index: 1;
        }
        
        .hero-text {
            flex: 1;
        }
        
        .hero-image {
            flex: 1;
            position: relative;
        }
        
        .hero-image img {
            width: 100%;
            border-radius: 0.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transform: perspective(1000px) rotateY(-10deg);
            transition: transform 0.5s;
        }
        
        .hero-image:hover img {
            transform: perspective(1000px) rotateY(0deg);
        }
        
        h1 {
            font-size: 3.2rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, #1e3a8a, #2563eb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .subtitle {
            font-size: 1.2rem;
            color: var(--gray);
            margin-bottom: 2rem;
            max-width: 600px;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .primary-button {
            background-color: var(--primary);
            color: white;
            padding: 0.9rem 1.8rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
        }
        
        .primary-button:hover {
            background-color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(37, 99, 235, 0.3);
        }
        
        .secondary-button {
            background-color: white;
            color: var(--primary);
            padding: 0.9rem 1.8rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            border: 2px solid var(--primary);
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .secondary-button:hover {
            background-color: #f0f9ff;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(37, 99, 235, 0.1);
        }
        
        /* Features */
        .features {
            padding: 6rem 0;
            background-color: white;
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, var(--primary), #93c5fd);
            border-radius: 2px;
        }
        
        .section-subtitle {
            text-align: center;
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto 3rem;
            font-size: 1.1rem;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .feature-card {
            background-color: white;
            border-radius: 0.8rem;
            padding: 2.5rem 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid var(--light-gray);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #e0f2fe 0%, #bfdbfe 100%);
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        
        .feature-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark);
        }
        
        .feature-desc {
            color: var(--gray);
            line-height: 1.7;
        }
        
        /* Services Section */
        .services {
            padding: 6rem 0;
            background-color: #f8fafc;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2.5rem;
            margin-top: 3rem;
        }
        
        .service-card {
            background-color: white;
            border-radius: 0.8rem;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }
        
        .service-img {
            height: 200px;
            overflow: hidden;
        }
        
        .service-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .service-card:hover .service-img img {
            transform: scale(1.1);
        }
        
        .service-content {
            padding: 2rem;
        }
        
        .service-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark);
        }
        
        .service-desc {
            color: var(--gray);
            margin-bottom: 1.5rem;
            line-height: 1.7;
        }
        
        .service-link {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }
        
        .service-link:hover {
            color: var(--primary-dark);
            gap: 0.8rem;
        }
        
        /* Contact Section */
        .contact {
            padding: 6rem 0;
            background-color: white;
        }
        
        .contact-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
            margin-top: 3rem;
        }
        
        .contact-info {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            padding: 3rem;
            border-radius: 0.8rem;
            color: white;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.2);
        }
        
        .contact-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .contact-text {
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .contact-details {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        
        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .contact-icon {
            font-size: 1.5rem;
            margin-top: 0.2rem;
            color: white;
        }
        
        .contact-form {
            background-color: white;
            padding: 3rem;
            border-radius: 0.8rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--light-gray);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
        }
        
        .form-input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid var(--light-gray);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        textarea.form-input {
            min-height: 150px;
            resize: vertical;
        }
        
        .submit-button {
            background-color: var(--primary);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            font-size: 1rem;
        }
        
        .submit-button:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.2);
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 6rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjA1KSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNwYXR0ZXJuKSIvPjwvc3ZnPg==');
            opacity: 0.2;
        }
        
        .cta-container {
            position: relative;
            z-index: 1;
        }
        
        .cta-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
        }
        
        .cta-text {
            max-width: 700px;
            margin: 0 auto 2.5rem;
            opacity: 0.9;
            font-size: 1.1rem;
        }
        
        .cta-button-large {
            background-color: white;
            color: var(--primary);
            padding: 1rem 2.5rem;
            border-radius: 0.5rem;
            font-weight: 700;
            text-decoration: none;
            font-size: 1.1rem;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .cta-button-large:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        /* Footer */
        footer {
            background-color: var(--dark);
            color: white;
            padding: 6rem 0 2rem;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }
        
        .footer-logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .footer-about p {
            opacity: 0.8;
            margin-bottom: 1.5rem;
            line-height: 1.7;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
        }
        
        .social-links a {
            color: white;
            font-size: 1.2rem;
            opacity: 0.7;
            transition: all 0.3s;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .social-links a:hover {
            opacity: 1;
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
        }
        
        .footer-links h3 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }
        
        .footer-links h3::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 50%;
            height: 3px;
            background-color: var(--primary);
            border-radius: 2px;
        }
        
        .footer-links ul {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 0.8rem;
        }
        
        .footer-links a {
            color: white;
            opacity: 0.8;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .footer-links a:hover {
            opacity: 1;
            color: #93c5fd;
            gap: 0.8rem;
        }
        
        .footer-links a i {
            font-size: 0.8rem;
        }
        
        .copyright {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.7;
            font-size: 0.9rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-content {
                flex-direction: column;
            }
            
            h1 {
                font-size: 2.5rem;
            }
            
            .hero-buttons {
                flex-direction: column;
            }
            
            .hero-image {
                order: -1;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .cta-title {
                font-size: 2rem;
            }
        }


        /* Mobile Menu Styles */
.mobile-menu-btn {
    display: none;
    background: transparent;
    border: none;
    color: var(--dark);
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0.5rem;
    z-index: 1000;
}

.mobile-menu-active .nav-links {
    display: flex;
    flex-direction: column;
    position: fixed;
    top: 80px;
    left: 0;
    width: 100%;
    background: white;
    padding: 2rem;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

/* Header Scroll Effects */
.header-scrolled {
    box-shadow: 0 2px 20px rgba(0,0,0,0.1);
    background-color: rgba(255,255,255,0.98) !important;
    backdrop-filter: blur(5px);
}

.header-hidden {
    transform: translateY(-100%);
}

header {
    transition: all 0.3s ease;
}

/* Active Link Styling */
.nav-links a.active {
    color: var(--primary) !important;
    font-weight: 700;
}

/* Responsive Nav */
@media (max-width: 992px) {
    .mobile-menu-enabled .nav-links {
        display: none;
    }
    
    .mobile-menu-btn {
        display: block;
    }
    
    .mobile-menu-active .nav-links {
        display: flex;
    }
}
    </style>

    <!-- Header -->
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                     <img src="assets/images/logo/logo.png" alt="FEE24MFB Logo" class="logo-img" width="30" height="30">
                    <span>FEE24MFB</span>
                </div>
                <div class="nav-links">
                    <a href="#">Home</a>
                    <a href="#features">Features</a>
                    <a href="#services">Services</a>
                    <a href="#contact">Contact</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Transform Your Business With Our Innovative Solutions</h1>
                    <p class="subtitle">Streamline operations, boost productivity, and drive growth with our cutting-edge platform designed for modern enterprises.</p>
                    <div class="hero-buttons">
                        <a href="{{ route('register') }}" class="primary-button">
                            <i class="fas fa-user-plus"></i>
                            Get Started
                        </a>
                        <a href="{{ route('login') }}" class="secondary-button">
                            <i class="fas fa-sign-in-alt"></i>
                            Login
                        </a>
                    </div>
                </div>
                
                <div class="hero-image">
                    <img src="assets/images/login/001.png" alt="Business analytics dashboard">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2 class="section-title">Key Features</h2>
            <p class="section-subtitle">Discover the powerful features that will revolutionize the way you do business</p>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="feature-title">Advanced Analytics</h3>
                    <p class="feature-desc">Gain valuable insights with our comprehensive analytics dashboard that helps you make data-driven decisions.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="feature-title">Bank-Grade Security</h3>
                    <p class="feature-desc">Your data is protected with enterprise-level security measures and encryption protocols.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <h3 class="feature-title">Real-Time Sync</h3>
                    <p class="feature-desc">All your data is synchronized in real-time across all devices and platforms.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h3 class="feature-title">Customizable Workflows</h3>
                    <p class="feature-desc">Tailor the system to your specific business needs with customizable workflows.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">Team Collaboration</h3>
                    <p class="feature-desc">Enhance teamwork with built-in collaboration tools and shared workspaces.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="feature-title">Mobile Friendly</h3>
                    <p class="feature-desc">Access your data and manage your business from anywhere with our mobile-optimized platform.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <div class="container">
            <h2 class="section-title">Our Services</h2>
            <p class="section-subtitle">Comprehensive solutions designed to meet all your business needs</p>
            
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-img">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Agency Banking">
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">Agency Banking</h3>
                        <p class="service-desc">Expand your financial services with our comprehensive agency banking solutions that bring banking closer to your customers.</p>
                        <a href="#" class="service-link">
                            Learn more
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="service-card">
                    <div class="service-img">
                        <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Digital Payments">
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">Digital Payments</h3>
                        <p class="service-desc">Secure and seamless payment solutions that enable your customers to transact anytime, anywhere.</p>
                        <a href="#" class="service-link">
                            Learn more
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="service-card">
                    <div class="service-img">
                        <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1511&q=80" alt="Financial Management">
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">Financial Management</h3>
                        <p class="service-desc">Comprehensive tools to manage your finances, track expenses, and optimize your financial operations.</p>
                        <a href="#" class="service-link">
                            Learn more
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <h2 class="section-title">Contact Us</h2>
            <p class="section-subtitle">Get in touch with our team for any inquiries or support</p>
            
            <div class="contact-container">
                <div class="contact-info">
                    <h3 class="contact-title">Let's talk about your business needs</h3>
                    <p class="contact-text">Our team is ready to help you find the perfect solution for your organization. Reach out to us and we'll respond as soon as possible.</p>
                    
                    <div class="contact-details">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt contact-icon"></i>
                            <div>
                                <h4>Location</h4>
                                <p>123 Business Avenue, Financial District</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <i class="fas fa-phone-alt contact-icon"></i>
                            <div>
                                <h4>Phone</h4>
                                <p>+1 (234) 567-8900</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <i class="fas fa-envelope contact-icon"></i>
                            <div>
                                <h4>Email</h4>
                                <p>info@fee24mfb.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form">
                    <form>
                        <div class="form-group">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" id="name" class="form-input" placeholder="John Doe" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" class="form-input" placeholder="john@example.com" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" id="subject" class="form-input" placeholder="How can we help?">
                        </div>
                        
                        <div class="form-group">
                            <label for="message" class="form-label">Message</label>
                            <textarea id="message" class="form-input" placeholder="Your message here..."></textarea>
                        </div>
                        
                        <button type="submit" class="submit-button">
                            <i class="fas fa-paper-plane"></i>
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-container">
                <h2 class="cta-title">Ready to Transform Your Business?</h2>
                <p class="cta-text">Join thousands of businesses that are already benefiting from our innovative solutions. Get started today and experience the difference.</p>
                <a href="{{ route('register') }}" class="cta-button-large">
                    <i class="fas fa-rocket"></i>
                    Get Started Now
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-about">
                    <div class="footer-logo">
                         <img src="assets/images/logo/logo.png" alt="FEE24MFB Logo" class="logo-img" width="50" height="50">
                        <span>FEE24MFB</span>
                    </div>
                    <p>Innovative financial solutions designed to empower businesses and individuals with cutting-edge banking technology.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                
                <div class="footer-links">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Home</a></li>
                        <li><a href="#features"><i class="fas fa-chevron-right"></i> Features</a></li>
                        <li><a href="#services"><i class="fas fa-chevron-right"></i> Services</a></li>
                        <li><a href="#contact"><i class="fas fa-chevron-right"></i> Contact</a></li>
                        <li><a href="{{ route('login') }}"><i class="fas fa-chevron-right"></i> Login</a></li>
                    </ul>
                </div>
                
                <div class="footer-links">
                    <h3>Services</h3>
                    <ul>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Agency Banking</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Digital Payments</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Financial Management</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Business Analytics</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Customer Support</a></li>
                    </ul>
                </div>
                
                <div class="footer-links">
                    <h3>Support</h3>
                    <ul>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Help Center</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Documentation</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> API Reference</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Community</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Status</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2023 FEE24MFB. All rights reserved. | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
            </div>
        </div>
    </footer>
</body>
</html>


<script>

    document.addEventListener('DOMContentLoaded', function() {
    // ======================
    // Header Elements
    // ======================
    const header = document.querySelector('header');
    const nav = document.querySelector('nav');
    const navLinks = document.querySelectorAll('.nav-links a');
    const logo = document.querySelector('.logo');
    const mobileMenuBtn = document.createElement('button');
    const mobileMenuIcon = document.createElement('i');
    
    // ======================
    // Mobile Menu Setup
    // ======================
    function setupMobileMenu() {
        mobileMenuBtn.classList.add('mobile-menu-btn');
        mobileMenuIcon.classList.add('fas', 'fa-bars');
        mobileMenuBtn.appendChild(mobileMenuIcon);
        mobileMenuBtn.setAttribute('aria-label', 'Toggle navigation menu');
        nav.appendChild(mobileMenuBtn);
        
        // Toggle mobile menu
        mobileMenuBtn.addEventListener('click', function() {
            nav.classList.toggle('mobile-menu-active');
            const isOpen = nav.classList.contains('mobile-menu-active');
            mobileMenuIcon.classList.toggle('fa-bars', !isOpen);
            mobileMenuIcon.classList.toggle('fa-times', isOpen);
            document.body.style.overflow = isOpen ? 'hidden' : '';
        });
        
        // Close mobile menu when clicking a link
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (nav.classList.contains('mobile-menu-active')) {
                    nav.classList.remove('mobile-menu-active');
                    mobileMenuIcon.classList.remove('fa-times');
                    mobileMenuIcon.classList.add('fa-bars');
                    document.body.style.overflow = '';
                }
            });
        });
    }
    
    // ======================
    // Sticky Header
    // ======================
    function handleStickyHeader() {
        let lastScroll = 0;
        const headerHeight = header.offsetHeight;
        
        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;
            
            // Hide/show header on scroll
            if (currentScroll > lastScroll && currentScroll > headerHeight) {
                // Scrolling down
                header.classList.add('header-hidden');
            } else {
                // Scrolling up
                header.classList.remove('header-hidden');
            }
            
            // Add shadow when scrolled
            if (currentScroll > 10) {
                header.classList.add('header-scrolled');
            } else {
                header.classList.remove('header-scrolled');
            }
            
            lastScroll = currentScroll;
        });
    }
    
    // ======================
    // Active Link Highlighting
    // ======================
    function setActiveLink() {
        const sections = document.querySelectorAll('section');
        
        window.addEventListener('scroll', function() {
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                
                if (pageYOffset >= (sectionTop - 100)) {
                    current = section.getAttribute('id');
                }
            });
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });
    }
    
    // ======================
    // Smooth Scrolling
    // ======================
    function enableSmoothScrolling() {
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }
    
    // ======================
    // Initialize Functions
    // ======================
    setupMobileMenu();
    handleStickyHeader();
    setActiveLink();
    enableSmoothScrolling();
    
    // ======================
    // Responsive Adjustments
    // ======================
    function handleResponsiveChanges() {
        // Check if mobile menu should be visible
        if (window.innerWidth < 992) {
            nav.classList.add('mobile-menu-enabled');
        } else {
            nav.classList.remove('mobile-menu-enabled', 'mobile-menu-active');
            mobileMenuIcon.classList.remove('fa-times');
            mobileMenuIcon.classList.add('fa-bars');
            document.body.style.overflow = '';
        }
    }
    
    // Run on load and resize
    handleResponsiveChanges();
    window.addEventListener('resize', handleResponsiveChanges);
    
    // ======================
    // Logo Click to Home
    // ======================
    logo.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});

</script>