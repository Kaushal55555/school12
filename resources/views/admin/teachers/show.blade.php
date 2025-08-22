@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h2>Teacher Details: {{ $teacher->user->name }}</h2>
        <div>
            <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('teachers.index') }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    @if($teacher->photo_path)
                        <img src="{{ asset('storage/' . $teacher->photo_path) }}" 
                             alt="{{ $teacher->user->name }}" 
                             class="img-thumbnail mb-3" 
                             style="width: 200px; height: 200px; object-fit: cover;">
                    @else
                        <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                             style="width: 200px; height: 200px; background-color: #e9ecef; font-size: 80px;">
                            <i class="fas fa-user text-muted"></i>
                        </div>
                    @endif
                    <h4>{{ $teacher->user->name }}</h4>
                    <p class="text-muted">{{ $teacher->qualification }}</p>
                    
                    <div class="mt-3">
                        <span class="badge {{ $teacher->is_active ? 'badge-success' : 'badge-secondary' }} p-2">
                            {{ $teacher->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Contact Information</h5>
                </div>
                <div class="card-body">
                    <p><i class="fas fa-envelope mr-2"></i> {{ $teacher->user->email }}</p>
                    <p><i class="fas fa-phone mr-2"></i> {{ $teacher->phone }}</p>
                    <p><i class="fas fa-map-marker-alt mr-2"></i> {{ $teacher->address }}</p>
                    <p><i class="fas fa-venus-mars mr-2"></i> {{ ucfirst($teacher->gender) }}</p>
                    <p><i class="fas fa-birthday-cake mr-2"></i> {{ $teacher->formatted_date_of_birth }}
                        <small class="text-muted">({{ Carbon\Carbon::parse($teacher->date_of_birth)->age }} years old)</small>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Professional Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6>Employee ID</h6>
                            <p>{{ $teacher->employee_id }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Joining Date</h6>
                            <p>{{ $teacher->formatted_joining_date }}
                                <small class="text-muted">({{ $teacher->years_of_service }} ago)</small>
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6>Bio</h6>
                        <p>{{ $teacher->bio ?? 'No bio available.' }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Assigned Classes</h5>
                        </div>
                        <div class="card-body">
                            @if($teacher->classes->count() > 0)
                                <div class="list-group">
                                    @foreach($teacher->classes as $class)
                                        <div class="list-group-item">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">{{ $class->name }}</h6>
                                                <small>{{ $class->section }}</small>
                                            </div>
                                            <small class="text-muted">{{ $class->classTeacher ? 'Class Teacher' : 'Subject Teacher' }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted mb-0">No classes assigned yet.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Subjects Taught</h5>
                        </div>
                        <div class="card-body">
                            @if($teacher->subjects->count() > 0)
                                <div class="list-group">
                                    @foreach($teacher->subjects as $subject)
                                        <div class="list-group-item">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">{{ $subject->name }}</h6>
                                                <small>{{ $subject->code }}</small>
                                            </div>
                                            <small class="text-muted">{{ $subject->description ?: 'No description' }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted mb-0">No subjects assigned yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Actions</h5>
        </div>
        <div class="card-body">
            <div class="btn-group" role="group">
                <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Teacher
                </a>
                <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Are you sure you want to delete this teacher? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete Teacher
                    </button>
                </form>
                <a href="#" class="btn btn-info">
                    <i class="fas fa-chart-line"></i> View Performance
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
