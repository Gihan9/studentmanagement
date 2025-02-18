<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Student::query();
    
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%");
        }
    
        $students = $query->with('courses')->paginate(10); 
    
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return view('students.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id',
        ]);
    
        // Create the new student
        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);
    
        // Attach courses to the student
        if ($request->has('courses')) {
            $student->courses()->attach($request->courses);
        }
    
        return redirect()->route('students.index')->with('success', 'Student created successfully');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $courses = Course::all();
        return view('students.edit', compact('student', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate(['name' => 'required', 'email' => 'required|email']);
        $student->update($request->only(['name', 'email']));
        $student->courses()->sync($request->courses);
    
        return redirect()->route('students.index')->with('success', 'Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully');
    }






    //ajax course function

    public function addCourse(Request $request, Student $student)
    {
       
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);
    
        
        $student->courses()->attach($request->course_id);
    
        return response()->json(['success' => true]);
    }
    

    public function removeCourse(Request $request, Student $student)
    {
        $student->courses()->detach($request->course_id);
        return response()->json(['success' => true]);
    }

}
