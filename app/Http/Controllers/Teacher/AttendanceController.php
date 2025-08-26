<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SubjectAssignment;
use App\Models\Student;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the attendance records.
     */
    public function index()
    {
        $teacher = Auth::user()->teacher;
        
        // Get all classes where the teacher is a class teacher
        $classTeacherAssignments = SubjectAssignment::with('schoolClass')
            ->where('teacher_id', $teacher->id)
            ->where('is_class_teacher', true)
            ->get();

        return view('teacher.attendance.index', compact('classTeacherAssignments'));
    }

    /**
     * Show the form for creating a new attendance record.
     */
    public function create()
    {
        $teacher = Auth::user()->teacher;
        
        // Get all classes where the teacher is a class teacher
        $classTeacherAssignments = SubjectAssignment::with('schoolClass')
            ->where('teacher_id', $teacher->id)
            ->where('is_class_teacher', true)
            ->get();

        return view('teacher.attendance.create', compact('classTeacherAssignments'));
    }

    /**
     * Store a newly created attendance record in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.student_id' => 'required|exists:students,id',
            'attendance.*.status' => 'required|in:present,absent,late,excused',
            'attendance.*.remarks' => 'nullable|string|max:255',
        ]);

        $date = Carbon::parse($validated['date']);
        
        // Check if attendance already exists for this class and date
        $existingAttendance = Attendance::where('class_id', $validated['class_id'])
            ->where('date', $date->toDateString())
            ->exists();
            
        if ($existingAttendance) {
            return redirect()->back()
                ->with('error', 'Attendance for this class and date already exists.')
                ->withInput();
        }
        
        // Save attendance records
        foreach ($validated['attendance'] as $attendanceData) {
            Attendance::create([
                'student_id' => $attendanceData['student_id'],
                'class_id' => $validated['class_id'],
                'date' => $date,
                'status' => $attendanceData['status'],
                'remarks' => $attendanceData['remarks'] ?? null,
                'recorded_by' => Auth::id(),
            ]);
        }

        return redirect()->route('teacher.attendance.index')
            ->with('success', 'Attendance recorded successfully.');
    }

    /**
     * Display the specified attendance record.
     */
    public function show($classId, $date)
    {
        $date = Carbon::parse($date);
        
        $attendance = Attendance::with(['student.user', 'recordedBy'])
            ->where('class_id', $classId)
            ->where('date', $date->toDateString())
            ->get();
            
        if ($attendance->isEmpty()) {
            return redirect()->route('teacher.attendance.index')
                ->with('error', 'No attendance records found for the selected date.');
        }
        
        return view('teacher.attendance.show', [
            'attendance' => $attendance,
            'date' => $date->format('Y-m-d'),
            'className' => $attendance->first()->class->name ?? 'Unknown Class'
        ]);
    }
}
