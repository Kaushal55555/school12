<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function students(SchoolClass $class, Subject $subject)
    {
        $teacher = Auth::user()->teacher;
        $currentYear = date('Y');
        $currentTerm = ceil(date('n') / 4);
        
        // Verify the teacher is assigned to teach this subject for this class
        $isAssigned = $teacher->subjectAssignments()
            ->where('class_id', $class->id)
            ->where('subject_id', $subject->id)
            ->where('academic_year', $currentYear)
            ->where('term', $currentTerm)
            ->exists();
            
        if (!$isAssigned) {
            abort(403, 'You are not authorized to access this subject.');
        }
        
        $students = $class->students()
            ->with(['results' => function($query) use ($subject, $currentYear, $currentTerm) {
                $query->where('subject_id', $subject->id)
                      ->where('academic_year', $currentYear)
                      ->where('term', $currentTerm);
            }])
            ->orderBy('roll_number')
            ->get();
            
        return view('teacher.subjects.students', [
            'class' => $class,
            'subject' => $subject,
            'students' => $students,
            'currentYear' => $currentYear,
            'currentTerm' => $currentTerm
        ]);
    }
    
    public function updateMarks(Request $request, SchoolClass $class, Subject $subject)
    {
        $teacher = Auth::user()->teacher;
        $currentYear = date('Y');
        $currentTerm = ceil(date('n') / 4);
        
        // Verify the teacher is assigned to teach this subject for this class
        $isAssigned = $teacher->subjectAssignments()
            ->where('class_id', $class->id)
            ->where('subject_id', $subject->id)
            ->where('academic_year', $currentYear)
            ->where('term', $currentTerm)
            ->exists();
            
        if (!$isAssigned) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update marks for this subject.'
            ], 403);
        }
        
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'marks' => 'required|numeric|min:0|max:100',
            'grade' => 'required|string|max:2',
            'remarks' => 'nullable|string|max:255',
        ]);
        
        try {
            DB::beginTransaction();
            
            Result::updateOrCreate(
                [
                    'student_id' => $validated['student_id'],
                    'subject_id' => $subject->id,
                    'academic_year' => $currentYear,
                    'term' => $currentTerm,
                ],
                [
                    'marks' => $validated['marks'],
                    'grade' => $validated['grade'],
                    'remarks' => $validated['remarks'] ?? null,
                    'teacher_id' => $teacher->id,
                ]
            );
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Marks updated successfully!'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update marks. Please try again.'
            ], 500);
        }
    }
}
