<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Result;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Show student reports
     *
     * @return \Illuminate\View\View
     */
    public function students()
    {
        $classes = SchoolClass::all();
        $students = collect();
        
        return view('reports.students', compact('classes', 'students'));
    }
    
    /**
     * Show result analysis reports
     *
     * @return \Illuminate\View\View
     */
    public function results()
    {
        $classes = SchoolClass::with('subjects')->get();
        $results = collect();
        
        return view('reports.results', compact('classes', 'results'));
    }
    
    /**
     * Filter student reports
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function filterStudents(Request $request)
    {
        $classes = SchoolClass::all();
        $students = Student::query();
        
        if ($request->has('class_id') && $request->class_id) {
            $students->where('class_id', $request->class_id);
        }
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $students->where(function($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('roll_number', 'like', "%$search%");
            });
        }
        
        $students = $students->with('class')->paginate(15);
        
        return view('reports.students', compact('classes', 'students'));
    }
    
    /**
     * Filter result analysis reports
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function filterResults(Request $request)
    {
        $classes = SchoolClass::with('subjects')->get();
        $results = Result::query()->with(['student', 'subject', 'class']);
        
        if ($request->has('class_id') && $request->class_id) {
            $results->where('class_id', $request->class_id);
        }
        
        if ($request->has('subject_id') && $request->subject_id) {
            $results->where('subject_id', $request->subject_id);
        }
        
        if ($request->has('term') && $request->term) {
            $results->where('term', $request->term);
        }
        
        $results = $results->orderBy('marks', 'desc')->paginate(15);
        
        return view('reports.results', compact('classes', 'results'));
    }
}
