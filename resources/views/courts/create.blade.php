@extends('master.layout')

@section('title', 'Add New Court')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow border-0">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Add New Sports Facility</h4>
            </div>
            <div class="card-body p-4">
                
                <form action="{{ route('courts.store') }}" method="POST">
                    @csrf <div class="mb-3">
                        <label class="form-label fw-bold">Court Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Futsal Court A" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Facility Type</label>
                            <select name="type" class="form-select">
                                <option value="Indoor">Indoor Court</option>
                                <option value="Outdoor">Outdoor Court</option>
                                <option value="Gym">Gymnasium</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Price per Hour (RM)</label>
                            <input type="number" name="price" class="form-control" step="0.01" placeholder="0.00" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-success btn-lg">Save New Court</button>
                        <a href="{{ route('courts.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection