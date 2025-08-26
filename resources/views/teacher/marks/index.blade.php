@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('teacher.partials.sidebar')
        
        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="bi bi-journal-text me-2"></i>
                    {{ $subject->name }} - Marks Management
                    <span class="badge bg-primary">{{ $class->name }}</span>
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('teacher.classes.students', $class->id) }}" 
                           class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Class
                        </a>
                        <button type="button" class="btn btn-sm btn-success" id="saveMarksBtn">
                            <i class="bi bi-save"></i> Save All Changes
                        </button>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-secondary me-2">{{ $currentYear }}</span>
                        <span class="badge bg-info">{{ $currentTerm }}</span>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4" id="statsContainer">
                <!-- Stats will be loaded via AJAX -->
                <div class="col-12 text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading statistics...</p>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Student Marks</h5>
                    <div class="input-group" style="max-width: 300px;">
                        <span class="input-group-text bg-transparent"><i class="bi bi-search"></i></span>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search students...">
                    </div>
                </div>
                <div class="card-body p-0">
                    <form id="marksForm">
                        @csrf
                        <input type="hidden" name="class_id" value="{{ $class->id }}">
                        <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                        <input type="hidden" name="academic_year" value="{{ $currentYear }}">
                        <input type="hidden" name="term" value="{{ $currentTerm }}">
                        
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Roll No.</th>
                                        <th>Student Name</th>
                                        <th class="text-center">Mark (0-100)</th>
                                        <th>Grade</th>
                                        <th>Remarks</th>
                                        <th>Last Updated</th>
                                    </tr>
                                </thead>
                                <tbody id="marksTableBody">
                                    @foreach($students as $index => $student)
                                        @php
                                            $mark = $student->marks->first();
                                            $markValue = $mark ? $mark->mark : null;
                                            $grade = $mark ? $this->calculateGrade($markValue) : 'N/A';
                                            $updatedAt = $mark ? $mark->updated_at->diffForHumans() : 'N/A';
                                        @endphp
                                        <tr class="student-row">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $student->roll_number }}</td>
                                            <td>{{ $student->user->name }}</td>
                                            <td class="mark-cell">
                                                <input type="number" 
                                                       name="marks[{{ $index }}][mark]" 
                                                       class="form-control mark-input" 
                                                       min="0" 
                                                       max="100" 
                                                       step="0.01"
                                                       value="{{ $markValue }}"
                                                       data-student-id="{{ $student->id }}">
                                                <input type="hidden" name="marks[{{ $index }}][student_id]" value="{{ $student->id }}">
                                            </td>
                                            <td class="grade-cell">
                                                <span class="badge {{ $this->getGradeBadgeClass($grade) }}">
                                                    {{ $grade }}
                                                </span>
                                            </td>
                                            <td>
                                                <input type="text" 
                                                       name="marks[{{ $index }}][remarks]" 
                                                       class="form-control form-control-sm" 
                                                       placeholder="Add remarks..."
                                                       value="{{ $mark ? $mark->remarks : '' }}">
                                            </td>
                                            <td class="text-muted small">{{ $updatedAt }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Grade Legend Modal -->
<div class="modal fade" id="gradeLegendModal" tabindex="-1" aria-labelledby="gradeLegendModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gradeLegendModalLabel">Grading System</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Grade</th>
                            <th>Marks Range</th>
                            <th>Grade Point</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge bg-success">A+</span></td>
                            <td>90-100</td>
                            <td>4.0</td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-success">A</span></td>
                            <td>80-89</td>
                            <td>3.6</td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-primary">B+</span></td>
                            <td>70-79</td>
                            <td>3.2</td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-primary">B</span></td>
                            <td>60-69</td>
                            <td>2.8</td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-info">C+</span></td>
                            <td>50-59</td>
                            <td>2.4</td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-warning">C</span></td>
                            <td>40-49</td>
                            <td>2.0</td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-danger">F</span></td>
                            <td>Below 40</td>
                            <td>0.0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Load statistics
        loadStatistics();
        
        // Auto-save when mark changes
        $(document).on('change', '.mark-input', function() {
            const row = $(this).closest('tr');
            const mark = parseFloat($(this).val()) || 0;
            const grade = calculateGrade(mark);
            
            // Update grade display
            row.find('.grade-cell .badge')
                .removeClass('bg-success bg-primary bg-info bg-warning bg-danger')
                .addClass(getGradeBadgeClass(grade))
                .text(grade);
                
            // Mark row as changed
            row.addClass('table-warning');
        });
        
        // Save all marks
        $('#saveMarksBtn').click(function() {
            const $btn = $(this);
            const $form = $('#marksForm');
            
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
            
            $.ajax({
                url: '{{ route("teacher.marks.store") }}',
                method: 'POST',
                data: $form.serialize(),
                success: function(response) {
                    if (response.success) {
                        // Update timestamps
                        $('.mark-input:not([value=""])').each(function() {
                            const row = $(this).closest('tr');
                            row.find('td:last').text('Just now');
                            row.removeClass('table-warning');
                        });
                        
                        showToast('success', 'Success', 'Marks saved successfully!');
                        loadStatistics(); // Refresh stats
                    } else {
                        showToast('error', 'Error', response.message || 'Failed to save marks.');
                    }
                },
                error: function(xhr) {
                    const errorMsg = xhr.responseJSON?.message || 'An error occurred while saving marks.';
                    showToast('error', 'Error', errorMsg);
                },
                complete: function() {
                    $btn.prop('disabled', false).html('<i class="bi bi-save"></i> Save All Changes');
                }
            });
        });
        
        // Search functionality
        $('#searchInput').on('keyup', function() {
            const searchText = $(this).val().toLowerCase();
            
            $('.student-row').each(function() {
                const studentName = $(this).find('td:eq(2)').text().toLowerCase();
                const rollNumber = $(this).find('td:eq(1)').text().toLowerCase();
                
                if (studentName.includes(searchText) || rollNumber.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
        
        // Load statistics
        function loadStatistics() {
            $('#statsContainer').html(`
                <div class="col-12 text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading statistics...</p>
                </div>
            `);
            
            $.get('{{ route("teacher.marks.statistics", [$class->id, $subject->id]) }}', function(response) {
                if (response.success) {
                    const stats = response.data.stats;
                    const gradeDist = response.data.grade_distribution;
                    
                    let gradeDistributionHtml = '';
                    gradeDist.forEach(item => {
                        const percentage = Math.round((item.count / stats.total_students) * 100) || 0;
                        gradeDistributionHtml += `
                            <div class="col-6 col-md-2 mb-3">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <h2 class="mb-0">
                                            <span class="badge ${getGradeBadgeClass(item.grade)} fs-4">
                                                ${item.grade}
                                            </span>
                                        </h2>
                                        <div class="mt-2">
                                            <h4 class="mb-0">${item.count}</h4>
                                            <small class="text-muted">${percentage}%</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    $('#statsContainer').html(`
                        <div class="col-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">Class Statistics</h5>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h6 class="text-muted mb-2">Class Average</h6>
                                                    <h2 class="mb-0">${stats.average_mark ? stats.average_mark.toFixed(2) : 'N/A'}</h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h6 class="text-muted mb-2">Highest Mark</h6>
                                                    <h2 class="mb-0 text-success">${stats.highest_mark || 'N/A'}</h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h6 class="text-muted mb-2">Pass Rate</h6>
                                                    <h2 class="mb-0 text-primary">
                                                        ${stats.total_students > 0 ? Math.round((stats.passed / stats.total_students) * 100) : 0}%
                                                    </h2>
                                                    <small class="text-muted">${stats.passed} of ${stats.total_students} students</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h6 class="text-muted mb-2">Lowest Mark</h6>
                                                    <h2 class="mb-0 text-danger">${stats.lowest_mark || 'N/A'}</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">Grade Distribution</h6>
                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#gradeLegendModal">
                                                <i class="bi bi-info-circle"></i> View Grade Legend
                                            </button>
                                        </div>
                                        <div class="row">
                                            ${gradeDistributionHtml}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                }
            }).fail(function() {
                $('#statsContainer').html(`
                    <div class="col-12">
                        <div class="alert alert-danger">
                            Failed to load statistics. Please try again later.
                        </div>
                    </div>
                `);
            });
        }
        
        // Helper functions
        function calculateGrade(mark) {
            if (mark >= 90) return 'A+';
            if (mark >= 80) return 'A';
            if (mark >= 70) return 'B+';
            if (mark >= 60) return 'B';
            if (mark >= 50) return 'C+';
            if (mark >= 40) return 'C';
            return 'F';
        }
        
        function getGradeBadgeClass(grade) {
            switch(grade) {
                case 'A+':
                case 'A':
                    return 'bg-success';
                case 'B+':
                case 'B':
                    return 'bg-primary';
                case 'C+':
                    return 'bg-info';
                case 'C':
                    return 'bg-warning';
                case 'F':
                    return 'bg-danger';
                default:
                    return 'bg-secondary';
            }
        }
        
        function showToast(type, title, message) {
            const toast = `
                <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <strong>${title}:</strong> ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;
            
            const $toast = $(toast);
            $('#toastContainer').append($toast);
            const bsToast = new bootstrap.Toast($toast[0]);
            bsToast.show();
            
            // Remove toast after it's hidden
            $toast.on('hidden.bs.toast', function() {
                $(this).remove();
            });
        }
    });
</script>
@endpush

@push('styles')
<style>
    .mark-input {
        min-width: 80px;
        text-align: center;
    }
    
    .progress {
        height: 6px;
        margin-top: 5px;
    }
    
    .toast {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1100;
    }
    
    .table-warning {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }
    
    .avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        overflow: hidden;
    }
    
    .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
@endpush

<!-- Toast Container -->
<div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1090;"></div>

@endsection
