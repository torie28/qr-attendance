<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            ['name' => 'Computer Science', 'code' => 'CS101'],
            ['name' => 'ICT', 'code' => 'ICT101'],
            ['name' => 'Business Administration', 'code' => 'BA401']
        ];

        DB::table('courses')->insert($courses);
    }
}