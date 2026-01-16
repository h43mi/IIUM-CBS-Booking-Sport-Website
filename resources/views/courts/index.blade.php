@extends('master.layout')

@section('title', 'Home | IIUM CBS')

@section('content')

{{-- 1. LOAD SWIPER CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>

    html, body {
        overflow-x: hidden; /* Hides the horizontal scrollbar */
        max-width: 100%;
    }
    /* Force full width to touch edges */
    .full-bleed-hero {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        height: 600px; /* Adjust height here */
    }

    /* Make sure slides cover the whole area */
    .swiper {
        width: 100%;
        height: 100%;
    }

    .myHeroSwiper .swiper-slide {
        background-size: cover;
        background-position: center;
        /* Darken images slightly so text pops */
        filter: brightness(0.5); 
    }

    /* Ensure text sits on TOP of the slider */
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

{{-- UPDATED HERO SECTION START --}}
<div class="full-bleed-hero">
    
    {{-- A. SWIPER BACKGROUND SLIDER --}}
    <div class="swiper myHeroSwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide" style="background-image: url('{{ asset('assets/img/badminton.jpeg') }}');"></div>
            
            <div class="swiper-slide" style="background-image: url('{{ asset('assets/img/court2.jpg') }}');"></div>
            
            <div class="swiper-slide" style="background-image: url('{{ asset('assets/img/court3.jpg') }}');"></div>
            
            <div class="swiper-slide" style="background-image: url('{{ asset('assets/img/court1.webp') }}');"></div>
        </div>
        
        <div class="swiper-pagination"></div>
    </div>

    {{-- B. STATIC TEXT OVERLAY (Stays on top) --}}
    <div class="hero-content-overlay text-white text-center">
        <h1 class="display-3 fw-bold mb-3">IIUM Court Booking System</h1>
        <p class="lead fw-normal fs-4 mb-4 opacity-75">Play Your Sport in IIUM</p>
        <a href="#courts-list" class="btn btn-success btn-lg fw-bold px-5 rounded-pill shadow-sm">
            Book Now <i class="bi bi-arrow-down-short"></i>
        </a>
    </div>

</div>
{{-- UPDATED HERO SECTION END --}}

{{-- FEATURES SECTION --}}
<div class="row text-center my-5">
    <div class="col-md-4 mb-4">
        <div class="p-4 h-100 rounded-4 shadow-sm bg-white">
            <div class="mb-3 text-success fs-1">
                <i class="bi bi-calendar-check"></i>
            </div>
            <h5 class="fw-bold">Easy Booking</h5>
            <p class="text-muted small">
                Book courts anytime with just a few clicks using our simple system.
            </p>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="p-4 h-100 rounded-4 shadow-sm bg-white">
            <div class="mb-3 text-success fs-1">
                <i class="bi bi-clock-history"></i>
            </div>
            <h5 class="fw-bold">Real-Time Availability</h5>
            <p class="text-muted small">
                View court availability instantly and avoid booking conflicts.
            </p>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="p-4 h-100 rounded-4 shadow-sm bg-white">
            <div class="mb-3 text-success fs-1">
                <i class="bi bi-people"></i>
            </div>
            <h5 class="fw-bold">Student Friendly</h5>
            <p class="text-muted small">
                Designed specially for IIUM students and sports communities.
            </p>
        </div>
    </div>
</div>

<hr class="my-5 opacity-25">

{{-- COURT LIST SECTION --}}
<div id="courts-list" class="row text-center mb-5 mt-5">
    <div class="col-12">
        <h4 class="fw-bold mb-4">Select Sport</h4>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <button class="btn btn-dark rounded-pill px-4 filter-btn" onclick="filterCourts('Badminton', this)">Badminton</button>
            <button class="btn btn-outline-dark rounded-pill px-4 filter-btn" onclick="filterCourts('Futsal', this)">Futsal</button>
            <button class="btn btn-outline-dark rounded-pill px-4 filter-btn" onclick="filterCourts('Tennis', this)">Tennis</button>
            <button class="btn btn-outline-dark rounded-pill px-4 filter-btn" onclick="filterCourts('Volleyball', this)">Volleyball</button>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.25s ease, box-shadow .25s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgb(0, 0, 0);
    }
</style>

<div class="row justify-content-center">
    @foreach($courts as $court)
    <div class="col-md-4 mb-4 court-item" data-sport="{{ $court->type }}">
        <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden">
            
            <div style="height: 200px; overflow: hidden; background-color: #f0f0f0;">
                {{-- FIX: Check if the court has a specific image uploaded/assigned --}}
                @if($court->image)
                    {{-- Check if it's an uploaded file (in storage/courts) or a default asset --}}
                    @if(\Illuminate\Support\Str::startsWith($court->image, 'courts/'))
                        {{-- It is an uploaded image --}}
                        <img src="{{ asset('storage/' . $court->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $court->name }}">
                    @else
                        {{-- It is a default asset/seeded image --}}
                        <img src="{{ asset('assets/img/' . $court->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $court->name }}">
                    @endif
                @else
                    {{-- Fallback if absolutely no image is set --}}
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                        <i class="bi bi-image fs-1 opacity-25"></i>
                    </div>
                @endif
            </div>

            <div class="card-body text-center">
                <div class="mb-2">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">{{ $court->type }}</span>
                </div>
                <h4 class="card-title fw-bold my-3">{{ $court->name }}</h4>
                <p class="text-muted small">Standard {{ $court->type }} Court</p>
                <h3 class="text-success fw-bold">RM {{ number_format($court->price, 2) }}</h3>
                <div class="d-grid mt-4">
                    @auth
                        <a href="{{ route('bookings.create', $court->id) }}" class="btn btn-success rounded-pill py-2 fw-bold">Book Now</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-success rounded-pill py-2 fw-bold">Book Now</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div id="no-courts-msg" class="col-12 text-center mt-5" style="display: none;">
        <div class="alert alert-warning border-0 shadow-sm rounded-pill px-5 d-inline-block">
            No courts available for this sport yet.
        </div>
    </div>
</div>

<hr class="my-5 opacity-25">

{{-- 2. LOAD SWIPER JS --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Initialize Swiper
    var swiper = new Swiper(".myHeroSwiper", {
        spaceBetween: 0,
        effect: "fade", // Nice fade effect between images
        centeredSlides: true,
        autoplay: {
            delay: 3500, // Time in ms (3.5 seconds)
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    // Existing Filter Logic
    document.addEventListener("DOMContentLoaded", function() {
        const firstBtn = document.querySelector('.filter-btn');
        if(firstBtn) filterCourts('Badminton', firstBtn); 
    });

    function filterCourts(sportType, btn) {
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('btn-dark');
            b.classList.add('btn-outline-dark');
        });
        if(btn) {
            btn.classList.remove('btn-outline-dark');
            btn.classList.add('btn-dark');
        }
        let cards = document.querySelectorAll('.court-item');
        let visibleCount = 0;
        cards.forEach(card => {
            if (card.getAttribute('data-sport') === sportType) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        let msg = document.getElementById('no-courts-msg');
        if (visibleCount === 0) {
            msg.style.display = 'block';
        } else {
            msg.style.display = 'none';
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        
        // Check if Laravel sent a success message in the session
        @if(session('success'))
            Swal.fire({
                title: 'Message Sent!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#ff0000', // Matches your red Contact button
                confirmButtonText: 'Great!'
            });
        @endif
        
    });
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css">

{{-- USER FEEDBACK SECTION --}}
<div class="my-5 py-5 bg-light rounded-4 shadow-sm">
    <div class="text-center mb-4">
        <h3 class="fw-bold">What Our Users Say</h3>
        <p class="text-muted">Feedback from students who used the court booking system</p>
    </div>

    <div class="swiper feedbackSwiper px-4 feedback-swiper">
    <style>
    /* Move swiper pagination below cards */
        .feedback-swiper {
            padding-bottom: 10px; /* Space for pagination */
        }

        .feedback-swiper .swiper-pagination {
            position: relative;
            margin-top: 25px;
        }
    </style>
        <div class="swiper-wrapper">

            {{-- Feedback 1 --}}
            <div class="swiper-slide">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <p class="text-muted fst-italic">
                        “The booking process is very smooth and easy to use. I can book courts anytime!”
                    </p>
                    <hr>
                    <h6 class="fw-bold mb-0">Muhammad Adam Shazwan</h6>
                    <small class="text-muted">Mustangs Badminton Player</small>
                </div>
            </div>

            {{-- Feedback 2 --}}
            <div class="swiper-slide">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <p class="text-muted fst-italic">
                        “I love the clean interface and fast booking confirmation. Highly recommended.”
                    </p>
                    <hr>
                    <h6 class="fw-bold mb-0">Abdul Halim</h6>
                    <small class="text-muted">Mustangs Volleyball Player</small>
                </div>
            </div>

            {{-- Feedback 3 --}}
            <div class="swiper-slide">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <p class="text-muted fst-italic">
                        “This system really helps manage court schedules efficiently. No more clashes.”
                    </p>
                    <hr>
                    <h6 class="fw-bold mb-0">Daniel Asy</h6>
                    <small class="text-muted">Sports Committee</small>
                </div>
            </div>

            {{-- Feedback 4 --}}
            <div class="swiper-slide">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <p class="text-muted fst-italic">
                        “Booking courts at IIUM has never been this convenient. Great job!”
                    </p>
                    <hr>
                    <h6 class="fw-bold mb-0">Alep Nazar</h6>
                    <small class="text-muted">Mustangs Tennis Player</small>
                </div>
            </div>

            {{-- Feedback 5 --}}
            <div class="swiper-slide">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 color-light">
                    <p class="text-muted fst-italic">
                        “Padu CBS ni. Memang memudahkan kerja student untuk booking. TQVM Developer”
                    </p>
                    <hr>
                    <h6 class="fw-bold mb-0">Fahim Faizal</h6>
                    <small class="text-muted">Mustangs Tennis Player</small>
                </div>
            </div>

            {{-- Feedback 6 --}}
            <div class="swiper-slide">
                <div class="card border border-white shadow-sm rounded-4 p-4 h-100">
                    <p class="text-muted fst-italic">
                        “Kemah keming sistem ni. Sek kito mandi lanjey”
                    </p>
                    <hr>
                    <h6 class="fw-bold mb-0">Muhammad Muaz</h6>
                    <small class="text-muted">Mustangs Hockey Player</small>
                </div>
            </div>

        </div>

        {{-- Navigation --}}
        <div class="swiper-pagination"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>

<script>
    const feedbackSwiper = new Swiper(".feedbackSwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".feedbackSwiper .swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".feedbackSwiper .swiper-button-next",
            prevEl: ".feedbackSwiper .swiper-button-prev",
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            },
        },
    });
</script>

{{-- CONTACT US SECTION START --}}
<style>
    /* UPDATED: Changed background to light grey */
    .contact-section-bg {
        background-color: #f8f9fa; /* Light grey */
        color: #333; /* Dark text */
    }
    
    /* UPDATED: Added border and rounded corners to inputs for visibility on white */
    .contact-input {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        width: 100%;
        background-color: #f8f9fa;
    }
    
    .contact-btn {
        background-color: #198754; /* Bright red */
        color: white;
        border: none;
        border-radius: 50px; /* Pill shape */
        padding: 10px 40px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.2s;
    }
    
    .contact-btn:hover {
        background-color: #087542;
        color: white;
        box-shadow: 0 4px 10px rgba(204, 0, 0, 0.3);
    }

    .contact-header {
        font-weight: 400;
        color: #333;
        font-size: 2.5rem;
    }

    .contact-sub-header {
        color: #198754; /* Red text */
        font-weight: bold;
        margin-bottom: 20px;
    }

    .contact-icon {
        font-size: 1.5rem;
        margin-right: 15px;
        color: #198754; /* Red icon */
    }
    
    /* UPDATED: Changed text color to dark grey */
    .contact-info-text {
        color: #6c757d; /* Text muted */
        font-size: 0.95rem;
    }
</style>

<div class="full-bleed-section contact-section-bg py-5 my-5">
    <div class="container">
        {{-- UPDATED: Wrapped content in a white shadow card --}}
        <div class="card border-0 shadow rounded-4 p-4 p-md-5 bg-white">
            <div class="row align-items-center">
                
                {{-- LEFT COLUMN: FORM --}}
                <div class="col-md-6">
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf 
                        
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="name" class="contact-input" placeholder="Name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" class="contact-input" placeholder="Email" required>
                            </div>
                        </div>
                        
                        <textarea name="message" class="contact-input" rows="6" placeholder="Message" required></textarea>
                        
                        <div class="text-center mt-3">
                            <button type="submit" class="contact-btn shadow-sm">Send Message</button>
                        </div>
                    </form>
                </div>

                {{-- RIGHT COLUMN: INFO --}}
                <div class="col-md-6 ps-md-5 mt-5 mt-md-0">
                    <h2 class="contact-header mb-0">CONTACT US</h2>
                    <p class="contact-sub-header">IIUM SPORTS CENTRE</p>
                    
                    {{-- Address --}}
                    <div class="d-flex align-items-start mb-4">
                        <i class="bi bi-geo-alt-fill contact-icon"></i>
                        <p class="contact-info-text mb-0">
                            IIUM Sports Complex, <br>
                            International Islamic University Malaysia, <br>
                            Jalan Gombak, 53100 Kuala Lumpur.
                        </p>
                    </div>

                    {{-- Email --}}
                    <div class="d-flex align-items-center mb-4">
                        <i class="bi bi-envelope-fill contact-icon"></i>
                        <p class="contact-info-text mb-0">
                            booksportiium@gmail.com
                        </p>
                    </div>

                    {{-- Phone --}}
                    <div class="d-flex align-items-center">
                        <i class="bi bi-telephone-fill contact-icon"></i>
                        <p class="contact-info-text mb-0">
                            +603 6421 4000
                        </p>
                    </div>
                </div>

            </div>
        </div> {{-- End of Card Wrapper --}}
    </div>
</div>
{{-- CONTACT US SECTION END --}}


@endsection
