{{-- resources/views/admin/venues/create.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Add New Venue</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.venues.index') }}">Venues</a></li>
                    <li class="breadcrumb-item active">Add New</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Venue Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.venues.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Venue Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location') }}" 
                                   placeholder="e.g., Block A, Level 3" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Describe the venue, its features, and amenities.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="capacity" class="form-label">Capacity (People) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                                       id="capacity" name="capacity" value="{{ old('capacity') }}" min="1" required>
                                @error('capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price_per_hour" class="form-label">Price per Hour (RM) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('price_per_hour') is-invalid @enderror" 
                                       id="price_per_hour" name="price_per_hour" value="{{ old('price_per_hour') }}" 
                                       step="0.01" min="0" required>
                                @error('price_per_hour')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image URL</label>
                            <input type="text" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" value="{{ old('image') }}" 
                                   placeholder="https://example.com/image.jpg">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Enter an image URL (optional). You can use images from Unsplash or other free image sources.</small>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_available" 
                                   name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_available">
                                Mark as available for booking
                            </label>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.venues.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Save Venue
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Tips</h5>
                </div>
                <div class="card-body">
                    <h6>Adding a Great Venue</h6>
                    <ul class="small">
                        <li>Use a clear, descriptive name</li>
                        <li>Provide detailed location information</li>
                        <li>Describe all amenities and features</li>
                        <li>Set competitive pricing</li>
                        <li>Add a high-quality image</li>
                    </ul>

                    <hr>

                    <h6>Free Image Sources</h6>
                    <ul class="small mb-0">
                        <li><a href="https://unsplash.com" target="_blank">Unsplash</a></li>
                        <li><a href="https://pexels.com" target="_blank">Pexels</a></li>
                        <li><a href="https://pixabay.com" target="_blank">Pixabay</a></li>
                    </ul>
                    <small class="text-muted d-block mt-2">Right-click on an image and select "Copy image address"</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection