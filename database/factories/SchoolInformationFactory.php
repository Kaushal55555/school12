<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SchoolInformation>
 */
class SchoolInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        
        return [
            'school_name' => $faker->company . ' School',
            'school_code' => 'SCH-' . $faker->unique()->numberBetween(1000, 9999),
            'address' => $faker->address,
            'phone' => $faker->phoneNumber,
            'email' => $faker->companyEmail,
            'website' => $faker->url,
            'principal_name' => $faker->name,
            'contact_person_name' => $faker->name,
            'contact_person_phone' => $faker->phoneNumber,
            'contact_person_email' => $faker->email,
            'logo_path' => null,
            'favicon_path' => null,
            'academic_year_start' => 'September',
            'academic_year_end' => 'June',
            'timezone' => $faker->timezone,
            'date_format' => 'Y-m-d',
            'time_format' => 'H:i',
            'currency' => 'USD',
            'currency_symbol' => '$',
            'about' => $faker->paragraphs(3, true),
            'mission' => $faker->sentence,
            'vision' => $faker->sentence,
            'social_links' => [
                'facebook' => 'https://facebook.com/' . $faker->userName,
                'twitter' => 'https://twitter.com/' . $faker->userName,
            ],
            'is_active' => true,
        ];
    }
}
