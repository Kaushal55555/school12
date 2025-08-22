@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col">
            <h2>School Classes</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('classes.create') }}" class="btn btn-primary">Add New Class</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Section</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classes as $class)
                            <tr>
                                <td>{{ $class->id }}</td>
                                <td>{{ $class->name }}</td>
                                <td>{{ $class->section ?? 'N/A' }}</td>
                                <td>{{ Str::limit($class->description, 50) }}</td>
                                <td>
                                    <a href="{{ route('classes.show', $class) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('classes.edit', $class) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('classes.destroy', $class) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No classes found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $classes->links() }}
        </div>
    </div>
</div>
@endsection