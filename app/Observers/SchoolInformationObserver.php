<?php

namespace App\Observers;

use App\Models\SchoolInformation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SchoolInformationObserver
{
    /**
     * Handle the SchoolInformation "created" event.
     */
    public function created(SchoolInformation $schoolInformation): void
    {
        $this->clearSchoolInfoCache();
    }

    /**
     * Handle the SchoolInformation "updated" event.
     */
    public function updated(SchoolInformation $schoolInformation): void
    {
        $this->clearSchoolInfoCache();
        
        // If logo was updated, delete the old logo file
        if ($schoolInformation->isDirty('logo_path') && $schoolInformation->getOriginal('logo_path')) {
            Storage::disk('public')->delete($schoolInformation->getOriginal('logo_path'));
        }
        
        // If favicon was updated, delete the old favicon file
        if ($schoolInformation->isDirty('favicon_path') && $schoolInformation->getOriginal('favicon_path')) {
            Storage::disk('public')->delete($schoolInformation->getOriginal('favicon_path'));
        }
    }

    /**
     * Handle the SchoolInformation "deleted" event.
     */
    public function deleted(SchoolInformation $schoolInformation): void
    {
        $this->clearSchoolInfoCache();
        
        // Delete associated files
        if ($schoolInformation->logo_path) {
            Storage::disk('public')->delete($schoolInformation->logo_path);
        }
        
        if ($schoolInformation->favicon_path) {
            Storage::disk('public')->delete($schoolInformation->favicon_path);
        }
    }

    /**
     * Handle the SchoolInformation "restored" event.
     */
    public function restored(SchoolInformation $schoolInformation): void
    {
        $this->clearSchoolInfoCache();
    }

    /**
     * Handle the SchoolInformation "force deleted" event.
     */
    public function forceDeleted(SchoolInformation $schoolInformation): void
    {
        $this->clearSchoolInfoCache();
    }
    
    /**
     * Clear the school information cache.
     */
    protected function clearSchoolInfoCache(): void
    {
        Cache::forget('school_information');
    }
}
