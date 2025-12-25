{{-- resources/views/admin/venues/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Manage Venues</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.venues.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Venue
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Capacity</th>
                            <th>Price/Hour</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($venues as $venue)
                        <tr>
                            <td>{{ $venue->id }}</td>
                            <td>
                                @if($venue->image)
                                    <img src="{{ $venue->image }}" alt="{{ $venue->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                                @else
                                    <div style="width: 60px; height: 60px; background: #ddd; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $venue->name }}</strong><br>
                                <small class="text-muted">{{ Str::limit($venue->description, 50) }}</small>
                            </td>
                            <td>{{ $venue->location }}</td>
                            <td>
                                <span class="badge bg-info">
                                    <i class="bi bi-people"></i> {{ $venue->capacity }}
                                </span>
                            </td>
                            <td><strong>RM {{ number_format($venue->price_per_hour, 2) }}</strong></td>
                            <td>
                                @if($venue->is_available)
                                    <span class="badge bg-success">Available</span>
                                @else
                                    <span class="badge bg-danger">Unavailable</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.venues.edit', $venue) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.venues.destroy', $venue) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this venue?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #ddd;"></i>
                                <p class="mt-2">No venues found. <a href="{{ route('admin.venues.create') }}">Add your first venue</a></p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection