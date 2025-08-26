<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;

class ClassController extends Controller
{
    /**
     * Display a listing of students in the specified class.
     */
    public function students(SchoolClass $class)
    {
        $teacher = Auth::user()->teacher;
        $currentYear = date('Y') . '-' . (date('Y') + 1);
        $currentTerm = 'Term ' . ceil(date('n') / 4);
        
        // Check if teacher is the class teacher
        $isClassTeacher = $teacher->subjectAssignments()
            ->where('class_id', $class->id)
            ->where('is_class_teacher', true)
            ->exists();
            
        // Verify the teacher has access to this class
        $hasAccess = $isClassTeacher || $teacher->subjectAssignments()
            ->where('class_id', $class->id)
            ->exists();
            
        if (!$hasAccess) {
            abort(403, 'You are not authorized to view this class.');
        }
        
        // Get students with attendance data
        $students = $class->students()
            ->with(['user', 'attendance' => function($query) use ($class, $currentYear, $currentTerm) {
                $query->where('class_id', $class->id)
                      ->where('academic_year', $currentYear)
                      ->where('term', $currentTerm);
            }])
            ->orderBy('roll_number')
            ->paginate(20);
            
        // Get subjects taught by this teacher in this class
        $subjects = $class->subjects()
            ->whereHas('subjectAssignments', function($query) use ($teacher, $class) {
                $query->where('teacher_id', $teacher->id)
                      ->where('class_id', $class->id);
            })
            ->get();
            
        return view('teacher.classes.students', [
            'class' => $class,
            'students' => $students,
            'subjects' => $subjects,
            'isClassTeacher' => $isClassTeacher,
            'currentYear' => $currentYear,
            'currentTerm' => $currentTerm
        ]);
    }
    
    /**
     * Export students list to Excel
     */
    public function exportStudents(SchoolClass $class)
    {
        $teacher = Auth::user()->teacher;
        
        // Verify the teacher has access to this class
        $hasAccess = $teacher->subjectAssignments()
            ->where('class_id', $class->id)
            ->exists();
            
        if (!$hasAccess) {
            abort(403, 'You are not authorized to export this class list.');
        }
        
        $filename = 'class_' . $class->name . '_students_' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(new StudentsExport($class), $filename);
    }
    
    /**
     * Show student details
     */
    public function showStudent(SchoolClass $class, Student $student)
    {
        $teacher = Auth::user()->teacher;
        
        // Verify the teacher has access to this class and student
        $hasAccess = $teacher->subjectAssignments()
            ->where('class_id', $class->id)
            ->whereHas('class', function($query) use ($student) {
                $query->whereHas('students', function($q) use ($student) {
                    $q->where('id', $student->id);
                });
            })
            ->exists();
            
        if (!$hasAccess) {
            abort(403, 'You are not authorized to view this student.');
        }
        
        $student->load(['user', 'attendance', 'results.subject']);
        
        return view('teacher.students.show', [
            'class' => $class,
            'student' => $student,
            'subjects' => $class->subjects
        ]);
    }
}
