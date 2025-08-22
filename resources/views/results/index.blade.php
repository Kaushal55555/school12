@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Results</h2>
        <a href="{{ route('results.create') }}" class="btn btn-primary">Add New Result</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Search & Filter</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('results.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="class_id" class="form-label">Class</label>
                    <select name="class_id" id="class_id" class="form-select">
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }} ({{ $class->section }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="subject_id" class="form-label">Subject</label>
                    <select name="subject_id" id="subject_id" class="form-select">
                        <option value="">All Subjects</option>
                        @if(isset($subjects) && $subjects->count() > 0)
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="student_id" class="form-label">Student</label>
                    <select name="student_id" id="student_id" class="form-select">
                        <option value="">All Students</option>
                        @if(isset($students) && $students->count() > 0)
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }} ({{ $student->roll_number }})
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('results.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Results</h5>
            @if($results->count() > 0)
                <a href="{{ route('results.print', request()->query()) }}" 
                   class="btn btn-sm btn-outline-primary" 
                   target="_blank">
                    <i class="bi bi-printer"></i> Print Results
                </a>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Subject</th>
                            <th>Marks</th>
                            <th>Grade</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($results as $result)
                            <tr>
                                <td>{{ $result->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($result->student->photo_path)
                                            <img src="{{ asset('storage/' . $result->student->photo_path) }}" 
                                                 alt="{{ $result->student->name }}" 
                                                 class="rounded-circle me-2" 
                                                 width="32" 
                                                 height="32">
                                        @else
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 32px; height: 32px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div>{{ $result->student->name }}</div>
                                            <small class="text-muted">{{ $result->student->roll_number }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $result->schoolClass->name }} ({{ $result->schoolClass->section }})</td>
                                <td>{{ $result->subject->name }}</td>
                                <td>
                                    {{ $result->marks_obtained }} / {{ $result->subject->full_marks }}
                                    <div class="progress mt-1" style="height: 5px;">
                                        @php
                                            $percentage = $result->subject->full_marks > 0 
                                                ? ($result->marks_obtained / $result->subject->full_marks) * 100 
                                                : 0;
                                            $color = $percentage >= 90 ? 'bg-success' : 
                                                    ($percentage >= 70 ? 'bg-info' : 
                                                    ($percentage >= 50 ? 'bg-primary' : 'bg-danger'));
                                        @endphp
                                        <div class="progress-bar {{ $color }}" 
                                             role="progressbar" 
                                             style="width: {{ $percentage }}%" 
                                             aria-valuenow="{{ $percentage }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $result->grade == 'F' ? 'danger' : 'success' }}">
                                        {{ $result->grade }}
                                    </span>
                                </td>
                                <td>{{ $result->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('results.show', $result) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('results.edit', $result) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('results.destroy', $result) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Are you sure you want to delete this result?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No results found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $results->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const classSelect = document.getElementById('class_id');
        const subjectSelect = document.getElementById('subject_id');
        const studentSelect = document.getElementById('student_id');
        const selectedClassId = '{{ request('class_id') }}';
        const selectedSubjectId = '{{ request('subject_id') }}';
        const selectedStudentId = '{{ request('student_id') }}';

        // Function to load subjects for a class
        function loadSubjects(classId) {
            if (!classId) {
                subjectSelect.innerHTML = '<option value="">All Subjects</option>';
                subjectSelect.disabled = false;
                return;
            }

            subjectSelect.innerHTML = '<option value="">Loading subjects...</option>';
            subjectSelect.disabled = true;
            
            fetch(`/get-subjects/${classId}`)
                .then(response => response.json())
                .then(data => {
                    let options = '<option value="">All Subjects</option>';
                    data.forEach(subject => {
                        const selected = subject.id == selectedSubjectId ? 'selected' : '';
                        options += `<option value="${subject.id}" ${selected}>${subject.name}</option>`;
                    });
                    subjectSelect.innerHTML = options;
                    subjectSelect.disabled = false;
                });
        }

        // Function to load students for a class
        function loadStudents(classId) {
            if (!classId) {
                studentSelect.innerHTML = '<option value="">All Students</option>';
                studentSelect.disabled = false;
                return;
            }

            studentSelect.innerHTML = '<option value="">Loading students...</option>';
            studentSelect.disabled = true;
            
            fetch(`/get-students/${classId}`)
                .then(response => response.json())
                .then(data => {
                    let options = '<option value="">All Students</option>';
                    data.forEach(student => {
                        const selected = student.id == selectedStudentId ? 'selected' : '';
                        options += `<option value="${student.id}" ${selected}>${student.name} (${student.roll_number})</option>`;
                    });
                    studentSelect.innerHTML = options;
                    studentSelect.disabled = false;
                });
        }

        // Load initial data if class is already selected
        if (selectedClassId) {
            loadSubjects(selectedClassId);
            loadStudents(selectedClassId);
        }

        // Handle class change
        classSelect.addEventListener('change', function() {
            const classId = this.value;
            loadSubjects(classId);
            loadStudents(classId);
        });
    });
</script>
@endpush
@endsection
