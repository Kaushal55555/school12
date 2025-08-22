@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Subject: {{ $subject->name }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('subjects.update', $subject) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Subject Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $subject->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="code" class="form-label">Subject Code</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                       id="code" name="code" value="{{ old('code', $subject->code) }}" required>
                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="class_id" class="form-label">Class</label>
                                <select class="form-select @error('class_id') is-invalid @enderror" 
                                        id="class_id" name="class_id" required>
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" 
                                            {{ old('class_id', $subject->class_id) == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }} ({{ $class->section }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="full_marks" class="form-label">Full Marks</label>
                                <input type="number" class="form-control @error('full_marks') is-invalid @enderror" 
                                       id="full_marks" name="full_marks" 
                                       value="{{ old('full_marks', $subject->full_marks) }}" required>
                                @error('full_marks')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="pass_marks" class="form-label">Pass Marks</label>
                                <input type="number" class="form-control @error('pass_marks') is-invalid @enderror" 
                                       id="pass_marks" name="pass_marks" 
                                       value="{{ old('pass_marks', $subject->pass_marks) }}" required>
                                @error('pass_marks')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description (Optional)</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $subject->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('subjects.index') }}" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Subject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Client-side validation for pass marks not exceeding full marks
    document.addEventListener('DOMContentLoaded', function() {
        const fullMarksInput = document.getElementById('full_marks');
        const passMarksInput = document.getElementById('pass_marks');

        function validateMarks() {
            const fullMarks = parseInt(fullMarksInput.value) || 0;
            const passMarks = parseInt(passMarksInput.value) || 0;

            if (passMarks > fullMarks) {
                passMarksInput.setCustomValidity('Pass marks cannot be greater than full marks');
            } else {
                passMarksInput.setCustomValidity('');
            }
        }

        fullMarksInput.addEventListener('change', validateMarks);
        passMarksInput.addEventListener('input', validateMarks);
    });
</script>
@endpush
@endsection
