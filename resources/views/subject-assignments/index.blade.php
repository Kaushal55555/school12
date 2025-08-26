@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Subject Assignments</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('subject-assignments.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Assignment
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <style>
                        .table-hover tbody tr:hover td {
                            background-color: #f8f9fa;
                        }
                        .table-hover tbody tr:hover td:last-child {
                            background-color: transparent;
                        }
                    </style>
                    <thead>
                        <tr>
                            <th>Teacher</th>
                            <th>Subject</th>
                            <th>Class</th>
                            <th>Academic Year</th>
                            <th>Term</th>
                            <th>Class Teacher</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
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
                                <td class="text-center">
                                    @if($assignment->is_class_teacher)
                                        <span class="badge bg-success px-3 py-2"><i class="fas fa-user-tie me-1"></i> Class Teacher</span>
                                    @else
                                        <span class="badge bg-secondary px-2 py-1">Subject Teacher</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Active</span>
                                </td>
                                <td class="p-2">
                                    <div class="flex space-x-2">
                                    <a href="#" 
                                       class="bg-cyan-400 text-white px-3 py-1 rounded hover:bg-cyan-500 text-sm">
                                        View
                                    </a>
                                    <a href="{{ route('subject-assignments.edit', $assignment) }}" 
                                       class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('subject-assignments.destroy', $assignment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this assignment?');" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                                            Delete
                                        </button>
                                    </form>
                                    </div>
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
