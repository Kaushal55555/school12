@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('teacher.partials.sidebar')
        
        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Welcome, {{ Auth::user()->name }}!</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <span class="me-3"><i class="bi bi-calendar-check"></i> Academic Year: {{ $currentYear }}</span>
                    <span><i class="bi bi-journal-text"></i> Term: {{ $currentTerm }}</span>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Assigned Classes</h5>
                            <p class="display-6">{{ $classTeacherAssignments->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Subjects Teaching</h5>
                            <p class="display-6">{{ $assignments->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <h5 class="card-title">Total Students</h5>
                            <p class="display-6">{{ $totalStudents ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Class Teacher Sections -->
            @if($classTeacherAssignments->count() > 0)
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>My Class Responsibilities</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Class</th>
                                                <th>Class Teacher</th>
                                                <th>Total Students</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($classTeacherAssignments as $assignment)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $assignment->schoolClass->name }}</strong>
                                                        <div class="text-muted small">Section: {{ $assignment->schoolClass->section ?? 'N/A' }}</div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-primary">You</span>
                                                    </td>
                                                    <td>{{ $assignment->schoolClass->students_count ?? 0 }} Students</td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <a href="{{ route('teacher.class.students', ['class' => $assignment->class_id]) }}" 
                                                               class="btn btn-outline-primary"
                                                               data-bs-toggle="tooltip" 
                                                               title="View Students">
                                                                <i class="bi bi-people"></i> Students
                                                            </a>
                                                            <a href="{{ route('teacher.attendance.class', ['class' => $assignment->class_id]) }}" 
                                                               class="btn btn-outline-success"
                                                               data-bs-toggle="tooltip" 
                                                               title="Take Attendance">
                                                                <i class="bi bi-clipboard-check"></i> Attendance
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Subject Assignments -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-book-half me-2"></i>My Teaching Subjects</h5>
                        </div>
                        <div class="card-body">
                            @if($assignments->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Subject</th>
                                                <th>Class</th>
                                                <th>Schedule</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($assignments as $assignment)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $assignment->subject->name ?? 'N/A' }}</strong>
                                                        <div class="text-muted small">Code: {{ $assignment->subject->code ?? 'N/A' }}</div>
                                                    </td>
                                                    <td>{{ $assignment->schoolClass->name }}</td>
                                                    <td>Mon, Wed, Fri<br><small class="text-muted">10:00 AM - 11:00 AM</small></td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <a href="{{ route('teacher.subjects.students', [
                                                                'class' => $assignment->class_id,
                                                                'subject' => $assignment->subject_id
                                                            ]) }}" 
                                                               class="btn btn-outline-primary"
                                                               data-bs-toggle="tooltip" 
                                                               title="Manage Marks">
                                                                <i class="bi bi-journal-text"></i> Marks
                                                            </a>
                                                            <a href="{{ route('teacher.attendance.create', [
                                                                'class_id' => $assignment->class_id,
                                                                'subject_id' => $assignment->subject_id
                                                            ]) }}" 
                                                               class="btn btn-outline-success"
                                                               data-bs-toggle="tooltip" 
                                                               title="Take Attendance">
                                                                <i class="bi bi-clipboard-check"></i> Attendance
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    You don't have any assigned subjects for the current term.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
