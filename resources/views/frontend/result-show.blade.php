@extends('layouts.frontend')

@section('title', 'Your Results')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Result Card -->
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="h4 mb-0">Academic Results</h2>
                        <button onclick="window.print()" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-printer me-1"></i> Print
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    @php
                        $firstResult = $results->first();
                        $totalMarks = 0;
                        $obtainedMarks = 0;
                        $totalSubjects = $results->count();
                    @endphp
                    
                    <!-- Student Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Name:</strong> {{ $firstResult->student->name }}</p>
                            <p class="mb-1"><strong>Roll No:</strong> {{ $firstResult->student->roll_number }}</p>
                            <p class="mb-0"><strong>Class:</strong> {{ $firstResult->schoolClass->name }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="mb-1"><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($firstResult->student->dob)->format('d/m/Y') }}</p>
                            <p class="mb-0"><strong>Academic Year:</strong> {{ date('Y') }}-{{ date('Y') + 1 }}</p>
                        </div>
                    </div>
                    
                    <!-- Results Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Subject</th>
                                    <th class="text-center">Full Marks</th>
                                    <th class="text-center">Pass Marks</th>
                                    <th class="text-center">Obtained Marks</th>
                                    <th class="text-center">Grade</th>
                                    <th class="text-center">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results as $result)
                                    @php
                                        $totalMarks += 100; // Assuming full marks is 100 for each subject
                                        $obtainedMarks += $result->marks_obtained;
                                    @endphp
                                    <tr>
                                        <td>{{ $result->subject->name }}</td>
                                        <td class="text-center">100</td>
                                        <td class="text-center">40</td>
                                        <td class="text-center">{{ $result->marks_obtained }}</td>
                                        <td class="text-center">{{ $result->grade }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $result->marks_obtained >= 40 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $result->marks_obtained >= 40 ? 'Pass' : 'Fail' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                @php
                                    $percentage = ($obtainedMarks * 100) / ($totalSubjects * 100);
                                    $overallGrade = '';
                                    $overallRemarks = '';
                                    
                                    if ($percentage >= 90) {
                                        $overallGrade = 'A+';
                                        $overallRemarks = 'Outstanding';
                                    } elseif ($percentage >= 80) {
                                        $overallGrade = 'A';
                                        $overallRemarks = 'Excellent';
                                    } elseif ($percentage >= 70) {
                                        $overallGrade = 'B+';
                                        $overallRemarks = 'Very Good';
                                    } elseif ($percentage >= 60) {
                                        $overallGrade = 'B';
                                        $overallRemarks = 'Good';
                                    } elseif ($percentage >= 50) {
                                        $overallGrade = 'C+';
                                        $overallRemarks = 'Satisfactory';
                                    } elseif ($percentage >= 40) {
                                        $overallGrade = 'C';
                                        $overallRemarks = 'Pass';
                                    } else {
                                        $overallGrade = 'F';
                                        $overallRemarks = 'Fail';
                                    }
                                @endphp
                                <tr>
                                    <th colspan="3" class="text-end">Total</th>
                                    <th class="text-center">{{ $obtainedMarks }}/{{ $totalMarks }}</th>
                                    <th class="text-center">{{ $overallGrade }}</th>
                                    <th class="text-center">{{ $overallRemarks }}</th>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-end">Percentage:</th>
                                    <td colspan="4">{{ number_format($percentage, 2) }}%</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <!-- Result Summary -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Performance Summary</h5>
                                    <div class="progress mb-3" style="height: 25px;">
                                        <div class="progress-bar bg-{{ $percentage >= 40 ? 'success' : 'danger' }}" 
                                             role="progressbar" 
                                             style="width: {{ $percentage }}%" 
                                             aria-valuenow="{{ $percentage }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                            {{ number_format($percentage, 1) }}%
                                        </div>
                                    </div>
                                    <p class="mb-1"><strong>Overall Grade:</strong> {{ $overallGrade }}</p>
                                    <p class="mb-1"><strong>Remarks:</strong> {{ $overallRemarks }}</p>
                                    <p class="mb-0"><strong>Position in Class:</strong> {{ $results->first()->position_in_class ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Teacher's Remarks</h5>
                                    <p class="mb-0">
                                        {{ $overallRemarks }} performance. 
                                        @if($percentage >= 70)
                                            Keep up the excellent work!
                                        @elseif($percentage >= 50)
                                            Good effort, but there's room for improvement.
                                        @else
                                            Please work harder and seek help if needed.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white text-center py-3">
                    <p class="mb-0 text-muted">
                        <i class="bi bi-info-circle-fill text-primary me-1"></i>
                        This is a computer-generated result. For any discrepancies, please contact the school administration within 7 days.
                    </p>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="d-flex justify-content-between mb-5">
                <a href="{{ route('public.results') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Search
                </a>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="bi bi-printer me-1"></i> Print Result
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
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
            border: none !important;
            box-shadow: none !important;
        }
        .btn {
            display: none !important;
        }
        @page {
            size: A4;
            margin: 0;
        }
    }
</style>
@endpush
