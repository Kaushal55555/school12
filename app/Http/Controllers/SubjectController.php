<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $subjects = Subject::with('schoolClass')->latest()->paginate(10);
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        return view('subjects.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code',
            'class_id' => 'required|exists:school_classes,id',
            'description' => 'nullable|string',
            'full_marks' => 'required|integer|min:0',
            'pass_marks' => 'required|integer|min:0|max:' . ($request->input('full_marks') ?? 100),
        ]);

        Subject::create($validated);

        return redirect()->route('subjects.index')
            ->with('success', 'Subject created successfully.');
    }

    public function show(Subject $subject)
    {
        $subject->load('schoolClass');
        return view('subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        $classes = SchoolClass::all();
        return view('subjects.edit', compact('subject', 'classes'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code,' . $subject->id,
            'class_id' => 'required|exists:school_classes,id',
            'description' => 'nullable|string',
            'full_marks' => 'required|integer|min:0',
            'pass_marks' => 'required|integer|min:0|max:' . ($request->input('full_marks') ?? $subject->full_marks),
        ]);

        $subject->update($validated);

        return redirect()->route('subjects.index')
            ->with('success', 'Subject updated successfully');
    }

    public function destroy(Subject $subject)
    {
        // Check if subject has any results before deleting
        if ($subject->results()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete subject with associated results.');
        }

        $subject->delete();

        return redirect()->route('subjects.index')
            ->with('success', 'Subject deleted successfully');
    }
}
