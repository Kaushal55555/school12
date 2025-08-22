@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Result Details</span>
                    <div>
                        <a href="{{ route('results.edit', $result) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <form action="{{ route('results.destroy', $result) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Are you sure you want to delete this result? This action cannot be undone.')">
                                <i class="fas fa-trash-alt me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Student Information</h5>
                            <hr>
                            <div class="d-flex align-items-center mb-3">
                                @if($result->student->photo_path)
                                    <img src="{{ asset('storage/' . $result->student->photo_path) }}" 
                                         alt="{{ $result->student->name }}" 
                                         class="rounded-circle me-3" 
                                         width="80" 
                                         height="80">
                                @else
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 80px; height: 80px;">
                                        <i class="fas fa-user text-white" style="font-size: 2rem;"></i>
                                    </div>
                                @endif
                                <div>
                                    <h4 class="mb-1">{{ $result->student->name }}</h4>
                                    <p class="mb-1">Roll No: {{ $result->student->roll_number }}</p>
                                    <p class="mb-0">{{ $result->schoolClass->name }} ({{ $result->schoolClass->section }})</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Result Summary</h5>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <p class="mb-2"><strong>Subject:</strong></p>
                                    <p class="mb-2"><strong>Subject Code:</strong></p>
                                    <p class="mb-2"><strong>Exam Date:</strong></p>
                                    <p class="mb-2"><strong>Status:</strong></p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-2">{{ $result->subject->name }}</p>
                                    <p class="mb-2">{{ $result->subject->code }}</p>
                                    <p class="mb-2">{{ $result->created_at->format('M d, Y') }}</p>
                                    <p class="mb-2">
                                        <span class="badge {{ $result->marks_obtained >= $result->subject->pass_marks ? 'bg-success' : 'bg-danger' }}">
                                            {{ $result->marks_obtained >= $result->subject->pass_marks ? 'PASSED' : 'FAILED' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <h5>Marks Details</h5>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Subject</th>
                                            <th>Marks Obtained</th>
                                            <th>Full Marks</th>
                                            <th>Pass Marks</th>
                                            <th>Percentage</th>
                                            <th>Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $result->subject->name }}</td>
                                            <td>{{ $result->marks_obtained }}</td>
                                            <td>{{ $result->subject->full_marks }}</td>
                                            <td>{{ $result->subject->pass_marks }}</td>
                                            <td>{{ $result->subject->full_marks > 0 ? number_format(($result->marks_obtained / $result->subject->full_marks) * 100, 2) . '%' : 'N/A' }}</td>
                                            <td>
                                                <span class="badge {{ $result->grade == 'F' ? 'bg-danger' : 'bg-success' }}">
                                                    {{ $result->grade }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if($result->remarks)
                        <div class="mb-4">
                            <h5>Remarks</h5>
                            <hr>
                            <div class="p-3 bg-light rounded">
                                {{ $result->remarks }}
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-grid">
                                <a href="{{ route('students.show', $result->student) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-user-graduate me-1"></i> View Student Profile
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-grid">
                                <a href="{{ route('students.show', $result->student) }}" class="btn btn-outline-info">
                                    <i class="fas fa-list-alt me-1"></i> View Student's Results
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-muted">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small>Created: {{ $result->created_at->format('M d, Y h:i A') }}</small>
                        </div>
                        <div>
                            <small>Last Updated: {{ $result->updated_at->format('M d, Y h:i A') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Add any necessary JavaScript here
    document.addEventListener('DOMContentLoaded', function() {
        // Print functionality
        document.getElementById('printResult').addEventListener('click', function() {
            window.print();
        });
    });
</script>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .card, .card * {
            visibility: visible;
        }
        .card {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none;
        }
        .card-header, .card-footer {
            display: none;
        }
        .no-print {
            display: none !important;
        }
    }
</style>
@endpush
@endsection
