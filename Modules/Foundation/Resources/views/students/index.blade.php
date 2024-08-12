@extends('foundation::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Students</div>

                <div class="card-body">                    
                    <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">Add New Student</a>
                    
                    <table class="table table-bordered" id="students">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>County</th>
                                <th>Sub-County</th>
                                <th>Location</th>
                                <th>School</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->county }}</td>
                                    <td>{{ $student->sub_county }}</td>
                                    <td>{{ $student->location }}</td>
                                    <td>{{ $student->school->name }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewModal{{ $student->id }}">View</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{ $student->id }}">Edit</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- View Modal -->
                                <div class="modal fade" id="viewModal{{ $student->id }}" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $student->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewModalLabel{{ $student->id }}">View Student</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Name:</strong> {{ $student->name }}</p>
                                                <p><strong>County:</strong> {{ $student->county }}</p>
                                                <p><strong>Sub-County:</strong> {{ $student->sub_county }}</p>
                                                <p><strong>Location:</strong> {{ $student->location }}</p>
                                                <p><strong>Father's Name:</strong> {{ $student->father_name ?: 'N/A' }}</p>
                                                <p><strong>Father's Phone:</strong> {{ $student->father_phone ?: 'N/A' }}</p>
                                                <p><strong>Mother's Name:</strong> {{ $student->mother_name ?: 'N/A' }}</p>
                                                <p><strong>Mother's Phone:</strong> {{ $student->mother_phone ?: 'N/A' }}</p>
                                                <p><strong>Guardian's Name:</strong> {{ $student->guardian_name ?: 'N/A' }}</p>
                                                <p><strong>Guardian's Phone:</strong> {{ $student->guardian_phone ?: 'N/A' }}</p>
                                                <p><strong>School:</strong> {{ $student->school->name ?? 'N/A' }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                              <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $student->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $student->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{ $student->id }}">Edit Student</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('students.update', $student->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="name">Student Name</label>
                                                                <input type="text" name="name" class="form-control" id="name" value="{{ $student->name }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="county">County</label>
                                                                <input type="text" name="county" class="form-control" id="county" value="{{ $student->county }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="sub_county">Sub-County</label>
                                                                <input type="text" name="sub_county" class="form-control" id="sub_county" value="{{ $student->sub_county }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="location">Location</label>
                                                                <input type="text" name="location" class="form-control" id="location" value="{{ $student->location }}" required>
                                                            </div>
                                                                                                               
                                                            <div class="form-group">
                                                                <label for="father_name">Father's Name</label>
                                                                <input type="text" name="father_name" class="form-control" id="father_name" value="{{ $student->father_name }}">
                                                            </div>                                                           
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="father_phone">Father's Phone</label>
                                                                <input type="text" name="father_phone" class="form-control" id="father_phone" value="{{ $student->father_phone }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="mother_name">Mother's Name</label>
                                                                <input type="text" name="mother_name" class="form-control" id="mother_name" value="{{ $student->mother_name }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="mother_phone">Mother's Phone</label>
                                                                <input type="text" name="mother_phone" class="form-control" id="mother_phone" value="{{ $student->mother_phone }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="guardian_name">Guardian's Name</label>
                                                                <input type="text" name="guardian_name" class="form-control" id="guardian_name" value="{{ $student->guardian_name }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="guardian_phone">Guardian's Phone</label>
                                                                <input type="text" name="guardian_phone" class="form-control" id="guardian_phone" value="{{ $student->guardian_phone }}">
                                                            </div>                                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="school_id">School</label>
                                                            <select name="school_id" class="form-select" id="school_id" required>
                                                                @foreach($schools as $school)
                                                                    <option value="{{ $school->id }}" {{ $student->school_id == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary mt-3">Update Student</button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Include Bootstrap 5 JS -->
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

<script>
    new DataTable('#students');
</script>
    <script>
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
        @endif
        
        @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: '{!! implode('\\n', $errors->all()) !!}',
            confirmButtonText: 'OK'
        });
        @endif
    </script>
@endsection
