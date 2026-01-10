@extends('master.layout')

@section('title', 'Success')

@section('content')
<div class="row justify-content-center text-center" style="margin-top: 50px;">
    <div class="col-md-6">
        
        <div class="card border-0 shadow rounded-5 p-5">
            <div class="mb-4">
                <div style="width: 80px; height: 80px; background: #d1e7dd; color: #198754; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                    <i class="bi bi-check-lg" style="font-size: 3rem;"></i>
                </div>
            </div>

            <h2 class="fw-bold text-success">Payment Successful!</h2>
            <p class="text-muted">Your booking has been confirmed. Get ready to play!</p>

            <div class="bg-light p-3 rounded-3 mt-3 mb-4">
                <small class="text-muted text-uppercase fw-bold">Booking Reference</small>
                <h4 class="fw-bold mb-0 text-dark">{{ $group_id }}</h4>
            </div>

            <div class="d-grid gap-2">
                <a href="{{ route('bookings.dashboard') }}" class="btn btn-dark rounded-pill py-3 fw-bold">
                    Go to My Dashboard
                </a>
                <a href="{{ route('home') }}" class="btn btn-link text-decoration-none text-muted">
                    Back to Home
                </a>
            </div>
        </div>

    </div>
</div>
@endsection