@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Edit Result - {{ $result->student->name }} - {{ $result->subject->name }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('results.update', $result) }}" id="resultForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Class</label>
                                <input type="text" class="form-control" value="{{ $result->schoolClass->name }} ({{ $result->schoolClass->section }})" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Student</label>
                                <input type="text" class="form-control" value="{{ $result->student->name }} ({{ $result->student->roll_number }})" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Subject</label>
                                <input type="text" class="form-control" value="{{ $result->subject->name }} ({{ $result->subject->code }})" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="marks_obtained" class="form-label">Marks Obtained <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('marks_obtained') is-invalid @enderror" 
                                           id="marks_obtained" name="marks_obtained" 
                                           value="{{ old('marks_obtained', $result->marks_obtained) }}" 
                                           min="0" 
                                           max="{{ $result->subject->full_marks }}"
                                           step="0.01" 
                                           required
                                           oninput="calculateGrade()">
                                    <span class="input-group-text">/ {{ $result->subject->full_marks }}</span>
                                </div>
                                <small class="text-muted">Pass Marks: {{ $result->subject->pass_marks }}</small>
                                @error('marks_obtained')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Grade</label>
                                <div class="form-control">
                                    <span id="gradeBadge" class="badge">{{ $result->grade }}</span>
                                    <span id="percentage" class="ms-2">
                                        @if($result->subject->full_marks > 0)
                                            {{ number_format(($result->marks_obtained / $result->subject->full_marks) * 100, 2) }}%
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Result</label>
                                <div>
                                    <span id="resultBadge" class="badge {{ $result->marks_obtained >= $result->subject->pass_marks ? 'bg-success' : 'bg-danger' }}">
                                        {{ $result->marks_obtained >= $result->subject->pass_marks ? 'PASS' : 'FAIL' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks (Optional)</label>
                            <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                      id="remarks" name="remarks" rows="2">{{ old('remarks', $result->remarks) }}</textarea>
                            @error('remarks')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                            <a href="{{ route('results.show', $result) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to Result
                            </a>
                            <div>
                                <a href="{{ route('results.index') }}" class="btn btn-secondary me-md-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Update Result
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize grade calculation on page load
        calculateGrade();
    });
    
    function calculateGrade() {
        const marksInput = document.getElementById('marks_obtained');
        const fullMarks = {{ $result->subject->full_marks }};
        const passMarks = {{ $result->subject->pass_marks }};
        
        if (!marksInput.value) {
            updateGradeInfo(null, null, null);
            return;
        }
        
        const marksObtained = parseFloat(marksInput.value);
        
        if (isNaN(marksObtained) || isNaN(fullMarks) || fullMarks <= 0) {
            updateGradeInfo(null, null, null);
            return;
        }
        
        const percentage = (marksObtained / fullMarks) * 100;
        const grade = calculateGradeFromPercentage(percentage, passMarks, fullMarks);
        
        updateGradeInfo(grade, percentage, marksObtained >= passMarks);
    }
    
    function calculateGradeFromPercentage(percentage, passMarks, fullMarks) {
        if (percentage >= 90) return 'A+';
        if (percentage >= 80) return 'A';
        if (percentage >= 70) return 'B+';
        if (percentage >= 60) return 'B';
        if (percentage >= 50) return 'C+';
        if (percentage >= 40) return 'C';
        return 'F';
    }
    
    function updateGradeInfo(grade, percentage, isPassed) {
        const gradeBadge = document.getElementById('gradeBadge');
        const percentageSpan = document.getElementById('percentage');
        const resultBadge = document.getElementById('resultBadge');
        
        if (grade && !isNaN(percentage)) {
            // Set grade badge
            gradeBadge.textContent = grade;
            gradeBadge.className = 'badge ' + (grade === 'F' ? 'bg-danger' : 'bg-success');
            
            // Set percentage
            percentageSpan.textContent = percentage.toFixed(2) + '%';
            
            // Set result badge
            resultBadge.textContent = isPassed ? 'PASS' : 'FAIL';
            resultBadge.className = 'badge ' + (isPassed ? 'bg-success' : 'bg-danger');
        }
    }
</script>
@endpush
@endsection
