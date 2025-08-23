<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;

class SchoolInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolInformation $schoolInformation)
    {
        //
    }

    /**
     * Show the form for editing the school information.
     */
    public function edit()
    {
        $school = SchoolInformation::first();
        
        if (!$school) {
            $school = new SchoolInformation();
        }
        
        return view('admin.school-information.edit', compact('school'));
    }

    /**
     * Update the school information in storage.
     */
    public function update(Request $request)
    {
        $school = SchoolInformation::firstOrNew();
        
        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'school_code' => [
                'nullable', 
                'string', 
                'max:50', 
                Rule::unique('school_information', 'school_code')->ignore($school->id)
            ],
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'principal_name' => 'nullable|string|max:255',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_phone' => 'nullable|string|max:20',
            'contact_person_email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:png,ico|max:1024',
            'timezone' => 'required|timezone',
            'date_format' => 'required|string',
            'time_format' => 'required|string',
            'currency' => 'required|string|size:3',
            'currency_symbol' => 'required|string|max:5',
            'about' => 'nullable|string',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'academic_year_start' => 'required|string',
            'academic_year_end' => 'required|string',
            'is_active' => 'boolean',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($school->logo_path && Storage::exists($school->logo_path)) {
                Storage::delete($school->logo_path);
            }
            
            $logoPath = $request->file('logo')->store('school/logo', 'public');
            $validated['logo_path'] = $logoPath;
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            if ($school->favicon_path && Storage::exists($school->favicon_path)) {
                Storage::delete($school->favicon_path);
            }
            
            $faviconPath = $request->file('favicon')->store('school/favicon', 'public');
            $validated['favicon_path'] = $faviconPath;
        }

        // Handle social links
        $socialLinks = [];
        $socialPlatforms = ['facebook', 'twitter', 'instagram', 'linkedin', 'youtube'];
        
        foreach ($socialPlatforms as $platform) {
            if ($request->filled("social_$platform")) {
                $socialLinks[$platform] = $request->input("social_$platform");
            }
        }
        
        if (!empty($socialLinks)) {
            $validated['social_links'] = json_encode($socialLinks);
        }

        // Set is_active if not provided
        if (!isset($validated['is_active'])) {
            $validated['is_active'] = false;
        }

        // Update or create the school information
        $school->fill($validated);
        $school->save();

        // Clear the school information cache
        Cache::forget('school_information');

        return redirect()->route('admin.school-information.edit')
            ->with('success', 'School information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // This method is intentionally left empty as we don't want to delete school information
        // Instead, we'll just deactivate it
        $school = SchoolInformation::findOrFail($id);
        $school->update(['is_active' => false]);
        
        return redirect()->route('admin.school-information.edit')
            ->with('success', 'School information deactivated successfully.');
    }
}
