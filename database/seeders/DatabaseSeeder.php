<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
  {
    $this->call([
        SchoolInformationSeeder::class, // Add this line
        SchoolClassSeeder::class,
        SubjectSeeder::class,
        TeacherSeeder::class, // Add TeacherSeeder after SchoolClass and Subject seeders
        StudentSeeder::class,
        ResultSeeder::class,
        RoleAndPermissionSeeder::class,
        AdminUserSeeder::class,
    ]);
  }
}
