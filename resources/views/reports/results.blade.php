@extends('layouts.app')

@section('title', 'Result Analysis')
@section('header', 'Result Analysis')

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.25rem 1.5rem;
    }
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    .progress {
        height: 8px;
    }
    .grade-A { background-color: #28a745; color: white; }
    .grade-B { background-color: #17a2b8; color: white; }
    .grade-C { background-color: #ffc107; color: #212529; }
    .grade-D { background-color: #fd7e14; color: white; }
    .grade-F { background-color: #dc3545; color: white; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Filter Results</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.results') }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label for="class_id" class="form-label">Class</label>
                            <select name="class_id" id="class_id" class="form-select" onchange="this.form.submit()">
                                <option value="">All Classes</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="subject_id" class="form-label">Subject</label>
                            <select name="subject_id" id="subject_id" class="form-select" onchange="this.form.submit()" {{ !request('class_id') ? 'disabled' : '' }}>
                                <option value="">All Subjects</option>
                                @if(request('class_id'))
                                    @php $selectedClass = $classes->firstWhere('id', request('class_id')) @endphp
                                    @if($selectedClass && $selectedClass->subjects)
                                        @foreach($selectedClass->subjects as $subject)
                                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                @endif
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="term" class="form-label">Term</label>
                            <select name="term" id="term" class="form-select" onchange="this.form.submit()">
                                <option value="">All Terms</option>
                                <option value="first" {{ request('term') == 'first' ? 'selected' : '' }}>First Term</option>
                                <option value="second" {{ request('term') == 'second' ? 'selected' : '' }}>Second Term</option>
                                <option value="third" {{ request('term') == 'third' ? 'selected' : '' }}>Third Term</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <a href="{{ route('reports.results') }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Result Analysis</h5>
                    <div>
                        <button class="btn btn-sm btn-outline-primary" onclick="window.print()">
                            <i class="bi bi-printer"></i> Print
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(request()->hasAny(['class_id', 'subject_id', 'term']))
                        <div class="p-4 border-bottom">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="text-muted mb-2">Class:</h6>
                                    <p class="mb-0">{{ $classes->firstWhere('id', request('class_id'))->name ?? 'All Classes' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-muted mb-2">Subject:</h6>
                                    <p class="mb-0">
                                        @if(request('subject_id') && isset($classes) && $classes->firstWhere('id', request('class_id')))
                                            @php
                                                $subject = $classes->firstWhere('id', request('class_id'))
                                                    ->subjects->firstWhere('id', request('subject_id'));
                                            @endphp
                                            {{ $subject->name ?? 'All Subjects' }}
                                        @else
                                            All Subjects
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-muted mb-2">Term:</h6>
                                    <p class="mb-0">
                                        @switch(request('term'))
                                            @case('first') First Term @break
                                            @case('second') Second Term @break
                                            @case('third') Third Term @break
                                            @default All Terms
                                        @endswitch
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Student</th>
                                    <th>Roll No.</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Term</th>
                                    <th>Marks</th>
                                    <th>Grade</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($results as $index => $result)
                                    @php
                                        $percentage = ($result->marks / 100) * 100;
                                        $grade = '';
                                        if ($percentage >= 90) $grade = 'A';
                                        elseif ($percentage >= 80) $grade = 'B';
                                        elseif ($percentage >= 70) $grade = 'C';
                                        elseif ($percentage >= 60) $grade = 'D';
                                        else $grade = 'F';
                                    @endphp
                                    <tr>
                                        <td>{{ $results->firstItem() + $index }}</td>
                                        <td>{{ $result->student->name ?? 'N/A' }}</td>
                                        <td>{{ $result->student->roll_number ?? 'N/A' }}</td>
                                        <td>{{ $result->class->name ?? 'N/A' }}</td>
                                        <td>{{ $result->subject->name ?? 'N/A' }}</td>
                                        <td>{{ ucfirst($result->term) }}</td>
                                        <td>{{ $result->marks }} / 100</td>
                                        <td>
                                            <span class="badge grade-{{ $grade }}">
                                                {{ $grade }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                    <div class="progress-bar bg-{{ $grade === 'A' ? 'success' : ($grade === 'B' ? 'info' : ($grade === 'C' ? 'warning' : ($grade === 'D' ? 'orange' : 'danger'))) }}" 
                                                         role="progressbar" style="width: {{ $percentage }}%" 
                                                         aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <span class="text-nowrap">{{ number_format($percentage, 1) }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="bi bi-graph-up display-6 d-block mb-2"></i>
                                                No results found. Try adjusting your filter criteria.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($results->hasPages())
                        <div class="card-footer bg-white">
                            {{ $results->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Update subjects dropdown when class changes
    document.getElementById('class_id').addEventListener('change', function() {
        const classId = this.value;
        const subjectSelect = document.getElementById('subject_id');
        
        if (!classId) {
            subjectSelect.innerHTML = '<option value="">All Subjects</option>';
            subjectSelect.disabled = true;
            return;
        }
        
        // Fetch subjects for the selected class
        fetch(`/get-subjects/${classId}`)
            .then(response => response.json())
            .then(data => {
                let options = '<option value="">All Subjects</option>';
                data.forEach(subject => {
                    options += `<option value="${subject.id}">${subject.name}</option>`;
                });
                subjectSelect.innerHTML = options;
                subjectSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error fetching subjects:', error);
                subjectSelect.innerHTML = '<option value="">Error loading subjects</option>';
            });
    });
    
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush

@endsection
