{{-- resources/views/admin/venues/edit.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Edit Venue</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.venues.index') }}">Venues</a></li>
                    <li class="breadcrumb-item active">Edit: {{ $venue->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Venue Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.venues.update', $venue) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Venue Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $venue->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location', $venue->location) }}" 
                                   placeholder="e.g., Block A, Level 3" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description', $venue->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="capacity" class="form-label">Capacity (People) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                                       id="capacity" name="capacity" value="{{ old('capacity', $venue->capacity) }}" min="1" required>
                                @error('capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price_per_hour" class="form-label">Price per Hour (RM) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('price_per_hour') is-invalid @enderror" 
                                       id="price_per_hour" name="price_per_hour" 
                                       value="{{ old('price_per_hour', $venue->price_per_hour) }}" 
                                       step="0.01" min="0" required>
                                @error('price_per_hour')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image URL</label>
                            <input type="text" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" value="{{ old('image', $venue->image) }}" 
                                   placeholder="https://example.com/image.jpg">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($venue->image)
                                <div class="mt-2">
                                    <small class="text-muted d-block mb-1">Current Image:</small>
                                    <img src="{{ $venue->image }}" alt="{{ $venue->name }}" 
                                         style="max-width: 200px; border-radius: 5px;">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_available" 
                                   name="is_available" value="1" 
                                   {{ old('is_available', $venue->is_available) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_available">
                                Mark as available for booking
                            </label>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.venues.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update Venue
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Booking Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6>Total Bookings</h6>
                        <h2>{{ $venue->bookings->count() }}</h2>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <h6>Pending Bookings</h6>
                        <h3 class="text-warning">{{ $venue->bookings->where('status', 'pending')->count() }}</h3>
                    </div>
                    <div class="mb-3">
                        <h6>Confirmed Bookings</h6>
                        <h3 class="text-success">{{ $venue->bookings->where('status', 'confirmed')->count() }}</h3>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Danger Zone</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Delete this venue?</strong></p>
                    <p class="small text-muted">This action cannot be undone. All associated bookings will also be removed.</p>
                    <form action="{{ route('admin.venues.destroy', $venue) }}" method="POST" 
                          onsubmit="return confirm('Are you absolutely sure? This will delete the venue and all its bookings!');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash"></i> Delete Venue
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection