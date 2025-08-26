@extends('teacher.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Take Attendance - {{ $class->name }}</h5>
                    <div class="card-tools">
                        <a href="{{ route('teacher.attendance.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
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

                    <form action="{{ route('teacher.attendance.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="class_id" value="{{ $class->id }}">
                        
                        <div class="form-group row mb-3">
                            <label for="date" class="col-sm-2 col-form-label">Date</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                       id="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" required>
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Student Name</th>
                                        <th>Roll Number</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $index => $student)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $student->user->name }}</td>
                                            <td>{{ $student->roll_number }}</td>
                                            <td>
                                                <select name="attendance[{{ $index }}][status]" 
                                                        class="form-control form-control-sm">
                                                    <option value="present">Present</option>
                                                    <option value="absent">Absent</option>
                                                    <option value="late">Late</option>
                                                    <option value="excused">Excused</option>
                                                </select>
                                                <input type="hidden" name="attendance[{{ $index }}][student_id]" value="{{ $student->id }}">
                                            </td>
                                            <td>
                                                <input type="text" name="attendance[{{ $index }}][remarks]" 
                                                       class="form-control form-control-sm" placeholder="Remarks">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group row mb-0 mt-3">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Attendance
                                </button>
                            </div>
                        </div>
                    </form>
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
        document.getElementById('date').max = today;
    });
</script>
@endpush
@endsection
