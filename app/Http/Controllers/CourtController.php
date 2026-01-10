<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Court;
use Illuminate\Support\Facades\Storage;

class CourtController extends Controller
{
    // USER VIEW: Show only Available courts
    public function index()
    {
        $courts = Court::where('status', 'Available')->get();
        return view('courts.index', compact('courts'));
    }

    // ADMIN VIEW: Create Court & List Existing
    public function create()
    {
        $courts = Court::latest()->get();
        return view('admin.courts.create', compact('courts'));
    }

    // STORE NEW COURT
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courts', 'public');
        }

        Court::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'status' => 'Available', // Default
            'image' => $imagePath ?? null,
        ]);

        return redirect()->route('admin.courts.create')->with('success', 'New facility added successfully!');
    }

    // EDIT FORM
    public function edit(string $id)
    {
        $court = Court::findOrFail($id);
        return view('admin.courts.edit', compact('court'));
    }

    // UPDATE COURT
    public function update(Request $request, string $id)
    {
        $court = Court::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:Available,Unavailable', // <--- UPDATED
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($court->image) {
                Storage::disk('public')->delete($court->image);
            }
            $court->image = $request->file('image')->store('courts', 'public');
        }

        $court->update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        // Save is automatic with update(), no need to call save() again unless manually assigning
        // But for image handling above, we might need to assign if we didn't include it in update array
        // actually $court->image is assigned to model property, so we need to save if not in update() array.
        // Let's fix the logic to be cleaner:
        
        // (Re-doing update logic for safety)
        $data = [
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'status' => $request->status,
        ];
        
        // If image was uploaded, add to data
        if($request->hasFile('image')) {
             $data['image'] = $court->image; // currently holds the new path
        }
        
        // Since I assigned $court->image directly above, I should just call save() to be safe or include it in update
        $court->save(); 

        return redirect()->route('admin.courts.create')->with('success', 'Facility updated successfully!');
    }

    // DELETE COURT
    public function destroy(string $id)
    {
        $court = Court::findOrFail($id);
        if ($court->image) {
            Storage::disk('public')->delete($court->image);
        }
        $court->delete();

        return redirect()->route('admin.courts.create')->with('success', 'Facility deleted successfully!');
    }
}