@extends('teacher.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Attendance Records - {{ $className }} ({{ \Carbon\Carbon::parse($date)->format('M d, Y') }})</h5>
                    <div class="card-tools">
                        <a href="{{ route('teacher.attendance.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <a href="{{ route('teacher.attendance.create', ['class_id' => $classId]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Take New Attendance
                        </a>
                    </div>
                </div>
                <div class="card-body">
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

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ route('teacher.attendance.show', ['classId' => $classId, 'date' => '']) }}" method="GET" class="form-inline">
                                <div class="input-group">
                                    <input type="date" name="date" class="form-control" value="{{ $date }}" required>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">View</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if($attendance->isEmpty())
                        <div class="alert alert-info">
                            No attendance records found for the selected date.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Student Name</th>
                                        <th>Roll Number</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Recorded By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendance as $record)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $record->student->user->name }}</td>
                                            <td>{{ $record->student->roll_number }}</td>
                                            <td>
                                                @php
                                                    $statusClass = [
                                                        'present' => 'success',
                                                        'absent' => 'danger',
                                                        'late' => 'warning',
                                                        'excused' => 'info'
                                                    ][$record->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $statusClass }}">
                                                    {{ ucfirst($record->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $record->remarks ?? '-' }}</td>
                                            <td>{{ $record->recordedBy->name ?? 'System' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set the max date to today
        const today = new Date().toISOString().split('T')[0];
        document.querySelector('input[name="date"]').max = today;
    });
</script>
@endpush
@endsection
