<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Court;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function create($court_id)
    {
        $court = Court::findOrFail($court_id);
        return view('bookings.create', compact('court'));
    }

    // 1. STORE TO SESSION (NOT DATABASE YET)
    // This solves the issue of "stuck" drafts. If the user leaves, this data just disappears.
    public function store(Request $request)
    {
        $request->validate([
            'court_id' => 'required',
            'date' => 'required|date',
            'slots' => 'required|array',
            'court_number' => 'required',
        ]);

        // Generate a Group ID to use as a Session Key
        $groupId = 'BK-' . strtoupper(Str::random(6));

        // Store data in a Session array instead of Database
        $bookingData = [
            'group_id' => $groupId,
            'user_id' => Auth::id(),
            'court_id' => $request->court_id,
            'court_number' => $request->court_number,
            'date' => $request->date,
            'slots' => $request->slots, // The array of times (e.g., ['08:00', '09:00'])
        ];

        // Put this into the user's session
        session()->put('booking_' . $groupId, $bookingData);

        // Redirect to Confirmation
        return redirect()->route('bookings.confirmation', $groupId);
    }

    // 2. SHOW CONFIRMATION (FROM SESSION)
    public function confirmation($group_id)
    {
        // Retrieve data from Session
        $sessionData = session()->get('booking_' . $group_id);

        // If session expired or invalid, go home
        if (!$sessionData) {
            return redirect()->route('home')->with('error', 'Booking session expired. Please try again.');
        }

        // We need to recreate the "Booking" objects temporarily so the View doesn't break
        $court = Court::findOrFail($sessionData['court_id']);
        $bookings = collect(); // Create a Collection

        foreach ($sessionData['slots'] as $slot) {
            $b = new Booking(); // Temporary Object
            $b->court_id = $sessionData['court_id'];
            $b->date = $sessionData['date'];
            $b->start_time = $slot;
            $b->end_time = date('H:i', strtotime($slot) + 3600);
            $b->court_number = $sessionData['court_number'];
            $b->setRelation('court', $court); // Attach court details
            $bookings->push($b);
        }

        $firstBooking = $bookings->first();
        $totalPrice = $bookings->count() * $firstBooking->court->price;
        $totalHours = $bookings->count();
        
        return view('bookings.confirmation', compact('bookings', 'firstBooking', 'totalPrice', 'totalHours', 'group_id'));
    }

    // 3. SHOW PAYMENT (FROM SESSION)
    public function payment($group_id)
    {
        // Retrieve data from Session
        $sessionData = session()->get('booking_' . $group_id);

        if (!$sessionData) {
            return redirect()->route('home')->with('error', 'Booking session expired.');
        }

        // Calculate Price
        $court = Court::findOrFail($sessionData['court_id']);
        $totalPrice = count($sessionData['slots']) * $court->price;
        
        // We pass $bookings as a simple array or collection if the view needs it, 
        // but typically the payment page just needs the price and group_id.
        // Let's mock the collection again just in case the view loops through them.
        $bookings = collect();
        foreach ($sessionData['slots'] as $slot) {
             $b = new Booking();
             $b->setRelation('court', $court);
             $bookings->push($b);
        }

        return view('bookings.payment', compact('bookings', 'totalPrice', 'group_id'));
    }

    // 4. SUBMIT PAYMENT & FINALLY SAVE TO DB
    public function submitPayment(Request $request, $group_id)
    {
        $request->validate([
            'pay_name' => 'required|string',
            'pay_matric' => 'required|string',
            'pay_contact' => 'required|string',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Retrieve the Booking Data from Session
        $sessionData = session()->get('booking_' . $group_id);

        if (!$sessionData) {
            return redirect()->route('home')->with('error', 'Session expired. Please book again.');
        }

        // OPTIONAL: Double-check availability here to ensure no one stole the slot while user was paying
        // ... (You can add availability logic here if strictly needed)

        // 1. Handle File Upload
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('receipts', 'public');
        } else {
            return back()->with('error', 'Please upload a receipt.');
        }

        // 2. CREATE DATABASE RECORDS
        foreach ($sessionData['slots'] as $time_slot) {
            Booking::create([
                'user_id' => $sessionData['user_id'], // From session
                'court_id' => $sessionData['court_id'],
                'group_id' => $group_id,
                'court_number' => $sessionData['court_number'],
                'date' => $sessionData['date'],
                'start_time' => $time_slot,
                'end_time' => date('H:i', strtotime($time_slot) + 3600),
                'status' => 'Pending', // Directly set to Pending (Admin Dashboard will see this)
                'payment_proof' => $path,
                // You can also save pay_name/pay_matric if you added those columns to DB
            ]);
        }

        // 3. Clear the Session
        session()->forget('booking_' . $group_id);

        // 4. Show Success
        return view('bookings.success', compact('group_id'));
    }

    // 5. CANCEL (Handle both Session and DB)
    public function cancel($group_id)
    {
        // Check if it's just a session booking
        if (session()->has('booking_' . $group_id)) {
            session()->forget('booking_' . $group_id);
            return redirect()->route('home')->with('success', 'Booking selection cleared.');
        }

        // If it's in DB (e.g. user submitted payment but wants to cancel later)
        $booking = Booking::where('group_id', $group_id)->where('user_id', Auth::id())->first();

        if ($booking) {
            if ($booking->status == 'Pending' || $booking->status == 'Unpaid') {
                Booking::where('group_id', $group_id)->delete();
                return redirect()->route('home')->with('success', 'Booking cancelled successfully.');
            }
            return back()->with('error', 'Cannot cancel approved bookings.');
        }

        return redirect()->route('home');
    }

    // DASHBOARD: Only shows REAL bookings (Pending/Approved)
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('court')
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    // --- ADMIN & OTHER METHODS REMAIN UNCHANGED ---

    public function approve($group_id)
    {
        Booking::where('group_id', $group_id)->update(['status' => 'Approved']);
        return back()->with('success', 'Booking Approved!');
    }

    public function reject($group_id)
    {
        Booking::where('group_id', $group_id)->update(['status' => 'Rejected']);
        return back()->with('success', 'Booking Rejected.');
    }

    public function indexAdmin(Request $request)
    {
        $query = Booking::with(['user', 'court'])->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('group_id', 'like', "%$search%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%$search%");
                  });
            });
        }

        if ($request->has('status') && $request->status != 'All') {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function editAdmin($group_id)
    {
        $booking = Booking::where('group_id', $group_id)->firstOrFail();
        $totalHours = Booking::where('group_id', $group_id)->count();
        $courts = Court::all(); 

        return view('admin.bookings.edit', compact('booking', 'totalHours', 'courts'));
    }

    public function updateAdmin(Request $request, $group_id)
    {
        $request->validate([
            'status' => 'required',
            'date' => 'required|date',
            'start_time' => 'required',
            'court_id' => 'required|exists:courts,id',
            'duration' => 'required|integer|min:1|max:5',
        ]);

        $original = Booking::where('group_id', $group_id)->firstOrFail();
        $userId = $original->user_id;
        $proof = $original->payment_proof;
        $createdAt = $original->created_at;

        Booking::where('group_id', $group_id)->delete();

        $startTime = \Carbon\Carbon::parse($request->start_time);

        for ($i = 0; $i < $request->duration; $i++) {
            $slotStart = $startTime->copy()->addHours($i);
            $slotEnd = $slotStart->copy()->addHour();

            Booking::create([
                'group_id' => $group_id,
                'user_id' => $userId,
                'court_id' => $request->court_id,
                'date' => $request->date,
                'start_time' => $slotStart->format('H:i:s'),
                'end_time' => $slotEnd->format('H:i:s'),
                'status' => $request->status,
                'payment_proof' => $proof,
                'created_at' => $createdAt,
            ]);
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully!');
    }

    public function userList(Request $request)
    {
        $query = \App\Models\User::withCount('bookings')->latest();

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // CHECK AVAILABILITY
    // This checks the DATABASE. Since we only save to DB *after* payment, 
    // abandoned drafts (sessions) will NOT block these slots.
    public function checkAvailability(Request $request)
    {
        $bookedTimes = Booking::where('date', $request->date)
            ->where('court_id', $request->court_id)
            ->where('court_number', $request->court_number)
            ->whereNotIn('status', ['Rejected', 'Cancelled'])
            ->pluck('start_time')
            ->map(function ($time) {
                return date('H:i', strtotime($time));
            })
            ->toArray();

        return response()->json($bookedTimes);
    }
}
