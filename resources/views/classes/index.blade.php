@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col">
            <h2>School Classes</h2>
        </div>
        @can('create', App\Models\SchoolClass::class)
        <div class="col-auto">
            <a href="{{ route('classes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add New Class
            </a>
        </div>
        @endcan
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @if($classes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Section</th>
                                <th>Description</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classes as $class)
                                <tr>
                                    <td>{{ $class->id }}</td>
                                    <td>
                                        <a href="{{ route('classes.show', $class) }}" class="text-decoration-none">
                                            {{ $class->name }}
                                        </a>
                                    </td>
                                    <td>{{ $class->section ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($class->description, 50) }}</td>
                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            @can('view', $class)
                                            <a href="{{ route('classes.show', $class) }}" 
                                               class="btn btn-sm btn-outline-primary rounded-pill px-3" 
                                               title="View Class"
                                               data-bs-toggle="tooltip"
                                               data-bs-placement="top">
                                                <i class="fas fa-eye me-1"></i> View
                                            </a>
                                            @endcan
                                            
                                            @can('update', $class)
                                            <a href="{{ route('classes.edit', $class) }}" 
                                               class="btn btn-sm btn-outline-warning rounded-pill px-3"
                                               title="Edit Class"
                                               data-bs-toggle="tooltip"
                                               data-bs-placement="top">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            @endcan
                                            
                                            @if(auth()->user()->hasRole('admin'))
                                            <form action="{{ route('classes.destroy', $class) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this class? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                        title="Delete Class"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top">
                                                    <i class="fas fa-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($classes->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $classes->links() }}
                </div>
                @endif
                
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-school fa-4x text-muted"></i>
                    </div>
                    <h4 class="text-muted">
                        @if(auth()->user()->hasRole('teacher'))
                            You are not assigned to any classes yet.
                        @else
                            No classes found.
                        @endif
                    </h4>
                    @can('create', App\Models\SchoolClass::class)
                    <p class="mt-3">
                        <a href="{{ route('classes.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Create New Class
                        </a>
                    </p>
                    @endcan
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    .btn {
        transition: all 0.2s ease-in-out;
    }
    .btn:hover {
        transform: translateY(-1px);
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-dismiss alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endpush
@endsection