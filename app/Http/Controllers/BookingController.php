<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'notes' => 'nullable|string',
        ]);

        // Check if venue is already booked at this time
        $conflictingBooking = Booking::where('venue_id', $validated['venue_id'])
            ->where('booking_date', $validated['booking_date'])
            ->where('status', 'confirmed')
            ->where(function($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function($q) use ($validated) {
                        $q->where('start_time', '<=', $validated['start_time'])
                          ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->exists();

        if ($conflictingBooking) {
            return back()->with('error', 'This venue is already booked for the selected time slot.');
        }

        // Calculate total price
        $venue = Venue::findOrFail($validated['venue_id']);
        $start = strtotime($validated['start_time']);
        $end = strtotime($validated['end_time']);
        $hours = ($end - $start) / 3600;
        $totalPrice = $hours * $venue->price_per_hour;

        // Create booking with confirmed status
        Booking::create([
            'user_id' => Auth::id(),
            'venue_id' => $validated['venue_id'],
            'booking_date' => $validated['booking_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'total_price' => $totalPrice,
            'notes' => $validated['notes'],
            'status' => 'confirmed', // Auto-confirm
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking confirmed successfully!');
    }

    // User's bookings page
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('venue')
            ->orderBy('booking_date', 'desc')
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }
}