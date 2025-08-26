@extends('teacher.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Attendance Management</h5>
                    <div class="card-tools">
                        <a href="{{ route('teacher.attendance.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Take Attendance
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

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Class</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($classTeacherAssignments as $index => $assignment)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $assignment->schoolClass->name }}</td>
                                        <td>
                                            <a href="{{ route('teacher.attendance.create', ['class_id' => $assignment->class_id]) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-calendar-plus"></i> Take Attendance
                                            </a>
                                            <a href="{{ route('teacher.attendance.show', ['classId' => $assignment->class_id, 'date' => now()->format('Y-m-d')]) }}" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> View Today
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No classes assigned as class teacher.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
