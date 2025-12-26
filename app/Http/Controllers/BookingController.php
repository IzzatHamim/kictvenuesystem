<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'notes' => 'nullable|string',
        ]);

        // Calculate total price
        $venue = Venue::findOrFail($validated['venue_id']);
        $start = strtotime($validated['start_time']);
        $end = strtotime($validated['end_time']);
        $hours = ($end - $start) / 3600;
        $totalPrice = $hours * $venue->price_per_hour;

        // Create booking
        Booking::create([
            'user_id' => Auth::id(),
            'venue_id' => $validated['venue_id'],
            'booking_date' => $validated['booking_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'total_price' => $totalPrice,
            'notes' => $validated['notes'],
            'status' => 'pending',
        ]);

        return redirect()->route('home')->with('success', 'Booking submitted successfully! Waiting for admin approval.');
    }
}