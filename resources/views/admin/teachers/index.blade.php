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
                                    <span class="badge {{ $teacher->is_active ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $teacher->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="p-2">
                                    <div class="flex space-x-2">
                                    <a href="{{ route('teachers.show', $teacher) }}" 
                                       class="bg-cyan-400 text-white px-3 py-1 rounded hover:bg-cyan-500 text-sm">
                                        View
                                    </a>
                                    <a href="{{ route('teachers.edit', $teacher) }}" 
                                       class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('teachers.destroy', $teacher) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this teacher?');" 
                                          class="m-0">
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
