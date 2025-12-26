{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1>Find Your Perfect Venue</h1>
            <p>Book meeting rooms, conference halls, and event spaces with ease</p>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="search-box">
                        <form action="#" method="GET" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label text-dark">Date</label>
                                <input type="date" name="date" class="form-control form-control-lg" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label text-dark">Start Time</label>
                                <input type="time" name="start_time" class="form-control form-control-lg" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label text-dark">End Time</label>
                                <input type="time" name="end_time" class="form-control form-control-lg" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label text-dark">&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="bi bi-calendar-check feature-icon"></i>
                        <h4>Easy Booking</h4>
                        <p>Book your venue in just a few clicks with our simple interface</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="bi bi-shield-check feature-icon"></i>
                        <h4>Secure & Reliable</h4>
                        <p>Your bookings are confirmed instantly and securely stored</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="bi bi-clock-history feature-icon"></i>
                        <h4>24/7 Availability</h4>
                        <p>Check availability and book venues anytime, anywhere</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Available Venues Section -->
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h2>Available Venues</h2>
                <span class="badge bg-primary" style="font-size: 1rem;">{{ $venues->count() }} Venues</span>
            </div>

            @if($venues->count() > 0)
                <div class="row">
                    @foreach($venues as $venue)
                        <div class="col-md-4">
                            <div class="card venue-card">
                                @if($venue->image)
                                    <img src="{{ $venue->image }}" class="card-img-top" alt="{{ $venue->name }}">
                                @else
                                    <div style="height: 250px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-building" style="font-size: 4rem; color: white; opacity: 0.5;"></i>
                                    </div>
                                @endif
                                
                                <div class="card-body">
                                    <h5 class="card-title">{{ $venue->name }}</h5>
                                    <p class="card-text text-muted">
                                        <i class="bi bi-geo-alt"></i> {{ $venue->location }}
                                    </p>
                                    <p class="card-text">
                                        {{ Str::limit($venue->description, 80) }}
                                    </p>
                                    <div class="mb-3">
                                        <span class="badge badge-capacity">
                                            <i class="bi bi-people"></i> {{ $venue->capacity }} People
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="price">RM {{ number_format($venue->price_per_hour, 2) }}<small class="text-muted">/hour</small></div>
                                        <a href="{{ route('venues.show', $venue) }}" class="btn btn-primary">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- No Venues Available -->
                <div class="row">
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 5rem; color: #ddd;"></i>
                            <h3 class="mt-3 text-muted">No Venues Available Yet</h3>
                            <p class="text-muted">Check back later or contact the admin to add venues.</p>
                            @auth
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.venues.create') }}" class="btn btn-primary mt-3">
                                        <i class="bi bi-plus-circle"></i> Add Your First Venue
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Call to Action -->
    @if($venues->count() > 0)
    <section class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="mb-4">Ready to Book Your Venue?</h2>
            <p class="lead mb-4">Join hundreds of satisfied customers who have found their perfect event space with us.</p>
            @guest
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-2">
                    <i class="bi bi-person-plus"></i> Sign Up Now
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
            @endguest
        </div>
    </section>
    @endif
@endsection