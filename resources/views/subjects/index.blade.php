@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Subjects</h2>
        <a href="{{ route('subjects.create') }}" class="btn btn-primary">Add New Subject</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
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
                            <th>Code</th>
                            <th>Class</th>
                            <th>Full Marks</th>
                            <th>Pass Marks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $subject)
                            <tr>
                                <td>{{ $subject->id }}</td>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->code }}</td>
                                <td>{{ $subject->schoolClass->name }} ({{ $subject->schoolClass->section }})</td>
                                <td>{{ $subject->full_marks }}</td>
                                <td>{{ $subject->pass_marks }}</td>
                                <td>
                                    <a href="{{ route('subjects.show', $subject) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this subject?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No subjects found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $subjects->links() }}
        </div>
    </div>
</div>
@endsection
