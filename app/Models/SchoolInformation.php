<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class SchoolInformation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'school_name',
        'school_code',
        'address',
        'phone',
        'email',
        'website',
        'principal_name',
        'contact_person_name',
        'contact_person_phone',
        'contact_person_email',
        'logo_path',
        'favicon_path',
        'academic_year_start',
        'academic_year_end',
        'timezone',
        'date_format',
        'time_format',
        'currency',
        'currency_symbol',
        'about',
        'mission',
        'vision',
        'social_links',
        'is_active',
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_active' => 'boolean',
    ];

    protected $appends = ['logo_url', 'favicon_url'];

    // The booted method has been moved to the SchoolInformationObserver

    /**
     * Get the current school information.
     * This method caches the school information for better performance.
     */
    public static function getSchoolInfo()
    {
        return Cache::rememberForever('school_information', function () {
            return self::first() ?? new self();
        });
    }

    /**
     * Get the logo URL attribute.
     */
    public function getLogoUrlAttribute()
    {
        if ($this->logo_path) {
            return asset('storage/' . $this->logo_path);
        }
        return asset('images/default-school-logo.png');
    }

    /**
     * Get the favicon URL attribute.
     */
    public function getFaviconUrlAttribute()
    {
        if ($this->favicon_path) {
            return asset('storage/' . $this->favicon_path);
        }
        return asset('images/default-favicon.ico');
    }

    /**
     * Get the current academic year.
     */
    public function getCurrentAcademicYearAttribute()
    {
        $currentMonth = (int) date('n');
        $currentYear = (int) date('Y');
        
        $startMonth = array_search(strtolower($this->academic_year_start), array_map('strtolower', \DateTimeZone::listIdentifiers()));
        
        if ($startMonth === false) {
            // Default to January if month not found
            $startMonth = 1;
        } else {
            $startMonth = (int) date('n', strtotime($this->academic_year_start . ' 1'));
        }
        
        if ($currentMonth < $startMonth) {
            return ($currentYear - 1) . '-' . $currentYear;
        }
        
        return $currentYear . '-' . ($currentYear + 1);
    }

    /**
     * Get the formatted address.
     */
    public function getFormattedAddressAttribute()
    {
        return nl2br(e($this->address));
    }

    /**
     * Get the social links as an array of icons and URLs.
     */
    public function getSocialLinksArrayAttribute()
    {
        $socialLinks = $this->social_links ?? [];
        $result = [];
        
        foreach ($socialLinks as $platform => $url) {
            if (!empty($url)) {
                $result[] = [
                    'platform' => $platform,
                    'url' => $url,
                    'icon' => $this->getSocialIcon($platform)
                ];
            }
        }
        
        return $result;
    }

    /**
     * Get the appropriate icon for a social platform.
     */
    protected function getSocialIcon($platform)
    {
        $icons = [
            'facebook' => 'fab fa-facebook-f',
            'twitter' => 'fab fa-twitter',
            'instagram' => 'fab fa-instagram',
            'linkedin' => 'fab fa-linkedin-in',
            'youtube' => 'fab fa-youtube',
            'pinterest' => 'fab fa-pinterest-p',
            'tiktok' => 'fab fa-tiktok',
            'whatsapp' => 'fab fa-whatsapp',
            'telegram' => 'fab fa-telegram-plane',
            'discord' => 'fab fa-discord',
        ];
        
        return $icons[strtolower($platform)] ?? 'fas fa-share-alt';
    }
}
