@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Student Details: {{ $student->name }}</span>
                    <div>
                        <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">Delete</button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            @if($student->photo_path)
                                <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Student Photo" class="img-thumbnail mb-3" style="max-width: 200px;">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 200px; height: 200px;">
                                    <i class="fas fa-user fa-5x text-white"></i>
                                </div>
                            @endif
                            <h4>{{ $student->name }}</h4>
                            <p class="text-muted">{{ $student->roll_number }}</p>
                        </div>
                        <div class="col-md-8">
                            <h5>Personal Information</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Email:</strong> {{ $student->email }}</p>
                                    <p><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($student->date_of_birth)->format('F j, Y') }}</p>
                                    <p><strong>Age:</strong> {{ \Carbon\Carbon::parse($student->date_of_birth)->age }} years</p>
                                    <p><strong>Gender:</strong> {{ ucfirst($student->gender) }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Class:</strong> {{ $student->schoolClass->name }} ({{ $student->schoolClass->section }})</p>
                                    <p><strong>Parent/Guardian:</strong> {{ $student->parent_name ?? 'N/A' }}</p>
                                    <p><strong>Parent Phone:</strong> {{ $student->parent_phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                            
                            @if($student->address)
                                <div class="mt-3">
                                    <h5>Address</h5>
                                    <hr>
                                    <p>{{ $student->address }}</p>
                                </div>
                            @endif

                            <div class="mt-3">
                                <h5>Academic Information</h5>
                                <hr>
                                <p><strong>Enrollment Date:</strong> {{ $student->created_at->format('F j, Y') }}</p>
                                <p><strong>Last Updated:</strong> {{ $student->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('students.index') }}" class="btn btn-secondary">Back to Students</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection