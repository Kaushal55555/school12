<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Mark;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarkController extends Controller
{
    /**
     * Display marks for a specific class and subject
     */
    public function index(SchoolClass $class, Subject $subject)
    {
        $teacher = auth()->user()->teacher;
        $currentYear = date('Y') . '-' . (date('Y') + 1);
        $currentTerm = 'Term ' . ceil(date('n') / 4);
        
        // Verify the teacher is assigned to teach this subject to this class
        $isAssigned = $teacher->subjectAssignments()
            ->where('class_id', $class->id)
            ->where('subject_id', $subject->id)
            ->exists();
            
        if (!$isAssigned) {
            abort(403, 'You are not authorized to view marks for this subject.');
        }
        
        // Get all students in the class with their marks for this subject
        $students = $class->students()
            ->with(['marks' => function($query) use ($subject, $currentYear, $currentTerm) {
                $query->where('subject_id', $subject->id)
                      ->where('academic_year', $currentYear)
                      ->where('term', $currentTerm);
            }])
            ->orderBy('roll_number')
            ->get();
            
        return view('teacher.marks.index', [
            'class' => $class,
            'subject' => $subject,
            'students' => $students,
            'currentYear' => $currentYear,
            'currentTerm' => $currentTerm
        ]);
    }
    
    /**
     * Store marks for students
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'marks' => 'required|array',
            'marks.*.student_id' => 'required|exists:students,id',
            'marks.*.mark' => 'nullable|numeric|min:0|max:100',
            'academic_year' => 'required|string',
            'term' => 'required|string',
        ]);
        
        $teacher = auth()->user()->teacher;
        
        // Verify the teacher is assigned to teach this subject to this class
        $isAssigned = $teacher->subjectAssignments()
            ->where('class_id', $validated['class_id'])
            ->where('subject_id', $validated['subject_id'])
            ->exists();
            
        if (!$isAssigned) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to enter marks for this subject.'
            ], 403);
        }
        
        // Process marks in a transaction
        DB::beginTransaction();
        
        try {
            foreach ($validated['marks'] as $markData) {
                if (!isset($markData['mark']) || $markData['mark'] === '') {
                    continue; // Skip if mark is not provided
                }
                
                Mark::updateOrCreate(
                    [
                        'student_id' => $markData['student_id'],
                        'subject_id' => $validated['subject_id'],
                        'academic_year' => $validated['academic_year'],
                        'term' => $validated['term'],
                    ],
                    [
                        'mark' => $markData['mark'],
                        'teacher_id' => $teacher->id,
                        'class_id' => $validated['class_id'],
                        'remarks' => $markData['remarks'] ?? null,
                    ]
                );
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Marks saved successfully.'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to save marks. Please try again.'
            ], 500);
        }
    }
    
    /**
     * Update a specific mark
     */
    public function update(Request $request, Mark $mark)
    {
        $validated = $request->validate([
            'mark' => 'required|numeric|min:0|max:100',
            'remarks' => 'nullable|string|max:255',
        ]);
        
        $teacher = auth()->user()->teacher;
        
        // Verify the teacher is the one who created the mark or is assigned to the subject
        if ($mark->teacher_id !== $teacher->id) {
            $isAssigned = $teacher->subjectAssignments()
                ->where('class_id', $mark->class_id)
                ->where('subject_id', $mark->subject_id)
                ->exists();
                
            if (!$isAssigned) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to update this mark.'
                ], 403);
            }
        }
        
        $mark->update([
            'mark' => $validated['mark'],
            'remarks' => $validated['remarks'] ?? $mark->remarks,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Mark updated successfully.',
            'data' => $mark->fresh()
        ]);
    }
    
    /**
     * Get mark statistics for a class and subject
     */
    public function statistics(SchoolClass $class, Subject $subject)
    {
        $teacher = auth()->user()->teacher;
        $currentYear = date('Y') . '-' . (date('Y') + 1);
        $currentTerm = 'Term ' . ceil(date('n') / 4);
        
        // Verify the teacher is assigned to teach this subject to this class
        $isAssigned = $teacher->subjectAssignments()
            ->where('class_id', $class->id)
            ->where('subject_id', $subject->id)
            ->exists();
            
        if (!$isAssigned) {
            abort(403, 'You are not authorized to view statistics for this subject.');
        }
        
        // Get mark statistics
        $stats = Mark::where('class_id', $class->id)
            ->where('subject_id', $subject->id)
            ->where('academic_year', $currentYear)
            ->where('term', $currentTerm)
            ->selectRaw('COUNT(*) as total_students')
            ->selectRaw('AVG(mark) as average_mark')
            ->selectRaw('MAX(mark) as highest_mark')
            ->selectRaw('MIN(mark) as lowest_mark')
            ->selectRaw('SUM(CASE WHEN mark >= 40 THEN 1 ELSE 0 END) as passed')
            ->selectRaw('SUM(CASE WHEN mark < 40 THEN 1 ELSE 0 END) as failed')
            ->first();
            
        // Get grade distribution
        $gradeDistribution = Mark::where('class_id', $class->id)
            ->where('subject_id', $subject->id)
            ->where('academic_year', $currentYear)
            ->where('term', $currentTerm)
            ->selectRaw('CASE 
                WHEN mark >= 80 THEN "A+"
                WHEN mark >= 70 THEN "A"
                WHEN mark >= 60 THEN "B+"
                WHEN mark >= 50 THEN "B"
                WHEN mark >= 40 THEN "C+"
                WHEN mark >= 35 THEN "C"
                ELSE "F"
            END as grade')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('grade')
            ->orderByRaw('CASE grade 
                WHEN "A+" THEN 1
                WHEN "A" THEN 2
                WHEN "B+" THEN 3
                WHEN "B" THEN 4
                WHEN "C+" THEN 5
                WHEN "C" THEN 6
                ELSE 7
            END')
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats,
                'grade_distribution' => $gradeDistribution
            ]
        ]);
    }
}
