@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Subject Assignment</h1>
        <a href="{{ route('subject-assignments.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to List
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @include('subject-assignments.form')
        </div>
    </div>
</div>
@endsection
