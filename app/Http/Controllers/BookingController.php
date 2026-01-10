<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Court;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // Import Str for random ID
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function create($court_id)
    {
        $court = Court::findOrFail($court_id);
        return view('bookings.create', compact('court'));
    }

    // 1. SAVE BOOKING & REDIRECT TO CONFIRMATION
    public function store(Request $request)
    {
        $request->validate([
            'court_id' => 'required',
            'date' => 'required|date',
            'slots' => 'required|array',
            'court_number' => 'required',
        ]);

        // Generate a unique Group ID for this batch (e.g., BK-78329)
        $groupId = 'BK-' . strtoupper(Str::random(6));

        foreach ($request->slots as $time_slot) {
            Booking::create([
                'user_id' => Auth::id(),
                'court_id' => $request->court_id,
                'group_id' => $groupId, // Save the Group ID
                'court_number' => $request->court_number,
                'date' => $request->date,
                'start_time' => $time_slot,
                'end_time' => date('H:i', strtotime($time_slot) + 3600),
                'status' => 'Unpaid', // Status is Pending until they confirm on next page
            ]);
        }

        // Redirect to the new Confirmation Page
        return redirect()->route('bookings.confirmation', $groupId);
    }

    // 2. SHOW CONFIRMATION PAGE (Prototype Page 13)
    public function confirmation($group_id)
    {
        // Find all bookings with this Group ID
        $bookings = Booking::where('group_id', $group_id)->with('court')->get();

        if ($bookings->isEmpty()) {
            return redirect()->route('home');
        }

        // Calculate totals for the view
        $firstBooking = $bookings->first();
        $totalPrice = $bookings->count() * $firstBooking->court->price;
        $totalHours = $bookings->count();
        
        return view('bookings.confirmation', compact('bookings', 'firstBooking', 'totalPrice', 'totalHours', 'group_id'));
    }

    // In index() method:
// 1. UPDATE INDEX (Show All Bookings)
public function index()
{
    // REMOVED "where status != Unpaid" so users can resume payment
    $bookings = Booking::where('user_id', Auth::id())
        ->with('court')
        ->latest()
        ->get();

    return view('bookings.index', compact('bookings'));
}

// 2. ADD CANCEL FUNCTION
public function cancel($group_id)
{
    $booking = Booking::where('group_id', $group_id)->where('user_id', Auth::id())->firstOrFail();

    // Only allow cancelling if not yet approved
    if ($booking->status == 'Pending' || $booking->status == 'Unpaid') {
        Booking::where('group_id', $group_id)->delete(); // Or update status to 'Cancelled'
        return back()->with('success', 'Booking cancelled successfully.');
    }

    return back()->with('error', 'Cannot cancel approved bookings.');
}
    // 3. SHOW PAYMENT PAGE (Prototype Page 14)
    public function payment($group_id)
    {
        $bookings = Booking::where('group_id', $group_id)->get();
        
        if ($bookings->isEmpty()) {
            return redirect()->route('home');
        }

        $totalPrice = $bookings->count() * $bookings->first()->court->price;

        return view('bookings.payment', compact('bookings', 'totalPrice', 'group_id'));
    }

   // REPLACE the old paymentSuccess function with this new one:
    
   public function submitPayment(Request $request, $group_id)
   {
       $request->validate([
           'pay_name' => 'required|string',
           'pay_matric' => 'required|string',
           'pay_contact' => 'required|string',
           'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Max 2MB
       ]);

       // 1. Handle File Upload
       if ($request->hasFile('payment_proof')) {
           // Save file to 'storage/app/public/receipts'
           $path = $request->file('payment_proof')->store('receipts', 'public');
       } else {
           return back()->with('error', 'Please upload a receipt.');
       }

       // 2. Update Bookings (Save proof & mark as Paid)
       // Note: In a real app, you might set status to 'Pending Verification'
       Booking::where('group_id', $group_id)->update([
           'status' => 'Pending', 
           'payment_proof' => $path
       ]);

       // 3. Show Success Page
       return view('bookings.success', compact('group_id'));
   }

   // --- ADMIN ACTIONS ---

   public function approve($group_id)
   {
       // Change status to 'Approved'
       Booking::where('group_id', $group_id)->update(['status' => 'Approved']);
       return back()->with('success', 'Booking Approved!');
   }

   public function reject($group_id)
   {
       // Change status to 'Rejected'
       Booking::where('group_id', $group_id)->update(['status' => 'Rejected']);
       return back()->with('success', 'Booking Rejected.');
   }

   // --- ADMIN: MANAGE ALL BOOKINGS ---
   public function indexAdmin(Request $request)
   {
       $query = Booking::with(['user', 'court'])->latest();

       // 1. Search Logic (Student Name or Group ID)
       if ($request->has('search') && $request->search != '') {
           $search = $request->search;
           $query->where(function($q) use ($search) {
               $q->where('group_id', 'like', "%$search%")
                 ->orWhereHas('user', function($u) use ($search) {
                     $u->where('name', 'like', "%$search%");
                 });
           });
       }

       // 2. Filter Logic (Status)
       if ($request->has('status') && $request->status != 'All') {
           $query->where('status', $request->status);
       }

       // Get results (Pagination: 10 per page)
       $bookings = $query->paginate(10);

       return view('admin.bookings.index', compact('bookings'));
   }

   // --- ADMIN: EDIT BOOKING ---

    // --- ADMIN: EDIT BOOKING ---

    public function editAdmin($group_id)
    {
        $booking = Booking::where('group_id', $group_id)->firstOrFail();
        $totalHours = Booking::where('group_id', $group_id)->count();
        
        // Fetch all courts for the dropdown
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
            'duration' => 'required|integer|min:1|max:5', // Limit max hours if needed
        ]);

        // 1. Get original booking metadata (User ID, Proof, etc.)
        $original = Booking::where('group_id', $group_id)->firstOrFail();
        $userId = $original->user_id;
        $proof = $original->payment_proof;
        $createdAt = $original->created_at;

        // 2. DELETE OLD SLOTS (Because duration/times might have changed completely)
        Booking::where('group_id', $group_id)->delete();

        // 3. CREATE NEW SLOTS
        $startTime = \Carbon\Carbon::parse($request->start_time);

        for ($i = 0; $i < $request->duration; $i++) {
            $slotStart = $startTime->copy()->addHours($i);
            $slotEnd = $slotStart->copy()->addHour();

            Booking::create([
                'group_id' => $group_id,
                'user_id' => $userId,
                'court_id' => $request->court_id, // New Court
                'date' => $request->date,
                'start_time' => $slotStart->format('H:i:s'),
                'end_time' => $slotEnd->format('H:i:s'),
                'status' => $request->status,
                'payment_proof' => $proof, // Keep the old receipt
                'created_at' => $createdAt, // Keep original booking time
            ]);
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully!');
    }

    // --- ADMIN: STUDENT LIST ---
    // --- ADMIN: USER LIST (FETCH ALL REGISTERED USERS) ---
    // --- ADMIN: USER LIST ---
    // --- ADMIN: USER LIST ---
    public function userList(Request $request)
    {
        // DEBUG MODE: Get ALL users. No filters. No exclusions.
        // We also use 'latest()' to make sure the NEWEST user is at the top.
        $query = \App\Models\User::withCount('bookings')->latest();

        // Keep the search logic just in case you need it later
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function checkAvailability(Request $request)
    {
        // 1. Find bookings for this specific Date + Court Facility + Court Number (A, B, C)
        // We exclude 'Rejected' and 'Cancelled' so users can re-book those slots.
        $bookedTimes = Booking::where('date', $request->date)
            ->where('court_id', $request->court_id)
            ->where('court_number', $request->court_number)
            ->whereNotIn('status', ['Rejected', 'Cancelled'])
            ->pluck('start_time') // Get only the times
            ->map(function ($time) {
                // Format "08:00:00" to "08:00" to match your checkbox values
                return date('H:i', strtotime($time));
            })
            ->toArray();

        return response()->json($bookedTimes);
    }

}