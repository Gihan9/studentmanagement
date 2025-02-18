<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class StudentCourse extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'course_id'];
}
