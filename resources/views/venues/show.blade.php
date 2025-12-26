{{-- resources/views/venues/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">{{ $venue->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Venue Details -->
        <div class="col-lg-8">
            <!-- Venue Image -->
            <div class="card mb-4">
                @if($venue->image)
                    <img src="{{ $venue->image }}" class="card-img-top" alt="{{ $venue->name }}" style="height: 400px; object-fit: cover;">
                @else
                    <div style="height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-building" style="font-size: 6rem; color: white; opacity: 0.5;"></i>
                    </div>
                @endif
            </div>

            <!-- Venue Information -->
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title mb-3">{{ $venue->name }}</h2>
                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-geo-alt fs-4 text-primary me-2"></i>
                                <div>
                                    <small class="text-muted d-block">Location</small>
                                    <strong>{{ $venue->location }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-people fs-4 text-primary me-2"></i>
                                <div>
                                    <small class="text-muted d-block">Capacity</small>
                                    <strong>{{ $venue->capacity }} People</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-currency-dollar fs-4 text-primary me-2"></i>
                                <div>
                                    <small class="text-muted d-block">Price</small>
                                    <strong>RM {{ number_format($venue->price_per_hour, 2) }}/hour</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h5 class="mb-3">About This Venue</h5>
                    <p class="text-muted">{{ $venue->description }}</p>

                    <hr>

                    <h5 class="mb-3">Amenities & Features</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Projector & Screen</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> High-Speed WiFi</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Air Conditioning</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Whiteboard</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Sound System</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Parking Available</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Book This Venue</h5>
                </div>
                <div class="card-body">
                    @guest
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Please <a href="{{ route('login') }}" class="alert-link">login</a> to book this venue.
                        </div>
                        <a href="{{ route('login') }}" class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-box-arrow-in-right"></i> Login to Book
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-person-plus"></i> Create Account
                        </a>
                    @else
                        <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
                            @csrf
                            <input type="hidden" name="venue_id" value="{{ $venue->id }}">

                            <div class="mb-3">
                                <label for="booking_date" class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('booking_date') is-invalid @enderror" 
                                       id="booking_date" name="booking_date" required 
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ old('booking_date') }}">
                                @error('booking_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('start_time') is-invalid @enderror" 
                                       id="start_time" name="start_time" required
                                       value="{{ old('start_time') }}">
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('end_time') is-invalid @enderror" 
                                       id="end_time" name="end_time" required
                                       value="{{ old('end_time') }}">
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Additional Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" 
                                          placeholder="Any special requirements?">{{ old('notes') }}</textarea>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Price per hour:</span>
                                <strong>RM {{ number_format($venue->price_per_hour, 2) }}</strong>
                            </div>

                            <div id="priceCalculation" class="alert alert-info" style="display: none;">
                                <div class="d-flex justify-content-between">
                                    <span>Duration:</span>
                                    <strong id="duration">-</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Total Price:</span>
                                    <strong id="totalPrice">RM 0.00</strong>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-lg">
                                <i class="bi bi-check-circle"></i> Confirm Booking
                            </button>
                        </form>
                    @endguest
                </div>
            </div>

            <!-- Booking Guidelines -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6><i class="bi bi-exclamation-circle text-warning"></i> Booking Guidelines</h6>
                    <ul class="small mb-0">
                        <li>Bookings must be made at least 24 hours in advance</li>
                        <li>Cancellations must be made 48 hours before booking</li>
                        <li>Admin approval required for all bookings</li>
                        <li>Full payment required upon confirmation</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.breadcrumb {
    background-color: transparent;
    padding: 0;
}
.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
}
.sticky-top {
    position: sticky;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');
    const pricePerHour = {{ $venue->price_per_hour }};

    function calculatePrice() {
        if (startTime.value && endTime.value) {
            const start = new Date('2000-01-01 ' + startTime.value);
            const end = new Date('2000-01-01 ' + endTime.value);
            
            if (end > start) {
                const diffMs = end - start;
                const diffHrs = diffMs / (1000 * 60 * 60);
                const totalPrice = diffHrs * pricePerHour;
                
                document.getElementById('duration').textContent = diffHrs.toFixed(1) + ' hours';
                document.getElementById('totalPrice').textContent = 'RM ' + totalPrice.toFixed(2);
                document.getElementById('priceCalculation').style.display = 'block';
            } else {
                document.getElementById('priceCalculation').style.display = 'none';
            }
        }
    }

    startTime.addEventListener('change', calculatePrice);
    endTime.addEventListener('change', calculatePrice);
});
</script>
@endsection