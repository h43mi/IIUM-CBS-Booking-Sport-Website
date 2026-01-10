@extends('master.layout')

@section('title', 'Home | IIUM CBS')

@section('content')

{{-- 1. LOAD SWIPER CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
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

    .swiper-slide {
        background-size: cover;
        background-position: center;
        /* Darken images slightly so text pops */
        filter: brightness(0.2); 
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

{{-- FEATURES / ICONS SECTION START --}}
<style>
    /* 1. Generic Full Width Class (Reusable) */
    .full-bleed-section {
        width: 100vw;              /* Force full viewport width */
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;        /* Pull to left edge */
        margin-right: -50vw;       /* Pull to right edge */
    }

    /* 2. Custom Icon Box Styles */
    .feature-icon-box {
        width: 70px;
        height: 70px;
        background-color: white;
        color: black;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem auto; 
        border-radius: 4px;
    }
    
    .feature-title {
        letter-spacing: 2px;
        font-size: 0.9rem;
    }
    
    .feature-desc {
        color: #cccccc;
        font-size: 0.9rem;
        font-weight: 300;
        line-height: 1.6;
    }
    
    .feature-desc em {
        font-style: italic;
        color: white;
        font-weight: 500;
    }
</style>

{{-- Added 'full-bleed-section' class here --}}
<div class="full-bleed-section container-fluid bg-black text-white py-5 mb-5">
    <div class="container">
        <div class="row text-center">
            
            {{-- 1. BADMINTON --}}
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="feature-icon-box shadow-sm">
                    <i class="bi bi-lightning-fill fs-2"></i>
                </div>
                <h5 class="fw-bold text-uppercase feature-title mb-3">Badminton</h5>
                <p class="feature-desc px-2">
                    Official size <em>10mm rubberized</em> Badminton courts available for hourly rental at <em>superb rates!</em>
                </p>
            </div>

            {{-- 2. FUTSAL --}}
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="feature-icon-box shadow-sm">
                    <i class="bi bi-dribbble fs-2"></i>
                </div>
                <h5 class="fw-bold text-uppercase feature-title mb-3">Futsal Court</h5>
                <p class="feature-desc px-2">
                    Interlocking official size <em>rubberized Futsal</em> Sports Court available for rental hourly.
                </p>
            </div>

            {{-- 3. VOLLEYBALL --}}
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="feature-icon-box shadow-sm">
                    <i class="bi bi-life-preserver fs-2"></i>
                </div>
                <h5 class="fw-bold text-uppercase feature-title mb-3">Volleyball</h5>
                <p class="feature-desc px-2">
                    Professional <em>indoor flooring</em> suitable for high-impact tournaments and <em>casual play</em>.
                </p>
            </div>

            {{-- 4. TENNIS --}}
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="feature-icon-box shadow-sm">
                    <i class="bi bi-circle-fill fs-3"></i>
                </div>
                <h5 class="fw-bold text-uppercase feature-title mb-3">Tennis</h5>
                <p class="feature-desc px-2">
                    Standard <em>hard court</em> surfacing designed for optimal ball bounce and <em>long term</em> booking.
                </p>
            </div>

        </div>
    </div>
</div>
{{-- FEATURES / ICONS SECTION END --}}

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

<div class="row justify-content-center">
    @foreach($courts as $court)
    <div class="col-md-4 mb-4 court-item" data-sport="{{ $court->type }}">
        <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden">
            @php
                $images = ['court1.webp', 'court2.jpg', 'court3.jpg'];
                $currentImage = $images[$loop->index % count($images)];
            @endphp
            <div style="height: 200px; overflow: hidden; background-color: #f0f0f0;">
                <img src="{{ asset('assets/img/' . $currentImage) }}" class="w-100 h-100 object-fit-cover" alt="Court Image"> 
            </div>
            <div class="card-body text-center">
                <div class="mb-2">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">{{ $court->type }}</span>
                </div>
                <h4 class="card-title fw-bold my-3">{{ $court->name }}</h4>
                <p class="text-muted small">Standard {{ $court->type }} Court</p>
                <h3 class="text-success fw-bold">RM {{ $court->price }}</h3>
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



{{-- 2. LOAD SWIPER JS --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

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
</script>

{{-- CONTACT US SECTION START --}}
<style>
    /* Custom grey background specific to contact section */
    .contact-section-bg {
        background-color: #a6a6a6; /* Medium grey match */
        color: white;
    }
    
    .contact-input {
        border: none;
        border-radius: 0;
        padding: 15px;
        margin-bottom: 15px;
        width: 100%;
    }
    
    .contact-btn {
        background-color: #ff0000; /* Bright red */
        color: white;
        border: none;
        border-radius: 50px; /* Pill shape */
        padding: 10px 40px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .contact-btn:hover {
        background-color: #cc0000;
        color: white;
    }

    .contact-header {
        font-weight: 400; /* Thin font for "CONTACT US" */
        color: #333;
        font-size: 2.5rem;
    }

    .contact-sub-header {
        color: #ff0000; /* Red text */
        font-weight: bold;
        margin-bottom: 20px;
    }

    .contact-icon {
        font-size: 1.5rem;
        margin-right: 15px;
        color: black;
    }
    
    .contact-info-text {
        color: white;
        font-size: 0.95rem;
    }
</style>

<div class="full-bleed-section contact-section-bg py-5">
    <div class="container">
        <div class="row align-items-center">
            
            {{-- LEFT COLUMN: FORM --}}
            <div class="col-md-6">
                {{-- Point the form to the route we will create in Part 2 --}}
                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf {{-- Security token required by Laravel --}}
                    
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
                        <button type="submit" class="contact-btn">Send Message</button>
                    </div>
                </form>
            </div>

            {{-- RIGHT COLUMN: INFO --}}
            <div class="col-md-6 ps-md-5 mt-4 mt-md-0">
                <h2 class="contact-header mb-0">CONTACT US</h2>
                <p class="contact-sub-header">FRENZY SPORTS ARENA SHAH ALAM</p>
                
                {{-- Address --}}
                <div class="d-flex align-items-start mb-3">
                    <i class="bi bi-geo-alt-fill contact-icon"></i>
                    <p class="contact-info-text mb-0">
                        Lot 7 Jalan Lada Sulah 16/11, seksyen 16, <br>
                        40150 Shah Alam, Selangor
                    </p>
                </div>

                {{-- Email --}}
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-chat-left-text-fill contact-icon"></i> <p class="contact-info-text mb-0">
                        frenzy.erwan@gmail.com
                    </p>
                </div>

                {{-- Phone --}}
                <div class="d-flex align-items-center">
                    <i class="bi bi-telephone-fill contact-icon"></i>
                    <p class="contact-info-text mb-0">
                        0355100175 or 0192379934
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
{{-- CONTACT US SECTION END --}}


@endsection