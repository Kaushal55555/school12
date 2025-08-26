@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('teacher.partials.sidebar')
        
        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">{{ $subject->name }} - {{ $class->name }}</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('teacher.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Dashboard
                        </a>
                        <button type="button" class="btn btn-sm btn-success" id="saveAllMarks">
                            <i class="bi bi-save"></i> Save All Changes
                        </button>
                    </div>
                    <span class="me-3">Academic Year: {{ $currentYear }}</span>
                    <span>Term: {{ $currentTerm }}</span>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Subject:</strong> {{ $subject->name }} ({{ $subject->code }})</p>
                            <p><strong>Class:</strong> {{ $class->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Total Students:</strong> {{ $students->count() }}</p>
                            <p><strong>Subject Teacher:</strong> {{ auth()->user()->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @if($students->count() > 0)
                        <div class="table-responsive">
                            <form id="marksForm">
                                @csrf
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Roll No.</th>
                                            <th>Student Name</th>
                                            <th>Marks (0-100)</th>
                                            <th>Grade</th>
                                            <th>Remarks</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $student)
                                            @php
                                                $result = $student->results->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $student->roll_number }}</td>
                                                <td>{{ $student->user->name }}</td>
                                                <td style="width: 150px;">
                                                    <input type="number" 
                                                           class="form-control marks-input" 
                                                           name="marks[{{ $student->id }}]" 
                                                           value="{{ $result->marks ?? '' }}" 
                                                           min="0" 
                                                           max="100"
                                                           data-student-id="{{ $student->id }}">
                                                </td>
                                                <td style="width: 120px;">
                                                    <select class="form-select grade-input" 
                                                            name="grade[{{ $student->id }}]" 
                                                            data-student-id="{{ $student->id }}">
                                                        <option value="">-- Select --</option>
                                                        <option value="A+" {{ ($result->grade ?? '') == 'A+' ? 'selected' : '' }}>A+</option>
                                                        <option value="A" {{ ($result->grade ?? '') == 'A' ? 'selected' : '' }}>A</option>
                                                        <option value="A-" {{ ($result->grade ?? '') == 'A-' ? 'selected' : '' }}>A-</option>
                                                        <option value="B+" {{ ($result->grade ?? '') == 'B+' ? 'selected' : '' }}>B+</option>
                                                        <option value="B" {{ ($result->grade ?? '') == 'B' ? 'selected' : '' }}>B</option>
                                                        <option value="B-" {{ ($result->grade ?? '') == 'B-' ? 'selected' : '' }}>B-</option>
                                                        <option value="C+" {{ ($result->grade ?? '') == 'C+' ? 'selected' : '' }}>C+</option>
                                                        <option value="C" {{ ($result->grade ?? '') == 'C' ? 'selected' : '' }}>C</option>
                                                        <option value="D" {{ ($result->grade ?? '') == 'D' ? 'selected' : '' }}>D</option>
                                                        <option value="F" {{ ($result->grade ?? '') == 'F' ? 'selected' : '' }}>F</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" 
                                                           class="form-control" 
                                                           name="remarks[{{ $student->id }}]" 
                                                           value="{{ $result->remarks ?? '' }}"
                                                           placeholder="Optional">
                                                </td>
                                                <td>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-success save-marks" 
                                                            data-student-id="{{ $student->id }}">
                                                        <i class="bi bi-check-lg"></i> Save
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-info">
                            No students found in this class.
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Loading Spinner -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="saveSuccessToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle me-2"></i> Marks saved successfully!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    
    <div id="saveErrorToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-exclamation-triangle me-2"></i> Failed to save marks. Please try again.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto-calculate grade based on marks
        $(document).on('change', '.marks-input', function() {
            const marks = parseFloat($(this).val());
            const studentId = $(this).data('student-id');
            let grade = '';
            
            if (!isNaN(marks)) {
                if (marks >= 90) grade = 'A+';
                else if (marks >= 80) grade = 'A';
                else if (marks >= 75) grade = 'A-';
                else if (marks >= 70) grade = 'B+';
                else if (marks >= 65) grade = 'B';
                else if (marks >= 60) grade = 'B-';
                else if (marks >= 55) grade = 'C+';
                else if (marks >= 50) grade = 'C';
                else if (marks >= 45) grade = 'D';
                else grade = 'F';
                
                $(`select[name="grade[${studentId}]"]`).val(grade);
            }
        });
        
        // Save individual student marks
        $(document).on('click', '.save-marks', function() {
            const studentId = $(this).data('student-id');
            saveStudentMarks(studentId);
        });
        
        // Save all marks
        $('#saveAllMarks').click(function() {
            const studentIds = [];
            $('.marks-input').each(function() {
                studentIds.push($(this).data('student-id'));
            });
            
            if (studentIds.length > 0) {
                saveAllMarks(studentIds);
            }
        });
        
        function saveStudentMarks(studentId) {
            const marks = $(`input[name="marks[${studentId}]"]`).val();
            const grade = $(`select[name="grade[${studentId}]"]`).val();
            const remarks = $(`input[name="remarks[${studentId}]"]`).val();
            
            saveMarks({
                student_id: studentId,
                marks: marks,
                grade: grade,
                remarks: remarks
            });
        }
        
        function saveAllMarks(studentIds) {
            const marksData = [];
            
            studentIds.forEach(studentId => {
                marksData.push({
                    student_id: studentId,
                    marks: $(`input[name="marks[${studentId}]"]`).val(),
                    grade: $(`select[name="grade[${studentId}]"]`).val(),
                    remarks: $(`input[name="remarks[${studentId}]"]`).val()
                });
            });
            
            // Show loading state
            const saveBtn = $('#saveAllMarks');
            const originalText = saveBtn.html();
            saveBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
            
            // Process each save request sequentially
            let successCount = 0;
            let errorCount = 0;
            
            const processNext = (index) => {
                if (index >= marksData.length) {
                    // All requests completed
                    saveBtn.prop('disabled', false).html(originalText);
                    
                    if (errorCount === 0) {
                        showSuccessToast('All marks saved successfully!');
                    } else if (successCount > 0) {
                        showErrorToast(`Saved ${successCount} records. Failed to save ${errorCount} records.`);
                    } else {
                        showErrorToast('Failed to save marks. Please try again.');
                    }
                    
                    return;
                }
                
                const data = marksData[index];
                
                saveMarks(data, (success) => {
                    if (success) {
                        successCount++;
                    } else {
                        errorCount++;
                    }
                    processNext(index + 1);
                });
            };
            
            // Start processing
            processNext(0);
        }
        
        function saveMarks(data, callback) {
            $.ajax({
                url: '{{ route("teacher.subjects.marks.update", ["class" => $class->id, "subject" => $subject->id]) }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    student_id: data.student_id,
                    marks: data.marks,
                    grade: data.grade,
                    remarks: data.remarks
                },
                success: function(response) {
                    showSuccessToast('Marks saved successfully!');
                    if (typeof callback === 'function') callback(true);
                },
                error: function(xhr) {
                    console.error('Error saving marks:', xhr);
                    showErrorToast('Failed to save marks. Please try again.');
                    if (typeof callback === 'function') callback(false);
                }
            });
        }
        
        function showSuccessToast(message) {
            const toastEl = $('#saveSuccessToast');
            toastEl.find('.toast-body').html(`<i class="bi bi-check-circle me-2"></i> ${message}`);
            const toast = new bootstrap.Toast(toastEl[0]);
            toast.show();
        }
        
        function showErrorToast(message) {
            const toastEl = $('#saveErrorToast');
            toastEl.find('.toast-body').html(`<i class="bi bi-exclamation-triangle me-2"></i> ${message}`);
            const toast = new bootstrap.Toast(toastEl[0]);
            toast.show();
        }
    });
</script>
@endpush

@endsection
