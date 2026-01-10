@extends('master.layout')

@section('title', 'Book Court')

<style>
    /* --- COMMON BUTTON STYLES --- */
    .selection-btn {
        border: 1px solid #ddd;
        border-radius: 8px;
        background: white;
        padding: 12px 5px;
        text-align: center;
        cursor: pointer;
        transition: 0.2s;
        font-weight: 500;
        color: #555;
        width: 100%;
        display: block;
        position: relative;
    }

    .selection-btn:hover {
        border-color: #0d6efd; /* Blue border on hover */
        background-color: #f8f9fa;
    }

    /* Active State (Blue Pill) */
    .selection-btn.active {
        background-color: #0d6efd; /* Blue */
        color: white;
        border-color: #0d6efd;
        box-shadow: 0 4px 6px rgba(13, 110, 253, 0.3);
    }

    /* DISABLED / BOOKED STATE */
    .selection-btn.disabled {
        background-color: #e9ecef;
        color: #adb5bd;
        border-color: #dee2e6;
        cursor: not-allowed;
        pointer-events: none;
        opacity: 0.6;
    }
    
    /* DATE INPUT STYLING */
    .big-date-input {
        padding: 15px;
        font-size: 1.2rem;
        border-radius: 12px;
        border: 1px solid #ccc;
        background-color: white;
        cursor: pointer;
        width: 100%;
        text-align: center;
        font-weight: bold;
        color: #333;
        transition: all 0.2s;
    }
    
    .big-date-input:hover {
        background-color: #f8f9fa;
        border-color: #0d6efd;
    }

    .big-date-input:focus {
        border-color: #0d6efd;
        outline: none;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
    }

    .hidden-input { display: none; }
    
    .loader {
        border: 3px solid #f3f3f3;
        border-radius: 50%;
        border-top: 3px solid #0d6efd;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
        display: inline-block;
        margin-left: 10px;
    }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>

@section('content')

@php
    // 1. DETERMINE THE CORRECT IMAGE URL
    // Default fallback
    $bgImage = asset('assets/img/court1.webp'); 
    
    if ($court->image) {
        // Check if it's an uploaded image (Storage) or seeded image (Assets)
        if (\Illuminate\Support\Str::startsWith($court->image, 'courts/')) {
            $bgImage = asset('storage/' . $court->image);
        } else {
            $bgImage = asset('assets/img/' . $court->image);
        }
    }
@endphp

<div class="row justify-content-center">
    <div class="col-md-9">
        
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
            {{-- 2. APPLY THE DYNAMIC IMAGE URL HERE --}}
            <div style="height: 200px; background-image: url('{{ $bgImage }}'); background-size: cover; background-position: center;">
                <div class="d-flex align-items-end h-100 p-4" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                    <div>
                        <span class="badge bg-primary text-white mb-2">Indoor Facility</span>
                        <h1 class="text-white fw-bold mb-0">{{ $court->name }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow border-0 rounded-4 p-4">
            
            <form action="{{ route('bookings.store') }}" method="POST" id="booking-form">
                @csrf
                <input type="hidden" name="court_id" id="court_id_field" value="{{ $court->id }}">
                
                <div class="mb-5 text-center">
                    <h5 class="fw-bold mb-3">Step 1: Choose Date 📅</h5>
                    <div class="col-md-6 mx-auto">
                        <input type="date" 
                               id="date-picker" 
                               name="date" 
                               class="big-date-input" 
                               required 
                               min="{{ date('Y-m-d') }}" 
                               onclick="this.showPicker()"
                               onchange="handleDateChange()"> 
                    </div>
                </div>

                <div id="step-2" style="display: none;" class="mb-5 text-center">
                    <h5 class="fw-bold mb-3">Step 2: Choose Court 🏟️</h5>
                    <p class="text-muted small">Pick your preferred court number</p>

                    <div class="row g-3 justify-content-center">
                        @php
                            $courts_list = ['Court A', 'Court B', 'Court C', 'Court D', 'Court E'];
                        @endphp
                        @foreach($courts_list as $c_name)
                        <div class="col-4 col-md-2">
                            <label class="w-100">
                                <input type="radio" name="court_number" value="{{ $c_name }}" class="hidden-input court-radio" onchange="toggleCourt(this)" required>
                                <div class="selection-btn fw-bold py-3">{{ $c_name }}</div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div id="step-3" style="display: none;" class="mb-5 text-center">
                    <h5 class="fw-bold mb-3">
                        Step 3: Select Time Slots ⏰ 
                        <span id="loading-spinner" style="display:none;"><div class="loader"></div></span>
                    </h5>
                    <p class="text-muted small">Grey slots are already booked.</p>
                    
                    <div class="row g-2 justify-content-center">
                        @php
                            $times = [
                                '08:00' => '08:00 - 09:00', '09:00' => '09:00 - 10:00',
                                '10:00' => '10:00 - 11:00', '11:00' => '11:00 - 12:00',
                                '14:00' => '02:00 PM - 03:00 PM', '15:00' => '03:00 PM - 04:00 PM',
                                '16:00' => '04:00 PM - 05:00 PM', '17:00' => '05:00 PM - 06:00 PM',
                                '20:00' => '08:00 PM - 09:00 PM', '21:00' => '09:00 PM - 10:00 PM',
                                '22:00' => '10:00 PM - 11:00 PM', 
                                '23:00' => '11:00 PM - 12:00 AM',
                            ];
                        @endphp
                        @foreach($times as $value => $label)
                        <div class="col-6 col-md-3">
                            <label class="w-100">
                                <input type="checkbox" name="slots[]" value="{{ $value }}" class="hidden-input slot-checkbox time-checkbox" data-time="{{ $value }}" onchange="toggleTime(this)">
                                <div class="selection-btn" id="btn-{{ $value }}">{{ $label }}</div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div id="summary-section" style="display: none;">
                    <div class="bg-light p-3 rounded-3 border d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted fw-bold">TOTAL PRICE</small>
                            <h3 class="fw-bold mb-0 text-success" id="total-price">RM 0.00</h3>
                        </div>
                        <div class="text-end">
                            <small class="text-muted d-block mb-1" id="summary-text">0 Hours on Unknown Court</small>
                            <button type="submit" class="btn btn-success px-4 py-2 rounded-pill fw-bold shadow-sm">
                                Confirm <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    const pricePerHour = {{ $court->price }};
    const courtId = document.getElementById('court_id_field').value;
    let selectedCourtNumber = null;
    let selectedDate = null;

    function handleDateChange() {
        const dateInput = document.getElementById('date-picker');
        selectedDate = dateInput.value;
        
        if(selectedDate) {
            document.getElementById('step-2').style.display = 'block';
            setTimeout(() => document.getElementById('step-2').scrollIntoView({ behavior: 'smooth', block: 'center' }), 100);
            
            if(selectedCourtNumber) {
                fetchAvailability();
            }
        }
    }

    function toggleCourt(radio) {
        document.querySelectorAll('.court-radio').forEach(el => {
            el.nextElementSibling.classList.remove('active');
        });
        radio.nextElementSibling.classList.add('active');
        
        selectedCourtNumber = radio.value;
        
        const step3 = document.getElementById('step-3');
        step3.style.display = 'block';
        setTimeout(() => step3.scrollIntoView({ behavior: 'smooth', block: 'center' }), 100);

        fetchAvailability();
        updateSummary();
    }

    function fetchAvailability() {
        if(!selectedDate || !selectedCourtNumber) return;

        const spinner = document.getElementById('loading-spinner');
        spinner.style.display = 'inline-block';

        document.querySelectorAll('.time-checkbox').forEach(cb => cb.disabled = true);
        resetTimeSelections();

        const url = `{{ route('bookings.check') }}?date=${selectedDate}&court_id=${courtId}&court_number=${selectedCourtNumber}`;

        fetch(url)
            .then(response => response.json())
            .then(bookedSlots => {
                document.querySelectorAll('.time-checkbox').forEach(cb => {
                    const timeVal = cb.value;
                    const btn = document.getElementById('btn-' + timeVal);
                    
                    cb.disabled = false;
                    btn.classList.remove('disabled');
                    cb.checked = false;
                    btn.classList.remove('active');

                    if(bookedSlots.includes(timeVal)) {
                        cb.disabled = true;
                        btn.classList.add('disabled');
                    }
                });
                spinner.style.display = 'none';
                updateSummary();
            })
            .catch(error => {
                console.error('Error fetching availability:', error);
                spinner.style.display = 'none';
            });
    }

    function resetTimeSelections() {
        document.querySelectorAll('.time-checkbox').forEach(cb => {
            cb.checked = false;
            document.getElementById('btn-' + cb.value).classList.remove('active');
        });
        document.getElementById('summary-section').style.display = 'none';
    }

    function toggleTime(checkbox) {
        const btn = document.getElementById('btn-' + checkbox.value);
        if(checkbox.checked) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
        updateSummary();
    }

    function updateSummary() {
        const checkboxes = document.querySelectorAll('.slot-checkbox:checked');
        const count = checkboxes.length;
        const total = (count * pricePerHour).toFixed(2);
        
        document.getElementById('total-price').innerText = 'RM ' + total;
        
        let text = count + (count === 1 ? ' Hour' : ' Hours');
        if(selectedCourtNumber) {
            text += ' on ' + selectedCourtNumber;
        }
        document.getElementById('summary-text').innerText = text;

        if(count === 0) {
            document.getElementById('summary-section').style.display = 'none';
        } else {
            document.getElementById('summary-section').style.display = 'block';
        }
    }
</script>
@endsection
