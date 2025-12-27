@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">My Bookings</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($bookings->isEmpty())
        <div class="card text-center py-5">
            <div class="card-body">
                <i class="bi bi-calendar-x" style="font-size: 4rem; color: #ccc;"></i>
                <h3 class="mt-3">No Bookings Yet</h3>
                <p class="text-muted">You haven't made any bookings yet.</p>
                <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-search"></i> Browse Venues
                </a>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($bookings as $booking)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-start border-5 
                        @if($booking->status === 'confirmed') border-success
                        @elseif($booking->status === 'cancelled') border-danger
                        @else border-warning
                        @endif">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title mb-0">{{ $booking->venue->name }}</h5>
                                <span class="badge 
                                    @if($booking->status === 'confirmed') bg-success
                                    @elseif($booking->status === 'cancelled') bg-danger
                                    @else bg-warning
                                    @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>

                            <p class="text-muted mb-3">
                                <i class="bi bi-geo-alt"></i> {{ $booking->venue->location }}
                            </p>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted">Date</small>
                                    <p class="mb-0 fw-bold">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                                    </p>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Time</small>
                                    <p class="mb-0 fw-bold">
                                        {{ $booking->start_time }} - {{ $booking->end_time }}
                                    </p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted">Total Price</small>
                                    <p class="mb-0 fw-bold text-primary" style="font-size: 1.2rem;">
                                        RM {{ number_format($booking->total_price, 2) }}
                                    </p>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Booked On</small>
                                    <p class="mb-0">
                                        {{ $booking->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>

                            @if($booking->notes)
                                <div class="mb-3">
                                    <small class="text-muted">Notes</small>
                                    <p class="mb-0">{{ $booking->notes }}</p>
                                </div>
                            @endif

                            @if($booking->status === 'cancelled' && $booking->cancellation_reason)
                                <div class="alert alert-danger mb-0">
                                    <strong><i class="bi bi-x-circle"></i> Cancellation Reason:</strong>
                                    <p class="mb-0 mt-2">{{ $booking->cancellation_reason }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination if needed --}}
        <div class="d-flex justify-content-center">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection