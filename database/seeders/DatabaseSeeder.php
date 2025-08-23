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
        SchoolInformationSeeder::class,
        SchoolClassSeeder::class,
        SubjectSeeder::class,
        TeacherSeeder::class,
        StudentSeeder::class,
        ResultSeeder::class,
        RoleAndPermissionSeeder::class,
        PermissionTableSeeder::class, // Add the new PermissionTableSeeder
        AdminUserSeeder::class,
    ]);
  }
}
