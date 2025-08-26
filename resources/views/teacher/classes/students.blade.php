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
                    <i class="bi bi-people-fill me-2"></i>
                    {{ $class->name }} - Students
                    <span class="badge bg-primary">{{ $students->total() }} Students</span>
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('teacher.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Dashboard
                        </a>
                        <a href="{{ route('teacher.classes.students.export', $class->id) }}" 
                           class="btn btn-sm btn-success ms-2">
                            <i class="bi bi-file-earmark-excel"></i> Export to Excel
                        </a>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-secondary me-2">{{ $currentYear }}</span>
                        <span class="badge bg-info">{{ $currentTerm }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-1">Total Students</h6>
                                    <h3 class="mb-0">{{ $students->total() }}</h3>
                                </div>
                                <i class="bi bi-people fs-1 opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-1">Subjects Teaching</h6>
                                    <h3 class="mb-0">{{ $subjects->count() }}</h3>
                                </div>
                                <i class="bi bi-book fs-1 opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-1">Class Teacher</h6>
                                    <h5 class="mb-0">{{ $isClassTeacher ? 'Yes' : 'No' }}</h5>
                                </div>
                                <i class="bi bi-person-badge fs-1 opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Student List</h5>
                    <div class="input-group" style="max-width: 300px;">
                        <span class="input-group-text bg-transparent"><i class="bi bi-search"></i></span>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search students...">
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($students->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Roll No.</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Attendance</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $index => $student)
                                        <tr class="student-row">
                                            <td>{{ $index + 1 }}</td>
                                            <td><span class="badge bg-secondary">{{ $student->roll_number }}</span></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-2">
                                                        <img src="{{ $student->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($student->user->name).'&color=7F9CF5&background=EBF4FF' }}" 
                                                             alt="{{ $student->user->name }}" 
                                                             class="rounded-circle" 
                                                             width="32" 
                                                             height="32">
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $student->user->name }}</h6>
                                                        <small class="text-muted">{{ $student->user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <small><i class="bi bi-telephone me-1"></i> {{ $student->phone ?? 'N/A' }}</small>
                                                    <small><i class="bi bi-geo-alt me-1"></i> {{ Str::limit($student->address ?? 'N/A', 30) }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $attendance = $student->attendance->first();
                                                    $present = $attendance ? $attendance->present_days : 0;
                                                    $total = $attendance ? $attendance->total_days : 1;
                                                    $percentage = $total > 0 ? round(($present / $total) * 100) : 0;
                                                @endphp
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                        <div class="progress-bar {{ $percentage >= 75 ? 'bg-success' : ($percentage >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                                                             role="progressbar" 
                                                             style="width: {{ $percentage }}%" 
                                                             aria-valuenow="{{ $percentage }}" 
                                                             aria-valuemin="0" 
                                                             aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">{{ $percentage }}%</small>
                                                </div>
                                                <small class="text-muted d-block mt-1">{{ $present }}/{{ $total }} days</small>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    <a href="#" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       data-bs-toggle="modal" 
                                                       data-bs-target="#studentDetailsModal" 
                                                       data-student-id="{{ $student->id }}"
                                                       data-student-name="{{ $student->user->name }}">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    @if($subjects->count() > 0)
                                                        <a href="#" 
                                                           class="btn btn-sm btn-outline-success mark-attendance"
                                                           data-student-id="{{ $student->id }}"
                                                           data-student-name="{{ $student->user->name }}">
                                                            <i class="bi bi-check2-square"></i>
                                                        </a>
                                                    @endif
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            @foreach($subjects as $subject)
                                                                <li>
                                                                    <a class="dropdown-item" 
                                                                       href="{{ route('teacher.marks.index', ['class' => $class->id, 'subject' => $subject->id]) }}">
                                                                        {{ $subject->name }} Results
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item text-danger" href="#">
                                                                    <i class="bi bi-trash me-2"></i> Remove from Class
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if($students->hasPages())
                            <div class="card-footer bg-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted">
                                        Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} entries
                                    </div>
                                    <div>
                                        {{ $students->links() }}
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                    @else
                        <div class="text-center p-5">
                            <div class="mb-3">
                                <i class="bi bi-people display-1 text-muted"></i>
                            </div>
                            <h5>No students found in this class</h5>
                            <p class="text-muted">Students will appear here once they are added to this class.</p>
                            <a href="#" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Add Students
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Student Details Modal -->
<div class="modal fade" id="studentDetailsModal" tabindex="-1" aria-labelledby="studentDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentDetailsModalLabel">Student Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="studentDetailsContent">
                <!-- Content will be loaded via AJAX -->
                <div class="text-center my-5">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" id="viewFullProfileBtn" class="btn btn-primary">View Full Profile</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Load student details when modal is shown
    document.getElementById('studentDetailsModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const studentId = button.getAttribute('data-student-id');
        const studentName = button.getAttribute('data-student-name');
        const modal = this;
        
        // Update modal title
        modal.querySelector('.modal-title').textContent = 'Student: ' + studentName;
        
        // Update view profile button
        document.getElementById('viewFullProfileBtn').href = '{{ route("students.show", "") }}/' + studentId;
        
        // Load student details via AJAX
        fetch(`/api/students/${studentId}/details`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('studentDetailsContent').innerHTML = `
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <img src="${data.photo_url || '{{ asset('images/default-avatar.png') }}'}" 
                                     class="img-thumbnail rounded-circle" 
                                     alt="${studentName}" 
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                            <h5>${studentName}</h5>
                            <p class="text-muted">${data.roll_number || 'N/A'}</p>
                        </div>
                        <div class="col-md-8">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p><strong>Email:</strong><br>${data.email || 'N/A'}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Phone:</strong><br>${data.phone || 'N/A'}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <p><strong>Address:</strong><br>${data.address || 'N/A'}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h6>Performance Summary</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Subject</th>
                                                    <th>Marks</th>
                                                    <th>Grade</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                ${data.results ? data.results.map(result => `
                                                    <tr>
                                                        <td>${result.subject_name}</td>
                                                        <td>${result.marks || '-'}</td>
                                                        <td>${result.grade || '-'}</td>
                                                        <td>${result.remarks || '-'}</td>
                                                    </tr>
                                                `).join('') : '<tr><td colspan="4" class="text-center">No results available</td></tr>'}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            })
            .catch(error => {
                console.error('Error loading student details:', error);
                document.getElementById('studentDetailsContent').innerHTML = `
                    <div class="alert alert-danger">
                        Failed to load student details. Please try again.
                    </div>
                `;
            });
    });
</script>
@endpush

@endsection
