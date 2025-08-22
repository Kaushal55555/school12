<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a printable version of the results.
     *
     * @return \Illuminate\View\View
     */
    public function print()
    {
        $query = Result::with(['student', 'subject', 'schoolClass']);
        
        // Apply filters if they exist
        if (request('class_id')) {
            $query->where('class_id', request('class_id'));
        }
        
        if (request('subject_id')) {
            $query->where('subject_id', request('subject_id'));
        }
        
        if (request('student_id')) {
            $query->where('student_id', request('student_id'));
        }
        
        $results = $query->orderBy('created_at', 'desc')->get();
        $classes = SchoolClass::all();
        $subjects = request('class_id') ? Subject::where('class_id', request('class_id'))->get() : collect([]);
        $students = request('class_id') ? Student::where('class_id', request('class_id'))->get() : collect([]);
        
        return view('results.print', compact('results', 'classes', 'subjects', 'students'));
    }

    /**
     * Display a listing of the results.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Debug: Log the request parameters
        \Log::info('Result index request:', request()->all());
        
        // Start building the query
        $query = Result::with(['student', 'subject', 'schoolClass']);
        
        // Apply filters if they exist
        if (request('class_id')) {
            $query->where('class_id', request('class_id'));
        }
        
        if (request('subject_id')) {
            $query->where('subject_id', request('subject_id'));
        }
        
        if (request('student_id')) {
            $query->where('student_id', request('student_id'));
        }
        
        // Check if this is a print request
        $isPrint = request()->has('print');
        
        // Order by created_at in descending order and paginate
        $perPage = 10; // Number of items per page
        $results = $isPrint 
            ? $query->orderBy('created_at', 'desc')->get()
            : $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();
        
        // Debug: Log the SQL query and results count
        \Log::info('Results query:', [
            'sql' => $query->toSql(), 
            'bindings' => $query->getBindings(),
            'results_count' => $results->count(),
            'total' => $results->total(),
            'current_page' => $results->currentPage(),
            'last_page' => $results->lastPage(),
            'per_page' => $results->perPage(),
        ]);
        
        $classes = SchoolClass::all();
        $subjects = request('class_id') ? Subject::where('class_id', request('class_id'))->get() : collect([]);
        $students = request('class_id') ? Student::where('class_id', request('class_id'))->get() : collect([]);
        
        // Debug: Log the data being sent to the view
        $viewData = [
            'results_count' => $results->count(),
            'classes_count' => $classes->count(),
            'subjects_count' => $subjects->count(),
            'students_count' => $students->count(),
            'is_print' => $isPrint,
            'has_results' => $results->count() > 0
        ];
        
        \Log::info('View data:', $viewData);
        
        // Log the first few results for debugging
        if ($results->count() > 0) {
            \Log::debug('First result data:', [
                'result' => $results->first()->toArray(),
                'student' => $results->first()->student ? $results->first()->student->toArray() : null,
                'subject' => $results->first()->subject ? $results->first()->subject->toArray() : null,
                'class' => $results->first()->schoolClass ? $results->first()->schoolClass->toArray() : null
            ]);
        }
        
        if ($isPrint) {
            return view('results.print', compact('results', 'classes', 'subjects', 'students'));
        }
        
        return view('results.index', compact('results', 'classes', 'subjects', 'students'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        $subjects = collect([]);
        $students = collect([]);
        
        return view('results.create', compact('classes', 'subjects', 'students'));
    }

    public function store(Request $request)
    {
        \Log::info('Starting result creation', ['request' => $request->all()]);
        \Log::info('Database connection:', ['connection' => \DB::connection()->getPdo() ? 'Connected' : 'Not Connected']);
        
        try {
            $validated = $request->validate([
                'student_id' => 'required|exists:students,id',
                'subject_id' => 'required|exists:subjects,id',
                'class_id' => 'required|exists:school_classes,id',
                'marks_obtained' => 'required|numeric|min:0',
                'term' => 'required|string|in:First Term,Second Term,Third Term',
                'academic_year' => 'required|integer|min:2000|max:2100',
                'remarks' => 'nullable|string|max:500',
            ]);
            \Log::info('Validation passed', ['validated' => $validated]);

            // Get subject to validate marks against full_marks
            $subject = Subject::findOrFail($validated['subject_id']);
            \Log::info('Found subject', ['subject' => $subject->toArray()]);
            
            // Set default full_marks to 100 if not set
            $full_marks = $subject->full_marks ?? 100;
            
            if ($validated['marks_obtained'] > $full_marks) {
                $error = 'Marks obtained cannot be greater than full marks (' . $full_marks . ').';
                \Log::warning('Validation failed: ' . $error);
                return back()
                    ->withInput()
                    ->with('error', $error);
            }

            // Check if result already exists for this student and subject
            $existingResult = Result::where('student_id', $validated['student_id'])
                ->where('subject_id', $validated['subject_id'])
                ->first();

            if ($existingResult) {
                $error = 'A result already exists for this student and subject combination.';
                \Log::warning('Duplicate result attempt', ['existing' => $existingResult->toArray()]);
                return back()
                    ->withInput()
                    ->with('error', $error);
            }

            // Calculate grade based on marks
            $percentage = ($validated['marks_obtained'] / $full_marks) * 100;
            $grade = $this->calculateGrade($percentage, $subject->pass_marks ?? 40, $full_marks);
            
            // Map the fields to match the database columns
            $resultData = [
                'student_id' => $validated['student_id'],
                'subject_id' => $validated['subject_id'],
                'class_id' => $validated['class_id'],
                'marks' => $validated['marks_obtained'], // Map marks_obtained to marks
                'grade' => $grade,
                'percentage' => round($percentage, 2),
                'term' => $validated['term'],
                'academic_year' => $validated['academic_year'],
                'remarks' => $validated['remarks'] ?? null,
            ];
            
            \Log::info('Creating result with data', $resultData);

            \Log::info('Attempting to create result with data:', $resultData);
            
            // Try to create the result and log the outcome
            try {
                $result = Result::create($resultData);
                \Log::info('Result created successfully', [
                    'result_id' => $result->id,
                    'result_data' => $result->toArray()
                ]);
                
                // Verify the result exists in the database
                $foundResult = Result::find($result->id);
                \Log::info('Verification - Result exists in DB:', [
                    'found' => $foundResult ? 'Yes' : 'No',
                    'record' => $foundResult ? $foundResult->toArray() : null
                ]);
                
                // Check if we can query the results table directly
                $allResults = \DB::table('results')->get();
                \Log::info('All results in database:', ['count' => $allResults->count()]);
                
            } catch (\Exception $e) {
                \Log::error('Error creating result in database:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e; // Re-throw to be caught by the outer try-catch
            }

            // Clear the form by redirecting back to the create form with a success message
            return redirect()
                ->route('results.create')
                ->with('success', 'Result added successfully.')
                ->with('clear_form', true);
                
        } catch (\Exception $e) {
            \Log::error('Error creating result', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()
                ->withInput()
                ->with('error', 'An error occurred while saving the result. Please try again.');
        }
    }

    public function show(Result $result)
    {
        $result->load(['student', 'subject', 'schoolClass']);
        return view('results.show', compact('result'));
    }

    public function edit(Result $result)
    {
        $classes = SchoolClass::all();
        $subjects = Subject::where('class_id', $result->class_id)->get();
        $students = Student::where('class_id', $result->class_id)->get();
        
        return view('results.edit', compact('result', 'classes', 'subjects', 'students'));
    }

    public function update(Request $request, Result $result)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:school_classes,id',
            'marks_obtained' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:500',
        ]);

        // Get subject to validate marks against full_marks
        $subject = Subject::findOrFail($validated['subject_id']);
        
        if ($validated['marks_obtained'] > $subject->full_marks) {
            return back()
                ->withInput()
                ->with('error', 'Marks obtained cannot be greater than full marks (' . $subject->full_marks . ').');
        }

        // Check if result already exists for this student and subject (excluding current result)
        $existingResult = Result::where('student_id', $validated['student_id'])
            ->where('subject_id', $validated['subject_id'])
            ->where('id', '!=', $result->id)
            ->first();

        if ($existingResult) {
            return back()
                ->withInput()
                ->with('error', 'A result already exists for this student and subject combination.');
        }

        // Calculate grade based on marks
        $percentage = ($validated['marks_obtained'] / $subject->full_marks) * 100;
        $grade = $this->calculateGrade($percentage, $subject->pass_marks, $subject->full_marks);
        
        $validated['grade'] = $grade;
        $validated['percentage'] = round($percentage, 2);

        $result->update($validated);

        return redirect()->route('results.index')
            ->with('success', 'Result updated successfully.');
    }

    public function destroy(Result $result)
    {
        $result->delete();
        
        return redirect()->route('results.index')
            ->with('success', 'Result deleted successfully.');
    }

    // Helper method to calculate grade based on percentage
    private function calculateGrade($percentage, $passMarks, $fullMarks)
    {
        if ($percentage >= 90) return 'A+';
        if ($percentage >= 80) return 'A';
        if ($percentage >= 70) return 'B+';
        if ($percentage >= 60) return 'B';
        if ($percentage >= 50) return 'C+';
        if ($percentage >= 40) return 'C';
        return 'F';
    }

    // AJAX method to get subjects for a class
    public function getSubjects($classId)
    {
        $subjects = Subject::where('class_id', $classId)->get(['id', 'name']);
        return response()->json($subjects);
    }

    // AJAX method to get students for a class
    public function getStudents($classId)
    {
        $students = Student::where('class_id', $classId)->get(['id', 'name', 'roll_number']);
        return response()->json($students);
    }
}
