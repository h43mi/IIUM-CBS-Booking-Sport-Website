<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IIUM CBS')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .navbar-brand img { height: 40px; }
        .nav-link { font-weight: 500; color: #555; transition: 0.2s; }
        .nav-link:hover { color: #000; }
        .dropdown-item:active { background-color: #00665c; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3 mb-0">
        <div class="container">
            
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" onerror="this.style.display='none'" class="me-2">
                <span class="fw-bold text-dark">IIUM CBS</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                
                <ul class="navbar-nav ms-auto align-items-center gap-3">
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About Us</a>
                    </li>

                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bookings.dashboard') }}">Dashboard</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 14px;">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3 p-2">
                        <li>
                            <a class="dropdown-item rounded-2" href="{{ route('profile.show') }}">
                                Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item rounded-2 text-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-outline-dark rounded-pill px-4" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-dark rounded-pill px-4" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>

            </div>
        </div>
    </nav>


    <style>
    .full-bleed-hero {
        width: 100vw;              /* Force full viewport width */
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;        /* Pull to left edge */
        margin-right: -50vw;       /* Pull to right edge */
        border-radius: 0 !important; /* Ensure corners are sharp */
        /* If there is a white gap at the top, un-comment the line below and adjust the number */
        /* margin-top: -20px; */ 
    }
    .swiper {
        width: 100%;
        height: 100%;
    }

    .swiper-slide {
        background-size: cover;
        background-position: center;
        /* Darken images slightly so text pops */
        filter: brightness(0.4); 
    }

    .hero-content-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10; /* Higher than swiper */
        pointer-events: none; /* Lets clicks pass through to swiper if needed, but we re-enable for buttons */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    /* Re-enable clicking on the button/text */
    .hero-content-overlay * {
        pointer-events: auto;
    }
</style>

    <div class="container" style="min-height: 80vh;">
        @yield('content')
    </div>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <small class="opacity-75">&copy; {{ date('Y') }} IIUM Court Booking System. All rights reserved.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>