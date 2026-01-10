<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Facility | IIUM CBS</title>
    
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
    </style>
</head>
<body>

    {{-- SIDEBAR --}}
    <div class="sidebar">
        <div class="brand"><i class="bi bi-shield-check"></i> IIUM CBS</div>
        <a href="{{ route('admin.courts.create') }}" class="mb-4 text-white opacity-75"><i class="bi bi-arrow-left"></i> Back to List</a>
    </div>

    {{-- CONTENT --}}
    <div class="content">
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="fw-bold text-dark mb-4">Edit Facility ✏️</h2>
                
                {{-- Error Messages --}}
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-4" role="alert">
                        <ul class="mb-0 ps-3">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <form action="{{ route('admin.courts.update', $court->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        
                        <div class="text-center mb-4">
                            <label class="form-label small fw-bold text-muted d-block text-start">Current Image</label>
                            <div class="rounded-4 overflow-hidden border bg-light d-inline-block shadow-sm" style="width: 100%; height: 250px;">
                                @if($court->image)
                                    @if(Str::startsWith($court->image, 'courts/'))
                                        <img src="{{ asset('storage/' . $court->image) }}" class="w-100 h-100 object-fit-cover">
                                    @else
                                        <img src="{{ asset('assets/img/' . $court->image) }}" class="w-100 h-100 object-fit-cover">
                                    @endif
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">No Image</div>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Court Name</label>
                            <input type="text" name="name" class="form-control bg-light border-0" value="{{ $court->name }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted">Sport Type</label>
                                <select name="type" class="form-select bg-light border-0" required>
                                    @foreach(['Badminton', 'Futsal', 'Tennis', 'Volleyball', 'Basketball', 'Netball', 'Takraw'] as $sport)
                                        <option value="{{ $sport }}" {{ $court->type == $sport ? 'selected' : '' }}>{{ $sport }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted">Price (RM)</label>
                                <input type="number" name="price" class="form-control bg-light border-0" step="0.01" value="{{ $court->price }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Status</label>
                            <select name="status" class="form-select bg-light border-0" required>
                                <option value="Available" {{ $court->status == 'Available' ? 'selected' : '' }}>Available</option>
                                <option value="Unavailable" {{ $court->status == 'Unavailable' ? 'selected' : '' }}>Not Available</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">Change Image (Optional)</label>
                            <input type="file" name="image" class="form-control bg-light border-0" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow-sm">
                            Update Facility
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>