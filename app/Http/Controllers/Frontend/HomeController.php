<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        return view('frontend.index');
    }

    /**
     * Show the about page.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function about()
    {
        return view('frontend.about');
    }

    /**
     * Show the contact page.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function contact()
    {
        return view('frontend.contact');
    }

    /**
     * Show the results check page.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function results()
    {
        try {
            $classes = SchoolClass::all();
            return view('frontend.results', ['classes' => $classes]);
        } catch (\Exception $e) {
            // Log the error and return an empty collection
            \Log::error('Error fetching classes: ' . $e->getMessage());
            return view('frontend.results', ['classes' => collect([])]);
        }
    }

    /**
     * Process the result check request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function checkResult(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'roll_number' => 'required',
            'class_id' => 'required|exists:school_classes,id',
            'dob' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->route('public.results')
                ->withErrors($validator)
                ->withInput();
        }

        // Find the student first
        $student = Student::where('roll_number', $request->roll_number)
            ->where('class_id', $request->class_id)
            ->where('date_of_birth', $request->dob)
            ->first();

        if (!$student) {
            return redirect()->back()
                ->with('error', 'No student found with the provided details.')
                ->withInput();
        }

        // Get the results for the student
        $results = Result::where('student_id', $student->id)
            ->with(['subject', 'schoolClass'])
            ->get();

        if ($results->isEmpty()) {
            return redirect()->back()
                ->with('error', 'No results found for this student.')
                ->withInput();
        }

        return view('frontend.result-show', [
            'results' => $results,
            'student' => $student
        ]);
    }
}
