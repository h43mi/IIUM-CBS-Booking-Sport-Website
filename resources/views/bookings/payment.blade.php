@extends('master.layout')

@section('title', 'Payment')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        
        <div class="text-center mb-5">
            <h3 class="fw-bold">Scan & Pay 📲</h3>
            <p class="text-muted">Please scan the QR code and upload your receipt.</p>
        </div>

        <div class="row g-5">
            
            <div class="col-md-5 text-center border-end">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h5 class="fw-bold mb-3 text-success">Total: RM {{ number_format($totalPrice, 2) }}</h5>
                    
                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 250px; height: 250px; border: 2px dashed #ccc;">
                        <span class="text-muted">QR CODE HERE</span>
                    </div>

                    <p class="small text-muted mb-0">
                        1. Open your Banking App / TNG.<br>
                        2. Scan this QR Code.<br>
                        3. Pay <b>RM {{ number_format($totalPrice, 2) }}</b>.<br>
                        4. Screenshot the receipt.
                    </p>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-4">Payment Details 📝</h5>

                    <form action="{{ route('bookings.submit_payment', $group_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Full Name</label>
                            <input type="text" name="pay_name" class="form-control form-control-lg" required placeholder="Enter your name" value="{{ Auth::user()->name }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">Matric Number</label>
                                <input type="text" name="pay_matric" class="form-control form-control-lg" required placeholder="1234567">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">Contact Number</label>
                                <input type="text" name="pay_contact" class="form-control form-control-lg" required placeholder="012-3456789">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Upload Receipt (Proof of Payment)</label>
                            <input type="file" name="payment_proof" class="form-control form-control-lg" required accept="image/*,application/pdf">
                            <div class="form-text">Supported files: JPG, PNG, PDF. Max 2MB.</div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-3 rounded-pill fw-bold fs-5 shadow-sm">
                            Submit Payment <i class="bi bi-send-fill ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection