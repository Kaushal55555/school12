<?php

use App\Services\SchoolService;
use Illuminate\Support\Facades\App;

if (!function_exists('school_info')) {
    /**
     * Get the school information.
     *
     * @return \App\Models\SchoolInformation
     */
    function school_info()
    {
        return App::make(SchoolService::class)->getSchoolInfo();
    }
}

if (!function_exists('current_academic_year')) {
    /**
     * Get the current academic year.
     *
     * @return string
     */
    function current_academic_year()
    {
        return App::make(SchoolService::class)->getCurrentAcademicYear();
    }
}

if (!function_exists('academic_year_options')) {
    /**
     * Get academic year options for dropdowns.
     *
     * @param int $yearsBack
     * @param int $yearsForward
     * @return array
     */
    function academic_year_options(int $yearsBack = 5, int $yearsForward = 5)
    {
        return App::make(SchoolService::class)->getAcademicYearOptions($yearsBack, $yearsForward);
    }
}
