@extends('master.layout')

@section('title', 'Home | IIUM CBS')

@section('content')

{{-- Hero Section --}}
<div class="position-relative p-5 text-center mb-5 rounded-4 shadow-sm overflow-hidden" 
     style="height: 500px;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
                background-image: url('{{ asset('assets/img/badminton.jpeg') }}'); 
                background-size: cover; background-position: center; filter: brightness(0.4);"></div>
    
    <div class="position-relative h-100 d-flex flex-column align-items-center justify-content-center text-white" style="z-index: 2;">
        <h1 class="display-4 fw-bold mb-3">IIUM Court Booking System</h1>
        <p class="lead fw-normal fs-4 mb-4 opacity-75">Play your favorite sports on campus.</p>
        <a href="#courts-list" class="btn btn-success btn-lg fw-bold px-5 rounded-pill shadow-sm">
            Book Now <i class="bi bi-arrow-down-short"></i>
        </a>
    </div>
</div>

<div id="courts-list" class="container py-5">
    <div class="row text-center mb-5">
        <div class="col-12">
            <h4 class="fw-bold mb-4 text-dark">Select Your Sport</h4>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                @php $sports = ['Badminton', 'Futsal', 'Tennis', 'Volleyball', 'Basketball', 'Netball', 'Takraw']; @endphp
                @foreach($sports as $sport)
                    <button class="btn btn-outline-dark rounded-pill px-4 fw-bold filter-btn shadow-sm" onclick="filterCourts('{{ $sport }}', this)">{{ $sport }}</button>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        @foreach($courts as $court)
        @if($court->status == 'Available')
        <div class="col-md-6 col-lg-4 court-item" data-sport="{{ $court->type }}" style="display: none;">
            <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden">
                <div style="height: 220px; overflow: hidden; background-color: #f8f9fa; position: relative;">
                    @if($court->image)
                        <img src="{{ asset('storage/' . $court->image) }}" class="w-100 h-100 object-fit-cover transition-transform" alt="{{ $court->name }}">
                    @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted"><i class="bi bi-image fs-1 opacity-25"></i></div>
                    @endif
                    <div class="position-absolute top-0 end-0 p-3">
                        <span class="badge bg-white text-dark shadow-sm px-3 py-2 rounded-pill fw-bold">RM {{ number_format($court->price, 2) }}/hr</span>
                    </div>
                </div>
                <div class="card-body text-center p-4">
                     <div class="mb-3"><span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill text-uppercase" style="letter-spacing: 1px; font-size: 0.7rem;">{{ $court->type }}</span></div>
                    <h4 class="card-title fw-bold mb-1 text-dark">{{ $court->name }}</h4>
                    <p class="text-muted small mb-4">Standard {{ $court->type }} Facility</p>
                    <div class="d-grid">
                        @auth
                            <a href="{{ route('bookings.create', $court->id) }}" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm py-3">Book This Court</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm py-3">Login to Book</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach

        <div id="no-courts-msg" class="col-12 text-center mt-5" style="display: none;">
            <div class="d-flex flex-column align-items-center justify-content-center p-5 bg-light rounded-4">
                <i class="bi bi-emoji-frown fs-1 text-muted mb-3 opacity-50"></i>
                <h5 class="fw-bold text-muted">No courts available right now.</h5>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const firstBtn = document.querySelector('.filter-btn');
        if(firstBtn) filterCourts(firstBtn.innerText, firstBtn); 
    });

    function filterCourts(sportType, btn) {
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('btn-dark', 'text-white');
            b.classList.add('btn-outline-dark');
        });
        btn.classList.remove('btn-outline-dark');
        btn.classList.add('btn-dark', 'text-white');

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
        document.getElementById('no-courts-msg').style.display = visibleCount === 0 ? 'block' : 'none';
    }
</script>
<style>
    .transition-transform { transition: transform 0.3s ease; }
    .court-item:hover .transition-transform { transform: scale(1.05); }
</style>
@endsection