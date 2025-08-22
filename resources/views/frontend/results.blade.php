@extends('layouts.frontend')

@section('title', 'Check Results')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h2 class="h4 mb-0 text-center">Check Your Results</h2>
                </div>
                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('public.check.result') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="class_id" class="form-label">Select Class</label>
                            <select class="form-select form-select-lg @error('class_id') is-invalid @enderror" 
                                    id="class_id" name="class_id" required>
                                <option value="" selected disabled>-- Select Class --</option>
                                @php
                                    $classes = $classes ?? [];
                                    $classes = is_iterable($classes) ? $classes : [];
                                @endphp
                                @forelse($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @empty
                                    <option value="" disabled>No classes available</option>
                                @endforelse
                            </select>
                            @error('class_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="roll_number" class="form-label">Roll Number</label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('roll_number') is-invalid @enderror" 
                                   id="roll_number" 
                                   name="roll_number" 
                                   placeholder="Enter your roll number" 
                                   value="{{ old('roll_number') }}"
                                   required>
                            @error('roll_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" 
                                   class="form-control form-control-lg @error('dob') is-invalid @enderror" 
                                   id="dob" 
                                   name="dob" 
                                   value="{{ old('dob') }}"
                                   max="{{ date('Y-m-d') }}"
                                   required>
                            @error('dob')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-search me-2"></i> Check Result
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-4 pt-4 border-top text-center">
                        <p class="text-muted mb-2">Having trouble accessing your results?</p>
                        <a href="{{ route('contact') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-envelope me-1"></i> Contact Support
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 text-center">
                <p class="text-muted">
                    <i class="bi bi-info-circle-fill text-primary me-1"></i> 
                    For any discrepancies in your results, please contact the school administration within 7 days of result publication.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
