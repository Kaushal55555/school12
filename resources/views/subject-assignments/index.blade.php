@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Subject Assignments</h1>
        <a href="{{ route('subject-assignments.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> New Assignment
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Teacher</th>
                            <th>Subject</th>
                            <th>Class</th>
                            <th>Academic Year</th>
                            <th>Term</th>
                            <th>Class Teacher</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignments as $assignment)
                            <tr>
                                <td>{{ $assignment->teacher->user->name }}</td>
                                <td>{{ $assignment->subject->name }}</td>
                                <td>{{ $assignment->schoolClass->name }}</td>
                                <td>{{ $assignment->academic_year }}</td>
                                <td>{{ $assignment->term }}</td>
                                <td>
                                    @if($assignment->is_class_teacher)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('subject-assignments.edit', $assignment) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('subject-assignments.destroy', $assignment) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No assignments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $assignments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
