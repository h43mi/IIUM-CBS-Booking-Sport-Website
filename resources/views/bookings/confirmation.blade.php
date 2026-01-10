@extends('master.layout')

@section('title', 'Booking Confirmation')

@section('content')
<div class="row justify-content-center text-center mb-4">
    <div class="col-12">
        <h2 class="fw-bold mb-3">Booking Confirmation <i class="bi bi-check-circle-fill text-success"></i></h2>
        <p class="text-muted">Please review your booking details before proceeding.</p>
    </div>
</div>

<div class="row justify-content-center align-items-center">
    
    <div class="col-md-4 text-start mb-4 mb-md-0">
        <h4 class="fw-bold mb-4">Booking Details</h4>
        
        <div class="mb-3">
            <small class="text-muted text-uppercase fw-bold">Date</small>
            <h5 class="fw-bold">{{ \Carbon\Carbon::parse($firstBooking->date)->format('d/m/Y') }}</h5>
        </div>

        <div class="mb-3">
            <small class="text-muted text-uppercase fw-bold">Time</small>
            <h5 class="fw-bold">
                {{ \Carbon\Carbon::parse($bookings->min('start_time'))->format('h:i A') }} 
                - 
                {{ \Carbon\Carbon::parse($bookings->max('end_time'))->format('h:i A') }}
            </h5>
        </div>

        <div class="mb-3">
            <small class="text-muted text-uppercase fw-bold">Court</small>
            <h5 class="fw-bold">{{ $firstBooking->court_number }} ({{ $firstBooking->court->type }})</h5>
        </div>

        <div class="mt-4">
            <a href="{{ route('bookings.create', $firstBooking->court_id) }}" class="btn btn-outline-danger rounded-pill px-4">
                <i class="bi bi-pencil me-2"></i> Edit
            </a>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card shadow border-0 rounded-4 overflow-hidden">
            <div class="p-3">
                <div class="rounded-3 overflow-hidden position-relative" style="height: 180px;">
                    <img src="{{ asset('assets/img/court1.webp') }}" class="w-100 h-100 object-fit-cover">
                    <div class="position-absolute bottom-0 start-0 p-3 text-white w-100" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                        <h5 class="fw-bold mb-0">{{ $firstBooking->court->name }}</h5>
                        <small class="opacity-75">{{ $firstBooking->court->type }}</small>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                
                <div class="row g-2 mb-4 mt-2">
                    <div class="col-6">
                        <div class="bg-light p-2 rounded-3 d-flex align-items-center">
                            <i class="bi bi-calendar-event text-secondary me-2 fs-5"></i>
                            <div>
                                <small class="text-muted d-block" style="font-size: 10px;">Date</small>
                                <span class="fw-bold small">{{ \Carbon\Carbon::parse($firstBooking->date)->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light p-2 rounded-3 d-flex align-items-center">
                            <i class="bi bi-clock text-secondary me-2 fs-5"></i>
                            <div>
                                <small class="text-muted d-block" style="font-size: 10px;">Time</small>
                                <span class="fw-bold small">{{ \Carbon\Carbon::parse($bookings->min('start_time'))->format('h:i A') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light p-2 rounded-3 d-flex align-items-center">
                            <i class="bi bi-geo-alt text-secondary me-2 fs-5"></i>
                            <div>
                                <small class="text-muted d-block" style="font-size: 10px;">Court</small>
                                <span class="fw-bold small">{{ $firstBooking->court_number }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light p-2 rounded-3 d-flex align-items-center">
                            <i class="bi bi-hourglass-split text-secondary me-2 fs-5"></i>
                            <div>
                                <small class="text-muted d-block" style="font-size: 10px;">Duration</small>
                                <span class="fw-bold small">{{ $totalHours }} {{ Str::plural('Hour', $totalHours) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border-secondary border-opacity-25" style="border-style: dashed;">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="text-muted">Total Price</span>
                    <h3 class="text-success fw-bold mb-0">RM {{ number_format($totalPrice, 2) }}</h3>
                </div>

                <a href="{{ route('bookings.payment', $group_id) }}" class="btn btn-success w-100 py-3 rounded-pill fw-bold shadow">
                    Proceed to Payment <i class="bi bi-credit-card-2-front-fill ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection