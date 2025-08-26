@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Teachers</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('teachers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Teacher
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <style>
                        .table-hover tbody tr:hover td {
                            background-color: #f8f9fa;
                        }
                        .table-hover tbody tr:hover td:last-child {
                            background-color: transparent;
                        }
                    </style>
                    <thead class="thead-light">
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Employee ID</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachers as $teacher)
                            <tr>
                                <td>
                                    @if($teacher->photo_path)
                                        <img src="{{ asset('storage/' . $teacher->photo_path) }}" 
                                             alt="{{ $teacher->user->name }}" 
                                             class="rounded-circle" 
                                             width="40" 
                                             height="40">
                                    @else
                                        <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px; background-color: #e9ecef;">
                                            <i class="fas fa-user text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $teacher->user->name }}</td>
                                <td>{{ $teacher->employee_id }}</td>
                                <td>{{ $teacher->user->email }}</td>
                                <td>{{ $teacher->phone }}</td>
                                <td>
                                    <span style="display: inline-block; padding: 0.25rem 0.6rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; {{ $teacher->is_active ? 'background-color: #e3f2fd; color: #1976d2;' : 'background-color: #f5f5f5; color: #757575;' }}">
                                        {{ $teacher->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td style="white-space: nowrap; padding: 1rem;">
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <!-- View Button -->
                                        <a href="{{ route('teachers.show', $teacher) }}" 
                                           style="display: inline-flex; align-items: center; padding: 0.375rem 0.75rem; background-color: #1e88e5; color: white; border-radius: 4px; font-size: 0.875rem; text-decoration: none; transition: background-color 0.2s; border: none; cursor: pointer;"
                                           onmouseover="this.style.backgroundColor='#1565c0'"
                                           onmouseout="this.style.backgroundColor='#1e88e5'">
                                            <i class="fas fa-eye" style="margin-right: 0.375rem;"></i>
                                            View
                                        </a>
                                        
                                        <!-- Edit Button -->
                                        <a href="{{ route('teachers.edit', $teacher) }}" 
                                           style="display: inline-flex; align-items: center; padding: 0.375rem 0.75rem; background-color: #4CAF50; color: white; border-radius: 4px; font-size: 0.875rem; text-decoration: none; transition: background-color 0.2s; border: none; cursor: pointer;"
                                           onmouseover="this.style.backgroundColor='#3e8e41'"
                                           onmouseout="this.style.backgroundColor='#4CAF50'">
                                            <i class="fas fa-edit" style="margin-right: 0.375rem;"></i>
                                            Edit
                                        </a>
                                        
                                        <!-- Delete Button -->
                                        <form action="{{ route('teachers.destroy', $teacher) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this teacher?');" 
                                              style="display: inline-block; margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    style="display: inline-flex; align-items: center; padding: 0.375rem 0.75rem; background-color: #f44336; color: white; border: none; border-radius: 4px; font-size: 0.875rem; cursor: pointer; transition: background-color 0.2s;"
                                                    onmouseover="this.style.backgroundColor='#da190b'"
                                                    onmouseout="this.style.backgroundColor='#f44336'">
                                                <i class="fas fa-trash-alt" style="margin-right: 0.375rem;"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No teachers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $teachers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
