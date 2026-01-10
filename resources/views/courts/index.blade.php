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
        filter: brightness(0.4); 
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
@endsection