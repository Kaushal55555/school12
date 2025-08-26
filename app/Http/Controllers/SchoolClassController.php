<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(SchoolClass::class, 'class');
    }
    
    /**
     * Get the map of resource methods to ability names.
     *
     * @return array
     */
    protected function resourceAbilityMap()
    {
        return [
            'index' => 'viewAny',
            'show' => 'view',
            'create' => 'create',
            'store' => 'create',
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
        ];
    }
    
    /**
     * Get the list of resource methods which do not have model parameters.
     *
     * @return array
     */
    protected function resourceMethodsWithoutModels()
    {
        return ['index', 'create', 'store'];
    }

    public function index()
    {
        $query = SchoolClass::query();
        
        // If user is a teacher, only show their assigned classes
        if (auth()->user()->hasRole('teacher')) {
            $query->whereHas('subjectAssignments', function($q) {
                $q->where('teacher_id', auth()->id());
            });
        }
        
        $classes = $query->latest()->paginate(10);
        
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'nullable|string|max:10',
            'description' => 'nullable|string',
        ]);

        SchoolClass::create($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Class created successfully.');
    }

    public function show(SchoolClass $class)
    {
        return view('classes.show', compact('class'));
    }

    public function edit(SchoolClass $class)
    {
        return view('classes.edit', compact('class'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'nullable|string|max:10',
            'description' => 'nullable|string',
        ]);

        $class->update($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Class updated successfully');
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();

        return redirect()->route('classes.index')
            ->with('success', 'Class deleted successfully');
    }
}