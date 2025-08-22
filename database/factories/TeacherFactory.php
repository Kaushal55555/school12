<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = $this->faker->randomElement(['male', 'female']);
        $firstName = $this->faker->firstName($gender);
        $lastName = $this->faker->lastName();
        $email = strtolower($firstName . '.' . $lastName . '@example.com');
        
        return [
            'user_id' => User::factory()->create([
                'name' => "$firstName $lastName",
                'email' => $email,
                'password' => bcrypt('password'),
                'role' => 'teacher',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ])->id,
            'employee_id' => 'TCH' . $this->faker->unique()->numberBetween(1000, 9999),
            'qualification' => $this->faker->randomElement([
                'B.Ed', 'M.Ed', 'B.Sc', 'M.Sc', 'B.A', 'M.A', 'Ph.D'
            ]) . ' in ' . $this->faker->randomElement([
                'Education', 'Mathematics', 'Science', 'English', 'History', 'Computer Science'
            ]),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'date_of_birth' => $this->faker->dateTimeBetween('-50 years', '-25 years')->format('Y-m-d'),
            'gender' => $gender,
            'joining_date' => $this->faker->dateTimeBetween('-10 years', 'now')->format('Y-m-d'),
            'photo_path' => $this->faker->optional(0.7, null)->imageUrl(200, 200, 'people', true, 'teacher'),
            'bio' => $this->faker->optional(0.8)->paragraphs(3, true),
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }

    /**
     * Configure the model factory to create an active teacher.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Configure the model factory to create an inactive teacher.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Configure the model factory to create a teacher with a specific qualification.
     */
    public function withQualification(string $qualification): static
    {
        return $this->state(fn (array $attributes) => [
            'qualification' => $qualification,
        ]);
    }

    /**
     * Configure the model factory to create a teacher with a specific gender.
     */
    public function withGender(string $gender): static
    {
        return $this->state(fn (array $attributes) => [
            'gender' => $gender,
        ]);
    }
}
