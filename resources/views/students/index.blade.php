@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Student List</h2>
    <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">Add Student</a>
    <!-- Search Form -->
    <form action="{{ route('students.index') }}" method="GET">
        <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name or email" value="{{ request()->search }}">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    
                    <td>
                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>

                        <!-- Add Course Button -->
                        <button class="btn btn-success btn-sm add-course" data-student-id="{{ $student->id }}" data-toggle="modal" data-target="#courseModal">Add Course</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $students->links() }} <!-- Laravel pagination links -->
</div>

<!-- Add Course Modal -->
<div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="courseModalLabel">Add Course to Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <select id="course-select" class="form-control">
            <option value="">Select Course</option>
        
        </select>
        <div class="text-center mt-3">
            <button id="add-course-btn" class="btn btn-primary">Add Course</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {
    // Store student ID for adding course
    var studentId;

    // Open modal to add course
    $('.add-course').click(function () {
        studentId = $(this).data('student-id');
    });

    // Add course to student
    $('#add-course-btn').click(function () {
        var courseId = $('#course-select').val();

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
                    $('#courseModal').modal('hide'); // Close modal
                }
            });
        }
    });
});
</script>
@endsection
