@extends('foundation::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Performance Records</div>

                <div class="card-body">
                    <!-- Button to open the create modal -->
                    @can('create-performance')
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
                            Add Performance Record
                        </button>
                    @endcan
                    <div class="table-responsive">
                        <table id="performances" class="table table-striped">                   
                            <thead class="table-dark">                    
                                <tr>
                                    <th>Student Name</th>
                                    <th>Year</th>
                                    <th>Term</th>
                                    <th>Mid Term Mean Score</th>
                                    <th>Mid Term Grade</th>
                                    <th>Mid Term Position</th>
                                    <th>End Term Mean Score</th>
                                    <th>End Term Grade</th>
                                    <th>End Term Position</th>
                                    @can('Manage Performance')
                                        <th>Actions</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($performances as $performance)
                                    <tr>
                                        <td>{{ $performance->student->name }}</td>
                                        <td>{{ $performance->year }}</td>
                                        <td>{{ $performance->term }}</td>
                                        <td>{{ $performance->mid_mean_score }}%</td>
                                        <td>{{ $performance->mid_term_grade }}</td>
                                        <td>{{ $performance->mid_term_position }}</td>
                                        <td>{{ $performance->end_term_mean_score }}%</td>
                                        <td>{{ $performance->end_term_grade }}</td>
                                        <td>{{ $performance->end_term_position }}</td>
                                        @can('Manage Performance')
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" data-bs-toggle="modal" href="#viewModal{{ $performance->id }}">View</a></li>
                                                        <li><a class="dropdown-item" data-bs-toggle="modal" href="#editModal{{ $performance->id }}">Edit</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        @endcan
                                    </tr>

                                    <!-- View Modal -->
                                    <div class="modal fade" id="viewModal{{ $performance->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $performance->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewModalLabel{{ $performance->id }}">View Performance Record</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Student Name:</strong> {{ $performance->student->name }}</p>
                                                    <p><strong>Year:</strong> {{ $performance->year }}</p>
                                                    <p><strong>Term:</strong> {{ $performance->term }}</p>
                                                    <p><strong>Mid Term Mean Score:</strong> {{ $performance->mid_mean_score }}</p>
                                                    <p><strong>Mid Term Position:</strong> {{ $performance->mid_term_position ?? 'N/A' }}</p>
                                                    <p><strong>End Term Mean Score:</strong> {{ $performance->end_term_mean_score }}</p>
                                                    <p><strong>End Term Position:</strong> {{ $performance->end_term_position ?? 'N/A' }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $performance->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $performance->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $performance->id }}">Edit Performance Record</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('performances.update', $performance->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="form-group">
                                                            <label for="student_id">Student</label>
                                                            <select name="student_id" class="form-control" id="student_id" required>
                                                                @foreach($students as $student)
                                                                    <option value="{{ $student->id }}" {{ $performance->student_id == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="year">Year</label>
                                                            <select name="year" class="form-control" id="year" required>
                                                                <option value="1" {{ $performance->year == '1' ? 'selected' : '' }}>1</option>
                                                                <option value="2" {{ $performance->year == '2' ? 'selected' : '' }}>2</option>
                                                                <option value="3" {{ $performance->year == '3' ? 'selected' : '' }}>3</option>
                                                                <option value="4" {{ $performance->year == '4' ? 'selected' : '' }}>4</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="term">Term</label>
                                                            <select name="term" class="form-control" id="term" required>
                                                                <option value="1" {{ $performance->term == '1' ? 'selected' : '' }}>1</option>
                                                                <option value="2" {{ $performance->term == '2' ? 'selected' : '' }}>2</option>
                                                                <option value="3" {{ $performance->term == '3' ? 'selected' : '' }}>3</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="mid_mean_score">Mid Term Mean Score</label>
                                                            <input type="number" step="0.01" name="mid_mean_score" class="form-control" id="mid_mean_score" value="{{ $performance->mid_mean_score }}" required>
                                                        </div>

                                                        <!-- Mid-Term Position -->
                                                        <div class="form-group">
                                                            <label for="mid_term_position">Mid-Term Position</label>
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" id="mid_term_position" name="mid_term_position_number" value="{{ explode(' out of ', $performance->mid_term_position)[0] }}" placeholder="Position" required>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">out of</span>
                                                                </div>
                                                                <input type="number" class="form-control" id="mid_term_position_total" name="mid_term_position_total" value="{{ explode(' out of ', $performance->mid_term_position)[1] }}" placeholder="Total Students" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="end_term_mean_score">End Term Mean Score</label>
                                                            <input type="number" step="0.01" name="end_term_mean_score" class="form-control" id="end_term_mean_score" value="{{ $performance->end_term_mean_score }}" required>
                                                        </div>

                                                        <!-- End-Term Position -->
                                                        <div class="form-group">
                                                            <label for="end_term_position">End-Term Position</label>
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" id="end_term_position" name="end_term_position_number" value="{{ explode(' out of ', $performance->end_term_position)[0] }}" placeholder="Position" required>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">out of</span>
                                                                </div>
                                                                <input type="number" class="form-control" id="end_term_position_total" name="end_term_position_total" value="{{ explode(' out of ', $performance->end_term_position)[1] }}" placeholder="Total Students" required>
                                                            </div>
                                                        </div>

                                                        <button type="submit" class="btn btn-primary mt-3">Update Performance Record</button>
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
    new DataTable('#performances');
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
