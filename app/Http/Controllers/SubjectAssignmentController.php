<?php

namespace App\Http\Controllers;

use App\Models\SubjectAssignment;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assignments = SubjectAssignment::with(['teacher', 'subject', 'schoolClass'])
            ->latest()
            ->paginate(20);
            
        return view('subject-assignments.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::with('user')->get();
        $subjects = Subject::all();
        $classes = SchoolClass::all();
        
        return view('subject-assignments.create', compact('teachers', 'subjects', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:school_classes,id',
            'academic_year' => 'required|string|max:9',
            'term' => 'required|in:First,Second,Third',
            'is_class_teacher' => 'boolean',
        ]);

        // Check if this assignment already exists
        $exists = SubjectAssignment::where([
            'teacher_id' => $validated['teacher_id'],
            'subject_id' => $validated['subject_id'],
            'class_id' => $validated['class_id'],
            'academic_year' => $validated['academic_year'],
            'term' => $validated['term'],
        ])->exists();

        if ($exists) {
            return back()->with('error', 'This assignment already exists.');
        }

        // If this is a class teacher assignment, remove any existing class teacher for this class
        if ($request->has('is_class_teacher') && $request->is_class_teacher) {
            SubjectAssignment::where('class_id', $validated['class_id'])
                ->where('is_class_teacher', true)
                ->where('academic_year', $validated['academic_year'])
                ->where('term', $validated['term'])
                ->update(['is_class_teacher' => false]);
        }

        SubjectAssignment::create($validated);

        return redirect()->route('subject-assignments.index')
            ->with('success', 'Subject assignment created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubjectAssignment $subjectAssignment)
    {
        $teachers = Teacher::with('user')->get();
        $subjects = Subject::all();
        $classes = SchoolClass::all();
        
        return view('subject-assignments.edit', compact('subjectAssignment', 'teachers', 'subjects', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubjectAssignment $subjectAssignment)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:school_classes,id',
            'academic_year' => 'required|string|max:9',
            'term' => 'required|in:First,Second,Third',
            'is_class_teacher' => 'boolean',
        ]);

        // If this is a class teacher assignment, remove any existing class teacher for this class
        if ($request->has('is_class_teacher') && $request->is_class_teacher) {
            SubjectAssignment::where('class_id', $validated['class_id'])
                ->where('is_class_teacher', true)
                ->where('academic_year', $validated['academic_year'])
                ->where('term', $validated['term'])
                ->where('id', '!=', $subjectAssignment->id)
                ->update(['is_class_teacher' => false]);
        }

        $subjectAssignment->update($validated);

        return redirect()->route('subject-assignments.index')
            ->with('success', 'Subject assignment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubjectAssignment $subjectAssignment)
    {
        $subjectAssignment->delete();
        
        return redirect()->route('subject-assignments.index')
            ->with('success', 'Subject assignment deleted successfully.');
    }
    
    /**
     * Get subjects assigned to a teacher
     */
    public function getTeacherSubjects(Teacher $teacher, $classId = null)
    {
        $query = $teacher->subjectAssignments()
            ->with('subject')
            ->where('academic_year', now()->format('Y') . '-' . (now()->format('y') + 1));
            
        if ($classId) {
            $query->where('class_id', $classId);
        }
        
        return response()->json([
            'subjects' => $query->get()->pluck('subject')
        ]);
    }
}
