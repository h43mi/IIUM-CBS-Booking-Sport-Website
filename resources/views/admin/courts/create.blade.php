<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Facilities | IIUM CBS</title>
    
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
        
        .content { margin-left: 260px; padding: 40px; width: calc(100% - 260px); }
    </style>
</head>
<body>

    {{-- SIDEBAR --}}
    <div class="sidebar">
        <div class="brand"><i class="bi bi-shield-check"></i> IIUM CBS</div>
        <a href="{{ route('home') }}" class="mb-4 text-warning" style="background: rgba(255, 193, 7, 0.1);"><i class="bi bi-arrow-left"></i> Back to Website</a>
        <a href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-fill"></i> Dashboard</a>
        <a href="{{ route('admin.courts.create') }}" class="active"><i class="bi bi-plus-circle-fill"></i> Add Facility</a>
        <a href="{{ route('admin.bookings.index') }}"><i class="bi bi-calendar-check-fill"></i> Manage Bookings</a>
        <a href="{{ route('admin.users.index') }}"><i class="bi bi-people-fill"></i> User List</a>
        
        <div class="mt-auto mb-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger w-100 text-start ps-3 shadow-sm" style="border-radius: 12px;"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
            </form>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="content">
        
        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4" role="alert">
                <ul class="mb-0 ps-3">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <h2 class="fw-bold text-dark mb-4">Manage Facilities 🏟️</h2>

        {{-- SECTION 1: ADD NEW COURT (TOP) --}}
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-5">
            <h5 class="fw-bold mb-3 text-success">Add New Court</h5>
            <form action="{{ route('admin.courts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted">Court Name</label>
                        <input type="text" name="name" class="form-control bg-light border-0" placeholder="e.g. Court A" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted">Sport Type</label>
                        <select name="type" class="form-select bg-light border-0" required>
                            <option value="" disabled selected>Choose...</option>
                            <option value="Badminton">Badminton</option>
                            <option value="Futsal">Futsal</option>
                            <option value="Tennis">Tennis</option>
                            <option value="Volleyball">Volleyball</option>
                            <option value="Basketball">Basketball</option>
                            <option value="Netball">Netball</option>
                            <option value="Takraw">Takraw</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted">Price (RM/Hour)</label>
                        <input type="number" name="price" class="form-control bg-light border-0" step="0.01" placeholder="0.00" required>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label small fw-bold text-muted">Image</label>
                        <input type="file" name="image" class="form-control bg-light border-0" accept="image/*" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success px-5 rounded-pill fw-bold py-2 shadow-sm">
                        <i class="bi bi-plus-lg me-1"></i> Save Court
                    </button>
                </div>
            </form>
        </div>

        {{-- SECTION 2: EXISTING COURTS LIST (BOTTOM) --}}
        <h4 class="fw-bold text-dark mb-3">Existing Facilities List</h4>
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 text-uppercase small fw-bold text-muted">Image</th>
                                <th class="text-uppercase small fw-bold text-muted">Name</th>
                                <th class="text-uppercase small fw-bold text-muted">Type</th>
                                <th class="text-uppercase small fw-bold text-muted">Price</th>
                                <th class="text-uppercase small fw-bold text-muted">Status</th>
                                <th class="text-end pe-4 text-uppercase small fw-bold text-muted">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courts as $court)
                            <tr>
                                <td class="ps-4" style="width: 100px;">
                                    <div class="rounded-3 overflow-hidden border bg-white" style="width: 80px; height: 50px;">
                                        @if($court->image)
                                            {{-- LOGIC: Check if image is from Seed (Assets) or Upload (Storage) --}}
                                            @if(\Illuminate\Support\Str::startsWith($court->image, 'courts/'))
                                                <img src="{{ asset('storage/' . $court->image) }}" class="w-100 h-100 object-fit-cover">
                                            @else
                                                <img src="{{ asset('assets/img/' . $court->image) }}" class="w-100 h-100 object-fit-cover">
                                            @endif
                                        @else
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted bg-light">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td><span class="fw-bold text-dark">{{ $court->name }}</span></td>
                                <td><span class="badge bg-light text-dark border">{{ $court->type }}</span></td>
                                <td class="fw-bold text-success">RM {{ number_format($court->price, 2) }}</td>
                                <td>
                                    @if($court->status == 'Available')
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Available</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Unavailable</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.courts.edit', $court->id) }}" class="btn btn-sm btn-outline-primary rounded-circle border-0 shadow-sm">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="{{ route('admin.courts.destroy', $court->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this court?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded-circle border-0 shadow-sm">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center py-5 text-muted">No courts found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</body>
</html>