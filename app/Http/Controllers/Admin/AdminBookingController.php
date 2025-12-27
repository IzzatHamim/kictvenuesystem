<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Notifications\BookingCancelled;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index(Request $request)
{
    // Stats
    $stats = [
        'total_bookings' => Booking::count(),
        'confirmed' => Booking::where('status', 'confirmed')->count(),
        'cancelled' => Booking::where('status', 'cancelled')->count(),
        'today' => Booking::whereDate('booking_date', today())->count(),
    ];

    // Query with filters
    $query = Booking::with(['user', 'venue']);

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('date')) {
        $query->whereDate('booking_date', $request->date);
    }

    $bookings = $query->orderBy('booking_date', 'desc')->paginate(20);

    return view('admin.bookings.index', compact('bookings', 'stats'));
}

    public function cancel(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        $booking->update([
            'status' => 'cancelled',
            'cancellation_reason' => $validated['cancellation_reason'],
        ]);

        // Send notification to user
        $booking->user->notify(new BookingCancelled($booking));

        return back()->with('success', 'Booking cancelled and user has been notified.');
    }
    
}