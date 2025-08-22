@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Class Details</span>
                        <div>
                            <a href="{{ route('classes.edit', $class) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('classes.destroy', $class) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <h4>{{ $class->name }} @if($class->section) - Section {{ $class->section }} @endif</h4>
                        @if($class->description)
                            <p class="text-muted">{{ $class->description }}</p>
                        @endif
                    </div>

                    <div class="mt-4">
                        <h5>Class Information</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Created:</strong> {{ $class->created_at->format('M d, Y') }}</p>
                                <p><strong>Last Updated:</strong> {{ $class->updated_at->diffForHumans() }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Students:</strong> {{ $class->students->count() }}</p>
                                <p><strong>Subjects:</strong> {{ $class->subjects->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('classes.index') }}" class="btn btn-secondary">Back to Classes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection