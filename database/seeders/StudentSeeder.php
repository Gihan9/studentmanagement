<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;


class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $student = Student::create(['name' => 'Gihan', 'email' => 'gihan@gmail.com']);
        $student->courses()->attach([1, 2]);
    }
}
