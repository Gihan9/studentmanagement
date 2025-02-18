<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Api\StudentApiController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});




Route::apiResource('students', StudentController::class);


Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/students', [StudentApiController::class, 'index']); // List all students
    Route::get('/students/{id}', [StudentApiController::class, 'show']); // Get single student
    Route::post('/students', [StudentApiController::class, 'store']); // Create a new student
    Route::put('/students/{id}', [StudentApiController::class, 'update']); // Update student
    Route::delete('/students/{id}', [StudentApiController::class, 'destroy']); // Delete student
});
