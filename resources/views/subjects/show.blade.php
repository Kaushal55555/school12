@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Subject Details: {{ $subject->name }}</span>
                    <div>
                        <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Are you sure you want to delete this subject? This action cannot be undone.')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Basic Information</h5>
                            <hr>
                            <p><strong>Subject Name:</strong> {{ $subject->name }}</p>
                            <p><strong>Subject Code:</strong> {{ $subject->code }}</p>
                            <p><strong>Class:</strong> {{ $subject->schoolClass->name }} ({{ $subject->schoolClass->section }})</p>
                            <p><strong>Full Marks:</strong> {{ $subject->full_marks }}</p>
                            <p><strong>Pass Marks:</strong> {{ $subject->pass_marks }}</p>
                            
                            @if($subject->description)
                                <div class="mt-3">
                                    <h5>Description</h5>
                                    <hr>
                                    <p>{{ $subject->description }}</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Statistics</h5>
                            <hr>
                            <p><strong>Total Students Enrolled:</strong> {{ $subject->results_count ?? 0 }}</p>
                            
                            @if($subject->results_count > 0)
                                @php
                                    $passed = $subject->results->where('marks_obtained', '>=', $subject->pass_marks)->count();
                                    $passPercentage = round(($passed / $subject->results_count) * 100, 2);
                                @endphp
                                
                                <p><strong>Students Passed:</strong> {{ $passed }} ({{ $passPercentage }}%)</p>
                                <p><strong>Students Failed:</strong> {{ $subject->results_count - $passed }} ({{ 100 - $passPercentage }}%)</p>
                                
                                <div class="mt-3">
                                    <h6>Grade Distribution</h6>
                                    <div class="progress" style="height: 20px;">
                                        @php
                                            $grades = [
                                                'A+' => 0,
                                                'A' => 0,
                                                'B+' => 0,
                                                'B' => 0,
                                                'C+' => 0,
                                                'C' => 0,
                                                'F' => 0
                                            ];
                                            
                                            foreach($subject->results as $result) {
                                                $grades[$result->grade]++;
                                            }
                                        @endphp
                                        
                                        @foreach($grades as $grade => $count)
                                            @if($count > 0)
                                                @php
                                                    $percentage = ($count / $subject->results_count) * 100;
                                                    $colors = [
                                                        'A+' => 'bg-success',
                                                        'A' => 'bg-info',
                                                        'B+' => 'bg-primary',
                                                        'B' => 'bg-primary',
                                                        'C+' => 'bg-warning',
                                                        'C' => 'bg-warning',
                                                        'F' => 'bg-danger'
                                                    ];
                                                    $color = $colors[$grade] ?? 'bg-secondary';
                                                @endphp
                                                <div class="progress-bar {{ $color }}" role="progressbar" 
                                                     style="width: {{ $percentage }}%" 
                                                     title="{{ $grade }}: {{ $count }} ({{ $percentage }}%)">
                                                    {{ $grade }}: {{ $count }}
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <small class="text-muted">Hover over the bars to see details</small>
                                </div>
                            @else
                                <p class="text-muted">No results available for this subject yet.</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Recent Results</h5>
                        <hr>
                        @if($subject->results_count > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Student</th>
                                            <th>Roll No.</th>
                                            <th>Marks Obtained</th>
                                            <th>Percentage</th>
                                            <th>Grade</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subject->results()->with('student')->latest()->take(5)->get() as $result)
                                            <tr>
                                                <td>{{ $result->student->name }}</td>
                                                <td>{{ $result->student->roll_number }}</td>
                                                <td>{{ $result->marks_obtained }} / {{ $subject->full_marks }}</td>
                                                <td>{{ $result->percentage }}%</td>
                                                <td>
                                                    <span class="badge bg-{{ $result->grade == 'F' ? 'danger' : 'success' }}">
                                                        {{ $result->grade }}
                                                    </span>
                                                </td>
                                                <td>{{ $result->created_at->format('M d, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($subject->results_count > 5)
                                <div class="text-end mt-2">
                                    <a href="#" class="btn btn-sm btn-outline-primary">View All Results</a>
                                </div>
                            @endif
                        @else
                            <p class="text-muted">No results available for this subject yet.</p>
                        @endif
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Back to Subjects</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
