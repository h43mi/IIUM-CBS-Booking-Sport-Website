<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings | IIUM CBS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    
    <style>
        /* (Keep Styles same as before) */
        body { background-color: #f3f4f6; font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, .brand, .fw-bold { font-family: 'Poppins', sans-serif; }
        .sidebar {
            position: fixed; top: 0; bottom: 0; left: 0; width: 260px;
            background: linear-gradient(180deg, #00665c 0%, #004d40 100%);
            color: white; padding: 20px; display: flex; flex-direction: column;
            z-index: 1000; overflow-y: auto;
        }
        .sidebar .brand { text-align: center; font-weight: 700; font-size: 1.5rem; margin-bottom: 40px; color: #fff; gap: 10px; display: flex; justify-content: center; align-items: center; }
        .sidebar a { padding: 12px 15px; text-decoration: none; font-size: 0.95rem; color: rgba(255,255,255,0.8); border-radius: 12px; margin-bottom: 5px; transition: all 0.2s ease; font-weight: 500; }
        .sidebar a:hover, .sidebar a.active { background-color: rgba(255,255,255,0.15); color: white; transform: translateX(5px); }
        .content { margin-left: 260px; padding: 30px; width: calc(100% - 260px); }
        .table-card { border: none; border-radius: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); overflow: hidden; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand"><i class="bi bi-shield-check"></i> IIUM CBS</div>
        <a href="{{ route('home') }}" class="mb-4 text-warning" style="background: rgba(255, 193, 7, 0.1);"><i class="bi bi-arrow-left"></i> Back to Website</a>
        <a href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-fill"></i> Dashboard</a>
        <a href="{{ route('admin.courts.create') }}"><i class="bi bi-plus-circle-fill"></i> Add Facility</a>
        <a href="{{ route('admin.bookings.index') }}" class="active"><i class="bi bi-calendar-check-fill"></i> Manage Bookings</a>
        <a href="{{ route('admin.users.index') }}" class="{{ Request::routeIs('admin.users.index') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> User List
        </a>
        <div class="mt-auto mb-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger w-100 text-start ps-3 shadow-sm" style="border-radius: 12px;"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
            </form>
        </div>
    </div>

    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark">Manage Bookings 📅</h2>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-3 mb-4"> 
            <form action="{{ route('admin.bookings.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control bg-light border-0" placeholder="Search User Name or ID..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select bg-light border-0">
                        <option value="All">All Statuses</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-dark rounded-3">Filter</button>
                </div>
            </form>
        </div>

        <div class="card table-card">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Booking ID</th>
                            <th>User</th>
                            <th>Facility</th>
                            <th>Date & Time</th>
                            <th>Hours</th> 
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">{{ $booking->group_id }}</td>
                            <td>
                                <div class="fw-bold">{{ $booking->user->name ?? 'Unknown' }}</div>
                                <small class="text-muted">{{ $booking->user->email ?? '' }}</small>
                            </td>
                            <td>
    <span class="badge bg-primary bg-opacity-10 text-primary">
        {{ $booking->court->type }}
    </span>

    <div class="fw-semibold mt-1">
        {{ $booking->court->name }}
    </div>

    <small class="text-muted">
        {{ $booking->court_number }}
    </small>
</td>
                            <td>
                                <div>{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ \App\Models\Booking::where('group_id', $booking->group_id)->count() }} hrs
                                </span>
                            </td>
                            <td>
                                @if($booking->status == 'Pending')
                                    <span class="badge bg-secondary">Pending</span>
                                @elseif($booking->status == 'Approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($booking->status == 'Rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-light text-dark border">{{ $booking->status }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2 align-items-center">
                                    <a href="{{ route('admin.bookings.edit', $booking->group_id) }}" class="btn btn-primary btn-sm rounded-circle shadow-sm" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    @if($booking->status == 'Pending')
                                        <form action="{{ route('admin.bookings.approve', $booking->group_id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-success btn-sm rounded-circle shadow-sm" title="Approve"><i class="bi bi-check-lg"></i></button>
                                        </form>
                                        <form action="{{ route('admin.bookings.reject', $booking->group_id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-danger btn-sm rounded-circle shadow-sm" title="Reject"><i class="bi bi-x-lg"></i></button>
                                        </form>
                                    @endif
                                    
                                    </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No bookings found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-4">{{ $bookings->links() }}</div>
        </div>
    </div>
</body>
</html>