<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking | IIUM CBS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    
    <style>
        body { background-color: #f3f4f6; font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, .fw-bold { font-family: 'Poppins', sans-serif; }
        .sidebar {
            position: fixed; top: 0; bottom: 0; left: 0; width: 260px;
            background: linear-gradient(180deg, #00665c 0%, #004d40 100%);
            color: white; padding: 20px; display: flex; flex-direction: column;
        }
        .content { margin-left: 260px; padding: 40px; }
        .form-card { background: white; border-radius: 20px; padding: 40px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="text-center fw-bold fs-4 mb-5 text-white mt-2"><i class="bi bi-shield-check"></i> IIUM CBS</div>
        <a href="{{ route('admin.bookings.index') }}" class="text-white text-decoration-none mb-3 opacity-75"><i class="bi bi-arrow-left"></i> Back to List</a>
    </div>

    <div class="content">
        <div class="form-card">
            <h3 class="fw-bold mb-4">Edit Booking <span class="text-secondary">#{{ $booking->group_id }}</span></h3>

            <form action="{{ route('admin.bookings.update', $booking->group_id) }}" method="POST">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-uppercase text-muted">User Name</label>
                        <input type="text" class="form-control bg-light" value="{{ $booking->user->name ?? 'Unknown' }}" readonly>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-uppercase text-muted">Court / Facility</label>
                        <select name="court_id" class="form-select">
                            @foreach($courts as $court)
                                <option value="{{ $court->id }}" {{ $booking->court_id == $court->id ? 'selected' : '' }}>
                                    {{ $court->name }} ({{ $court->type }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Date</label>
                        <input type="date" name="date" class="form-control" value="{{ $booking->date }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Start Time</label>
                        <input type="time" name="start_time" class="form-control" value="{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}" required>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Duration (Hours)</label>
                        <input type="number" name="duration" class="form-control" value="{{ $totalHours }}" min="1" max="10" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="Pending" {{ $booking->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Approved" {{ $booking->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Rejected" {{ $booking->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
                    <button type="submit" class="btn btn-success rounded-pill px-5 fw-bold">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>