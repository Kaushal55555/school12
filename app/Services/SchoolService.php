<?php

namespace App\Services;

use App\Models\SchoolInformation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class SchoolService
{
    /**
     * Get the current school information.
     * This method caches the school information for better performance.
     *
     * @return \App\Models\SchoolInformation
     */
    public function getSchoolInfo()
    {
        return Cache::rememberForever('school_information', function () {
            return SchoolInformation::first() ?? new SchoolInformation();
        });
    }

    /**
     * Update school information.
     *
     * @param array $data
     * @return \App\Models\SchoolInformation
     */
    public function updateSchoolInfo(array $data)
    {
        $schoolInfo = SchoolInformation::first();
        
        if (!$schoolInfo) {
            // If no record exists, create a new one with default values
            $defaults = [
                'school_name' => $data['school_name'] ?? 'School Name',
                'address' => $data['address'] ?? 'Address not set',
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'academic_year_start' => 'September',
                'academic_year_end' => 'June',
                'is_active' => true,
            ];
            
            $schoolInfo = SchoolInformation::create(array_merge($defaults, $data));
        } else {
            // Update existing record
            $schoolInfo->update($data);
        }
        
        // Clear the cache
        Cache::forget('school_information');

        return $schoolInfo->fresh();
    }

    /**
     * Upload school logo.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string|null
     */
    public function uploadLogo(UploadedFile $file): ?string
    {
        $filename = 'school/logo/' . Str::uuid() . '.' . $file->getClientOriginalExtension();
        
        $path = $file->storeAs('public', $filename);
        
        return $path ? str_replace('public/', '', $path) : null;
    }

    /**
     * Upload school favicon.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string|null
     */
    public function uploadFavicon(UploadedFile $file): ?string
    {
        $filename = 'school/favicon/' . Str::uuid() . '.' . $file->getClientOriginalExtension();
        
        $path = $file->storeAs('public', $filename);
        
        return $path ? str_replace('public/', '', $path) : null;
    }

    /**
     * Get the current academic year based on the school's academic year settings.
     *
     * @return string
     */
    public function getCurrentAcademicYear(): string
    {
        $schoolInfo = $this->getSchoolInfo();
        $currentMonth = (int) date('n');
        $currentYear = (int) date('Y');
        
        $startMonth = $this->getMonthNumber($schoolInfo->academic_year_start);
        
        if ($currentMonth < $startMonth) {
            return ($currentYear - 1) . '-' . $currentYear;
        }
        
        return $currentYear . '-' . ($currentYear + 1);
    }

    /**
     * Get the next academic year.
     *
     * @return string
     */
    public function getNextAcademicYear(): string
    {
        $current = $this->getCurrentAcademicYear();
        list($start, $end) = explode('-', $current);
        
        return ($start + 1) . '-' . ($end + 1);
    }

    /**
     * Get list of academic years for selection.
     *
     * @param int $yearsBack Number of years to go back
     * @param int $yearsForward Number of years to go forward
     * @return array
     */
    public function getAcademicYearOptions(int $yearsBack = 5, int $yearsForward = 5): array
    {
        $currentYear = (int) date('Y');
        $options = [];
        
        // Add previous years
        for ($i = $yearsBack; $i > 0; $i--) {
            $year = $currentYear - $i;
            $options[($year - 1) . '-' . $year] = ($year - 1) . '-' . $year;
        }
        
        // Add current and future years
        for ($i = 0; $i <= $yearsForward; $i++) {
            $year = $currentYear + $i;
            $options[($year - 1) . '-' . $year] = ($year - 1) . '-' . $year;
        }
        
        return $options;
    }

    /**
     * Get the month number from month name.
     *
     * @param string $monthName
     * @return int
     */
    protected function getMonthNumber(string $monthName): int
    {
        $month = \DateTime::createFromFormat('F', $monthName);
        
        if ($month === false) {
            // Default to January if month not found
            return 1;
        }
        
        return (int) $month->format('n');
    }
}
