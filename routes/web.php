<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';




Route::get('/students', [StudentController::class, 'index'])->name('students.index');


Route::resource('students', StudentController::class);
Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');

//ajax routes
Route::post('/students/{student}/add-course', [StudentController::class, 'addCourse']);
Route::post('/students/{student}/remove-course', [StudentController::class, 'removeCourse']);
