<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | IIUM CBS</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    
    <style>
        body { 
            background-color: #f3f4f6; 
            font-family: 'Inter', sans-serif;
        }

        h1, h2, h3, h4, h5, .brand, .fw-bold {
            font-family: 'Poppins', sans-serif;
        }

        /* --- 1. FIXED SIDEBAR --- */
        .sidebar {
            position: fixed;       /* STICKS TO SCREEN */
            top: 0;
            bottom: 0;
            left: 0;
            width: 260px;          /* FIXED WIDTH */
            background: linear-gradient(180deg, #00665c 0%, #004d40 100%);
            color: white;
            padding: 20px;
            display: flex; 
            flex-direction: column;
            box-shadow: 4px 0 10px rgba(0,0,0,0.05);
            z-index: 1000;         /* STAY ON TOP */
            overflow-y: auto;      /* SCROLL INSIDE IF NEEDED */
        }

        .sidebar .brand {
            text-align: center; font-weight: 700; font-size: 1.5rem;
            margin-bottom: 40px; color: #fff;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }

        .sidebar a {
            padding: 12px 15px; text-decoration: none; font-size: 0.95rem; 
            color: rgba(255,255,255,0.8); border-radius: 12px;
            margin-bottom: 5px; transition: all 0.2s ease; font-weight: 500;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: rgba(255,255,255,0.15); color: white; transform: translateX(5px);
        }

        /* --- 2. MAIN CONTENT (Pushed Right) --- */
        .content { 
            margin-left: 260px;    /* PUSH CONTENT RIGHT */
            padding: 30px; 
            width: calc(100% - 260px);
        }

        /* --- DASHBOARD STYLES --- */
        .stat-card {
            border: none; border-radius: 20px; color: white;
            overflow: hidden; position: relative; transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .bg-gradient-green { background: linear-gradient(135deg, #42d392 0%, #00665c 100%); }
        .bg-gradient-blue { background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%); }
        .bg-gradient-orange { background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%); }
        .stat-icon { position: absolute; right: 15px; bottom: 10px; font-size: 4rem; opacity: 0.2; }

        .table-card {
            border: none; border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05); overflow: hidden;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand">
            <i class="bi bi-shield-check"></i> IIUM CBS
        </div>

        <a href="{{ route('home') }}" class="mb-4 text-warning" style="background: rgba(255, 193, 7, 0.1);">
            <i class="bi bi-arrow-left"></i> Back to Website
        </a>

        <a href="{{ route('admin.dashboard') }}" class="active">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
        <a href="{{ route('admin.courts.create') }}">
            <i class="bi bi-plus-circle-fill"></i> Add Facility
        </a>
        <a href="{{ route('admin.bookings.index') }}" class="{{ Request::routeIs('admin.bookings.index') ? 'active' : '' }}">
            <i class="bi bi-calendar-check-fill"></i> Manage Bookings
        </a>
        <a href="{{ route('admin.users.index') }}" class="{{ Request::routeIs('admin.users.index') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Users List
        </a>
        
        <div class="mt-auto mb-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger w-100 text-start ps-3 shadow-sm" style="border-radius: 12px;">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark">Welcome back, Admin! 👋</h2>
                <p class="text-muted">Here is what's happening with the courts today.</p>
            </div>
            <div class="bg-white px-4 py-2 rounded-pill shadow-sm d-flex align-items-center">
                <i class="bi bi-clock-history text-success me-2"></i> 
                <span class="fw-bold text-secondary">{{ now()->format('d M Y') }}</span>
            </div>
        </div>
        
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card stat-card bg-gradient-green p-4">
                    <h5 class="opacity-75">Total Facilities</h5>
                    <h2 class="fw-bold mt-2">{{ \App\Models\Court::count() }} Courts</h2>
                    <i class="bi bi-buildings-fill stat-icon"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card bg-gradient-orange p-4">
                    <h5 class="opacity-75">Pending Requests</h5>
                    <h2 class="fw-bold mt-2">{{ \App\Models\Booking::where('status', 'Pending')->count() }} Pending</h2>
                    <i class="bi bi-hourglass-split stat-icon"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card bg-gradient-blue p-4">
                    <h5 class="opacity-75">Active Users</h5>
                    <h2 class="fw-bold mt-2">{{ \App\Models\User::where('role', 'user')->count() }} Users</h2>
                    <i class="bi bi-people-fill stat-icon"></i>
                </div>
            </div>
        </div>

        <div class="card table-card mb-5">
            <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Recent Activity 📋</h5>
                <button class="btn btn-sm btn-outline-secondary rounded-pill px-3">View All</button>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-secondary text-uppercase small fw-bold">Time</th>
                            <th class="py-3 text-secondary text-uppercase small fw-bold">Booking Details</th>
                            <th class="py-3 text-secondary text-uppercase small fw-bold">Users</th>
                            <th class="py-3 text-secondary text-uppercase small fw-bold">Status / Action</th>
                            <th class="py-3 text-secondary text-uppercase small fw-bold">Receipt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($recent_bookings))
                            @forelse($recent_bookings as $booking)
                            <tr>
                                <td class="ps-4 text-muted small">
                                    {{ \Carbon\Carbon::parse($booking->created_at)->diffForHumans() }}
                                </td>
                                <td>
    <span class="fw-bold text-dark">
        {{ $booking->court->name ?? 'Unknown' }}
    </span>

    <div class="small text-muted mt-1">
        {{ $booking->court_number }}
    </div>

    <small class="text-muted d-block mt-1">
        {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}
        ({{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }})
    </small>
</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light text-dark fw-bold rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 12px;">
                                            {{ substr($booking->user->name ?? 'U', 0, 1) }}
                                        </div>
                                        <span>{{ $booking->user->name ?? 'Unknown' }}</span>
                                    </div>
                                </td>
                                
                                <td>
                                    @if($booking->status == 'Pending')
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('admin.bookings.approve', $booking->group_id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm rounded-circle shadow-sm" title="Approve">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.bookings.reject', $booking->group_id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm rounded-circle shadow-sm" title="Reject">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($booking->status == 'Approved')
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Approved</span>
                                    @elseif($booking->status == 'Rejected')
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Rejected</span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ $booking->status }}</span>
                                    @endif
                                </td>

                                <td>
                                    @if($booking->payment_proof)
                                        <a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                                            View
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                    No recent bookings found.
                                </td>
                            </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>