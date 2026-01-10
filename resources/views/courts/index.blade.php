@extends('master.layout')

@section('title', 'Home | IIUM CBS')

@section('content')

<div class="position-relative p-5 text-center mb-5 rounded-4 shadow-sm" 
     style="background-image: url('{{ asset('assets/img/badminton.jpeg') }}'); 
            background-size: cover; 
            background-position: center; 
            height: 650px; 
            display: flex; 
            align-items: center; 
            justify-content: center;">

    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); border-radius: inherit;"></div>

    <div class="position-relative text-white">
        <h1 class="display-4 fw-bold">IIUM Court Booking System</h1>
        <p class="lead fw-normal fs-3">Play Your Sport in IIUM</p>
        <a href="#courts-list" class="btn btn-primary fw-bold mt-3 px-4 rounded-pill">Book Now</a>
    </div>
</div>

<div id="courts-list" class="row text-center mb-5">
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
                <img src="{{ asset('assets/img/' . $currentImage) }}" 
                     class="w-100 h-100 object-fit-cover" 
                     alt="Court Image"> 
            </div>
            
            <div class="card-body text-center">
                <div class="mb-2">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                        {{ $court->type }}
                    </span>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Run filter for the first active button (Badminton) on page load
        const firstBtn = document.querySelector('.filter-btn');
        if(firstBtn) filterCourts('Badminton', firstBtn); 
    });

    function filterCourts(sportType, btn) {
        // 1. RESET ALL BUTTONS
        // Remove 'btn-dark' (Black) from ALL buttons and make them 'btn-outline-dark' (White)
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('btn-dark');
            b.classList.add('btn-outline-dark');
        });
        
        // 2. ACTIVATE CLICKED BUTTON
        // Make the clicked button 'btn-dark' (Black)
        if(btn) {
            btn.classList.remove('btn-outline-dark');
            btn.classList.add('btn-dark');
        }

        // 3. FILTER CARDS
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

        // 4. SHOW/HIDE EMPTY MESSAGE
        let msg = document.getElementById('no-courts-msg');
        if (visibleCount === 0) {
            msg.style.display = 'block';
        } else {
            msg.style.display = 'none';
        }
    }
</script>
@endsection