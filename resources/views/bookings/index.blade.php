
@extends('master.layout')

@section('title', 'My Dashboard')

@section('content')

<style>
    /* Info Box Styling for the Cards */
    .detail-box {
        background-color: #f8f9fa;
        border-radius: 12px;
        padding: 12px;
        height: 100%;
        border: 1px solid #e9ecef;
        transition: all 0.2s ease;
    }
    .detail-box:hover {
        background-color: #fff;
        border-color: #198754;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .detail-label {
        font-size: 0.7rem;
        color: #6c757d;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
        display: block;
    }
    .detail-value {
        font-weight: 700;
        color: #212529;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .card-left-border {
        border-left: 5px solid #198754;
    }
    
    /* Hover effect for the Unpaid Link Badge */
    .badge-link:hover {
        opacity: 0.8;
        transform: translateY(-1px);
        transition: all 0.2s;
        cursor: pointer;
    }
</style>

<div class="row mb-5 align-items-end">
    <div class="col-md-8">
        {{-- UPDATED: Added Font Awesome Icon here --}}
        <h2 class="fw-bold text-dark">My Dashboard <i class="fa-solid fa-user ms-2" style="color: #198754;"></i></h2>
        <p class="text-muted mb-0">Manage your upcoming games and view booking history.</p>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="{{ route('home') }}" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold">
            <i class="bi bi-plus-lg me-2"></i> Book a Court
        </a>
    </div>
</div>

<h4 class="fw-bold text-dark mb-4">Upcoming</h4>

<div class="row g-4 mb-5"> 
    @php
        // Filter: Approved + Future/Today
        $upcoming = $bookings->filter(function($booking) {
            return $booking->status == 'Approved' && \Carbon\Carbon::parse($booking->date)->gte(now()->startOfDay());
        });
    @endphp

    @forelse($upcoming as $booking)
        <div class="col-md-6 col-lg-4"> 
            <div class="card border-0 shadow-sm rounded-4 h-100 card-left-border overflow-hidden">
                <div class="card-body p-4">
                    
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 mb-2 px-2 py-1">
                                {{ $booking->court->type }}
                            </span>
                            <h5 class="fw-bold text-dark mb-0">{{ $booking->court->name }}</h5>
                            <span class="badge bg-light text-dark border mt-1">
    {{ $booking->court_number }}
</span>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">Confirmed</span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <div class="detail-box">
                                <span class="detail-label">Date</span>
                                <div class="detail-value">
                                    <i class="bi bi-calendar-event text-success"></i>
                                    {{ \Carbon\Carbon::parse($booking->date)->format('d M') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="detail-box">
                                <span class="detail-label">Time</span>
                                <div class="detail-value">
                                    <i class="bi bi-clock text-success"></i>
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="detail-box">
                                <span class="detail-label">Duration</span>
                                <div class="detail-value">
                                    <i class="bi bi-hourglass-split text-success"></i>
                                    1 Hour
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="detail-box">
                                <span class="detail-label">Booking ID</span>
                                <div class="detail-value text-secondary">
                                    <i class="bi bi-hash"></i>
                                    {{ $booking->group_id }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    @empty
        <div class="col-12">
            <div class="alert alert-light border-0 shadow-sm rounded-4 text-center py-5">
                <i class="bi bi-calendar-check fs-1 text-muted opacity-25 mb-3"></i>
                <h6 class="fw-bold text-secondary">No upcoming games</h6>
                <p class="small text-muted mb-3">Your approved bookings will appear here.</p>
                <a href="{{ route('home') }}" class="btn btn-outline-success rounded-pill px-4">Book Now</a>
            </div>
        </div>
    @endforelse
</div>


<h5 class="fw-bold text-dark mb-3">Booking History <i class="fa-solid fa-clock-rotate-left ms-2" style="color: #198754;"></i></h5>
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary text-uppercase small fw-bold">Booking ID</th>
                        <th class="py-3 text-secondary text-uppercase small fw-bold">Facility</th>
                        <th class="py-3 text-secondary text-uppercase small fw-bold">Date & Time</th>
                        <th class="py-3 text-secondary text-uppercase small fw-bold text-end pe-4">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td class="ps-4 fw-bold text-secondary">
                            #{{ $booking->group_id }}
                        </td>

                        <td>
    <span class="d-block fw-bold text-dark">
        {{ $booking->court->name }}
    </span>

    <span class="d-block small text-muted">
        {{ $booking->court_number }}
    </span>

    <small class="text-muted">
        {{ $booking->court->type }}
    </small>
</td>
                        <td>
                            {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}
                            <small class="text-muted ms-2">({{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }})</small>
                        </td>
                        
                        <td class="text-end pe-4">
                            @if($booking->status == 'Approved')
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Approved</span>
                            
                            @elseif($booking->status == 'Pending')
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">Pending</span>
                            
                            @elseif($booking->status == 'Unpaid')
                                <a href="{{ route('bookings.payment', $booking->group_id) }}" class="text-decoration-none" title="Click to Pay">
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill border border-warning badge-link">
                                        Pay Now <i class="bi bi-arrow-right-short"></i>
                                    </span>
                                </a>
                            
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Rejected</span>
                            @endif
                        </td>

                        </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">No booking history found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
