@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Student</h2>

    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Student Name:</label>
            <input type="text" name="name" class="form-control" value="{{ $student->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Student Email:</label>
            <input type="email" name="email" class="form-control" value="{{ $student->email }}" required>
        </div>

        <div class="form-group">
            <label for="courses">Select Courses:</label>
            <select name="courses[]" id="course-select" class="form-control" multiple >
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" 
                        {{ $student->courses->contains($course->id) ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Student</button>
    </form>

    <!-- AJAX Course Management -->
    <h3 class="mt-4">Manage Courses</h3>
    <div id="course-list">
        @foreach($student->courses as $course)
            <span class="badge badge-info">
                {{ $course->name }}
                <button class="remove-course btn btn-danger btn-sm" data-student-id="{{ $student->id }}" data-course-id="{{ $course->id }}">x</button>
            </span>
        @endforeach
    </div>

    <select id="new-course" class="form-control mt-3">
        <option value="">Select Course</option>
        @foreach($courses as $course)
            <option value="{{ $course->id }}">{{ $course->name }}</option>
        @endforeach
    </select>
    <button id="add-course" class="btn btn-success mt-2">Add Course</button>
</div>

<script>
$(document).ready(function () {
    $('#add-course').click(function () {
        var studentId = {{ $student->id }};
        var courseId = $('#new-course').val();

        if (courseId) {
            $.ajax({
                url: '/students/' + studentId + '/add-course',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    course_id: courseId
                },
                success: function (response) {
                    location.reload(); // Reload to show changes
                }
            });
        }
    });

    $('.remove-course').click(function () {
        var studentId = $(this).data('student-id');
        var courseId = $(this).data('course-id');

        $.ajax({
            url: '/students/' + studentId + '/remove-course',
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                course_id: courseId
            },
            success: function (response) {
                location.reload(); 
            }
        });
    });
});
</script>
@endsection
