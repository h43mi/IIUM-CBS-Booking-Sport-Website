@extends('master.layout')

@section('title', 'About Us | IIUM CBS')

@section('content')

<div class="row mb-5 align-items-center">
    <div class="col-lg-6">
        <span class="badge bg-warning text-dark mb-2">Our Mission</span>
        <h1 class="display-4 fw-bold mb-4">Promoting a Healthy & Active Lifestyle in IIUM.</h1>
        <p class="lead text-muted mb-4">
            The IIUM Sports Centre is dedicated to providing top-notch facilities for students, staff, and the community. 
            Our booking system makes it easier than ever to reserve your spot and get in the game.
        </p>
    </div>
    <div class="col-lg-6">
        <div class="rounded-4 overflow-hidden shadow-sm">
            <img src="{{ asset('assets/img/badminton.jpeg') }}" class="w-100 object-fit-cover" style="height: 350px;" alt="IIUM Sports">
        </div>
    </div>
</div>

<div class="row text-center g-4 mb-5">
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
            <div class="text-success mb-3">
                <i class="bi bi-calendar-check-fill fs-1"></i>
            </div>
            <h5 class="fw-bold">Easy Booking</h5>
            <p class="text-muted small">Book your favorite courts anytime, anywhere with our seamless online platform.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
            <div class="text-success mb-3">
                <i class="bi bi-trophy-fill fs-1"></i>
            </div>
            <h5 class="fw-bold">World-Class Facilities</h5>
            <p class="text-muted small">From indoor badminton courts to outdoor futsal arenas, we maintain high standards.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
            <div class="text-success mb-3">
                <i class="bi bi-people-fill fs-1"></i>
            </div>
            <h5 class="fw-bold">For Everyone</h5>
            <p class="text-muted small">Open to all IIUM students, staff, and the public. Join our vibrant community today.</p>
        </div>
    </div>
</div>

<div class="bg-dark text-white rounded-4 p-5 text-center mb-5">
    <h3 class="fw-bold mb-3">Visit Us</h3>
    <p class="text-white-50">
        IIUM Sports Complex, International Islamic University Malaysia,<br>
        Jalan Gombak, 53100 Kuala Lumpur.
    </p>
    <a href="{{ route('home') }}" class="btn btn-warning rounded-pill px-4 fw-bold mt-2">Book a Court Now</a>
</div>

@endsection