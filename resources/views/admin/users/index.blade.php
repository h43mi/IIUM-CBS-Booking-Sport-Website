<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List | IIUM CBS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    
    <style>
        body { background-color: #f3f4f6; font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, .brand, .fw-bold { font-family: 'Poppins', sans-serif; }
        
        /* STATIC SIDEBAR */
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
        <a href="{{ route('admin.bookings.index') }}"><i class="bi bi-calendar-check-fill"></i> Manage Bookings</a>
        
        <a href="{{ route('admin.users.index') }}" class="active"><i class="bi bi-people-fill"></i> User List</a>
        
        <div class="mt-auto mb-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger w-100 text-start ps-3 shadow-sm" style="border-radius: 12px;"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
            </form>
        </div>
    </div>

    <div class="content">
        <h2 class="fw-bold text-dark mb-4">User List 👥</h2>

        <div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
            <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control bg-light border-0" placeholder="Search by Name or Email..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-dark rounded-3 px-4">Search</button>
            </form>
        </div>

        <div class="card table-card">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">#</th>
                            <th>Name</th> <th>Email</th>
                            <th>Joined Date</th>
                            <th>Total Bookings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr>
                            <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light text-dark fw-bold rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <span class="fw-bold">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $user->bookings_count }} Bookings</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No users found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4">{{ $users->links() }}</div>
        </div>
    </div>

</body>
</html>