@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New Result</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('results.store') }}" id="resultForm">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="class_id" class="form-label">Class <span class="text-danger">*</span></label>
                                <select name="class_id" id="class_id" class="form-select @error('class_id') is-invalid @enderror" required>
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
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
                                <label for="student_id" class="form-label">Student <span class="text-danger">*</span></label>
                                <select name="student_id" id="student_id" class="form-select @error('student_id') is-invalid @enderror {{ !old('class_id') ? 'disabled-select' : '' }}" required {{ !old('class_id') ? 'disabled' : '' }}>
                                    <option value="">Select Student</option>
                                    <option value="" disabled {{ !old('class_id') ? 'selected' : '' }}>{{ !old('class_id') ? '← Please select a class first' : 'Select a student' }}</option>
                                    @if(old('class_id') && $students->count() > 0)
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                                {{ $student->name }} ({{ $student->roll_number }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('student_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="subject_id" class="form-label">Subject <span class="text-danger">*</span></label>
                                <select name="subject_id" id="subject_id" class="form-select @error('subject_id') is-invalid @enderror {{ !old('class_id') ? 'disabled-select' : '' }}" required {{ !old('class_id') ? 'disabled' : '' }}>
                                    <option value="">Select Subject</option>
                                    <option value="" disabled {{ !old('class_id') ? 'selected' : '' }}>{{ !old('class_id') ? '← Please select a class first' : 'Select a subject' }}</option>
                                    @if(old('class_id') && $subjects->count() > 0)
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }} data-full-marks="{{ $subject->full_marks }}" data-pass-marks="{{ $subject->pass_marks }}">
                                                {{ $subject->name }} ({{ $subject->code }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('subject_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="marks_obtained" class="form-label">Marks Obtained <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('marks_obtained') is-invalid @enderror" 
                                           id="marks_obtained" name="marks_obtained" 
                                           value="{{ old('marks_obtained') }}" 
                                           min="0" 
                                           step="0.01" 
                                           required
                                           {{ !old('subject_id') ? 'disabled' : '' }}
                                           oninput="calculateGrade()"
                                           placeholder="{{ !old('subject_id') ? 'Select a subject first' : 'Enter marks' }}"
                                           class="{{ !old('subject_id') ? 'disabled-input' : '' }}">
                                    <span class="input-group-text">/ <span id="fullMarks">0</span></span>
                                </div>
                                <small class="text-muted">Pass Marks: <span id="passMarks">0</span></small>
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
                                    <span id="gradeBadge" class="badge">N/A</span>
                                    <span id="percentage" class="ms-2">0%</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Result</label>
                                <div>
                                    <span id="resultBadge" class="badge bg-secondary">-</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="term" class="form-label">Term <span class="text-danger">*</span></label>
                                <select name="term" id="term" class="form-select @error('term') is-invalid @enderror" required>
                                    <option value="">Select Term</option>
                                    <option value="First Term" {{ old('term') == 'First Term' ? 'selected' : '' }}>First Term</option>
                                    <option value="Second Term" {{ old('term') == 'Second Term' ? 'selected' : '' }}>Second Term</option>
                                    <option value="Third Term" {{ old('term') == 'Third Term' ? 'selected' : '' }}>Third Term</option>
                                </select>
                                @error('term')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="academic_year" class="form-label">Academic Year <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('academic_year') is-invalid @enderror" 
                                       id="academic_year" name="academic_year" 
                                       value="{{ old('academic_year', date('Y')) }}" 
                                       required min="2000" max="2100">
                                @error('academic_year')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks (Optional)</label>
                            <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                      id="remarks" name="remarks" rows="2">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('results.index') }}" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Result</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .disabled-select {
        background-color: #f8f9fa;
        color: #6c757d;
        cursor: not-allowed;
        opacity: 0.8;
    }
    .disabled-input {
        background-color: #f8f9fa !important;
        color: #6c757d;
        cursor: not-allowed;
        opacity: 0.8;
    }
    .form-select:disabled, .form-control:disabled {
        background-color: #f8f9fa !important;
        cursor: not-allowed;
    }
    .form-select option:disabled {
        color: #6c757d;
        font-style: italic;
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show success message if exists
        @if(session('success'))
            const successAlert = `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            document.querySelector('.card-body').insertAdjacentHTML('afterbegin', successAlert);
        @endif
        
        // Show error message if exists
        @if($errors->any())
            const errorAlert = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            document.querySelector('.card-body').insertAdjacentHTML('afterbegin', errorAlert);
        @endif
        
        // Clear form if needed
        @if(session('clear_form') && !$errors->any())
            document.getElementById('resultForm').reset();
            // Reset grade badge and other UI elements
            document.getElementById('gradeBadge').textContent = 'N/A';
            document.getElementById('gradeBadge').className = 'badge bg-secondary';
            document.getElementById('fullMarks').textContent = '0';
            document.getElementById('passMarks').textContent = '0';
        @endif
        
        // Initialize form state
        const classSelect = document.getElementById('class_id');
        const studentSelect = document.getElementById('student_id');
        const subjectSelect = document.getElementById('subject_id');
        const marksInput = document.getElementById('marks_obtained');
        
        // Disable dependent fields initially
        if (studentSelect) studentSelect.disabled = true;
        if (subjectSelect) subjectSelect.disabled = true;
        if (marksInput) marksInput.disabled = true;
        
        // Reset UI elements
        const fullMarksEl = document.getElementById('fullMarks');
        const passMarksEl = document.getElementById('passMarks');
        const gradeBadgeEl = document.getElementById('gradeBadge');
        const percentageEl = document.getElementById('percentage');
        
        if (fullMarksEl) fullMarksEl.textContent = '0';
        if (passMarksEl) passMarksEl.textContent = '0';
        if (gradeBadgeEl) gradeBadgeEl.textContent = 'N/A';
        if (percentageEl) percentageEl.textContent = '0%';
        
        // Load students and subjects when class changes
        classSelect.addEventListener('change', function() {
            const classId = this.value;
            
            // Reset and disable dependent fields
            studentSelect.innerHTML = '<option value="">Loading students...</option>';
            subjectSelect.innerHTML = '<option value="">Loading subjects...</option>';
            studentSelect.disabled = true;
            subjectSelect.disabled = true;
            marksInput.disabled = true;
            
            if (classId) {
                // Load students for the selected class
                fetch(`/get-students/${classId}`)
                    .then(response => response.json())
                    .then(data => {
                        let options = '<option value="">Select Student</option>';
                        data.forEach(student => {
                            options += `<option value="${student.id}">${student.name} (${student.roll_number})</option>`;
                        });
                        studentSelect.innerHTML = options;
                        studentSelect.disabled = false;
                        
                        // Re-select previously selected student if any
                        if ('{{ old('student_id') }}') {
                            studentSelect.value = '{{ old('student_id') }}';
                        }
                    });
                
                // Load subjects for the selected class
                fetch(`/get-subjects/${classId}`)
                    .then(response => response.json())
                    .then(data => {
                        let options = '<option value="">Select Subject</option>';
                        data.forEach(subject => {
                            const selected = '{{ old('subject_id') }}' == subject.id ? 'selected' : '';
                            options += `
                                <option value="${subject.id}" 
                                        data-full-marks="${subject.full_marks}" 
                                        data-pass-marks="${subject.pass_marks}"
                                        ${selected}>
                                    ${subject.name} (${subject.code})
                                </option>`;
                        });
                        subjectSelect.innerHTML = options;
                        subjectSelect.disabled = false;
                        
                        // Update full marks and pass marks display
                        updateMarksInfo();
                    });
            } else {
                // Reset to default if no class is selected
                studentSelect.innerHTML = '<option value="">Select Student</option>';
                subjectSelect.innerHTML = '<option value="">Select Subject</option>';
                studentSelect.disabled = true;
                subjectSelect.disabled = true;
                marksInput.disabled = true;
                
                // Reset marks info
                document.getElementById('fullMarks').textContent = '0';
                document.getElementById('passMarks').textContent = '0';
            }
        });
        
        // Enable/disable marks input based on subject selection
        subjectSelect.addEventListener('change', function() {
            updateMarksInfo();
            
            if (this.value) {
                marksInput.disabled = false;
                marksInput.max = this.options[this.selectedIndex].dataset.fullMarks;
                
                // Check if result already exists for this student and subject
                const studentId = studentSelect.value;
                const subjectId = this.value;
                
                if (studentId && subjectId) {
                    checkExistingResult(studentId, subjectId);
                }
            } else {
                marksInput.disabled = true;
                marksInput.value = '';
                updateGradeInfo(null, null, null);
            }
        });
        
        // Check for existing result when student changes
        studentSelect.addEventListener('change', function() {
            const studentId = this.value;
            const subjectId = subjectSelect.value;
            
            if (studentId && subjectId) {
                checkExistingResult(studentId, subjectId);
            }
        });
        
        // Cache form elements
        const resultForm = document.getElementById('resultForm');
        const studentIdInput = document.getElementById('student_id');
        const subjectIdInput = document.getElementById('subject_id');
        let isChecking = false;
        
        // Handle form submission
        resultForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const studentId = studentIdInput.value;
            const subjectId = subjectIdInput.value;
            
            if (!studentId || !subjectId) {
                return;
            }
            
            // Prevent multiple simultaneous submissions
            if (isChecking) return;
            isChecking = true;
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
            
            try {
                // Check if result exists first
                const response = await fetch(`/results/check-existing?student_id=${studentId}&subject_id=${subjectId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const data = await response.json();
                
                if (data.exists) {
                    // Show warning for existing result
                    const warningDiv = document.createElement('div');
                    warningDiv.className = 'alert alert-warning mt-3';
                    warningDiv.innerHTML = `
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        A result already exists for this student and subject combination.
                        <a href="${data.edit_url}" class="alert-link">View/Edit existing result</a>
                    `;
                    
                    // Remove any existing warnings
                    const existingWarning = document.querySelector('.alert-warning');
                    if (existingWarning) {
                        existingWarning.remove();
                    }
                    
                    // Insert the warning after the form
                    resultForm.parentNode.insertBefore(warningDiv, resultForm.nextSibling);
                    
                    if (confirm('A result already exists for this student and subject. Do you want to update it?')) {
                        // Submit the form if user confirms
                        this.submit();
                    } else {
                        // Reset button state if user cancels
                        resetSubmitButton(submitBtn, originalBtnText);
                    }
                } else {
                    // No existing result, submit the form
                    this.submit();
                }
            } catch (error) {
                console.error('Error checking existing result:', error);
                // If there's an error checking, just submit the form
                this.submit();
            } finally {
                isChecking = false;
            }
        });
        
        // Helper function to reset submit button
        function resetSubmitButton(button, originalHtml) {
            button.disabled = false;
            button.innerHTML = originalHtml;
        }
        
        // Initialize form if there are old inputs
        if ('{{ old('class_id') }}') {
            classSelect.dispatchEvent(new Event('change'));
        }
    });
    
    function updateMarksInfo() {
        const subjectSelect = document.getElementById('subject_id');
        const selectedOption = subjectSelect.options[subjectSelect.selectedIndex];
        
        if (selectedOption && selectedOption.value) {
            const fullMarks = selectedOption.dataset.fullMarks;
            const passMarks = selectedOption.dataset.passMarks;
            
            document.getElementById('fullMarks').textContent = fullMarks;
            document.getElementById('passMarks').textContent = passMarks;
            
            // Update max attribute of marks input
            const marksInput = document.getElementById('marks_obtained');
            marksInput.max = fullMarks;
            
            // Recalculate grade if marks are already entered
            if (marksInput.value) {
                calculateGrade();
            }
        } else {
            document.getElementById('fullMarks').textContent = '0';
            document.getElementById('passMarks').textContent = '0';
            document.getElementById('marks_obtained').disabled = true;
        }
    }
    
    function calculateGrade() {
        const marksInput = document.getElementById('marks_obtained');
        const subjectSelect = document.getElementById('subject_id');
        const selectedOption = subjectSelect.options[subjectSelect.selectedIndex];
        
        if (!selectedOption || !selectedOption.value || !marksInput.value) {
            updateGradeInfo(null, null, null);
            return;
        }
        
        const fullMarks = parseFloat(selectedOption.dataset.fullMarks);
        const passMarks = parseFloat(selectedOption.dataset.passMarks);
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
        } else {
            // Reset all
            gradeBadge.textContent = 'N/A';
            gradeBadge.className = 'badge bg-secondary';
            percentageSpan.textContent = '0%';
            resultBadge.textContent = '-';
            resultBadge.className = 'badge bg-secondary';
        }
    }
    
    // Function to check if a result exists (kept for backward compatibility)
    function checkExistingResult(studentId, subjectId, form, submitBtn = null, originalBtnText = '') {
        // This function is now a wrapper around the new form submission logic
        if (form) {
            form.dispatchEvent(new Event('submit'));
        }
    }
</script>
@endpush
@endsection
