<?php

namespace Database\Seeders;

use App\Models\SchoolInformation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if school information already exists
        if (SchoolInformation::count() === 0) {
            SchoolInformation::create([
                'school_name' => 'Your School Name',
                'school_code' => 'YOUR-SCHOOL-CODE',
                'address' => "123 School Street\nCity, State, Country\nPostal Code",
                'phone' => '+1 (123) 456-7890',
                'email' => 'info@yourschool.edu',
                'website' => 'https://yourschool.edu',
                'principal_name' => 'John Doe',
                'contact_person_name' => 'Jane Smith',
                'contact_person_phone' => '+1 (123) 456-7891',
                'contact_person_email' => 'jane.smith@yourschool.edu',
                'logo_path' => null,
                'favicon_path' => null,
                'academic_year_start' => 'September',
                'academic_year_end' => 'June',
                'timezone' => 'UTC',
                'date_format' => 'Y-m-d',
                'time_format' => 'H:i',
                'currency' => 'USD',
                'currency_symbol' => '$',
                'about' => 'A leading educational institution committed to excellence in teaching and learning.',
                'mission' => 'To provide quality education that transforms students into responsible global citizens.',
                'vision' => 'To be a center of excellence in education and research.',
                'social_links' => [
                    'facebook' => 'https://facebook.com/yourschool',
                    'twitter' => 'https://twitter.com/yourschool',
                    'instagram' => 'https://instagram.com/yourschool',
                    'youtube' => 'https://youtube.com/yourschool',
                ],
                'is_active' => true,
            ]);

            $this->command->info('Default school information has been created.');
        } else {
            $this->command->info('School information already exists. No new records were created.');
        }
    }
}
