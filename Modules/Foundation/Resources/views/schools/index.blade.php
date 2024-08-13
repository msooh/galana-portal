@extends('foundation::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Schools List</div>

                    <div class="card-body">
                        <div class="mb-3">
                            <a href="{{ route('schools.create') }}" class="btn btn-primary">Add School</a>
                        </div>
                        <div class="table-responsive" >
                        <table id="schools" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>                             
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schools as $school)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>                                                                              
                                        <td>{{ $school->name }}</td>
                                        <td>{{ $school->location }}</td>                                  
                                                                                                   
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewSchoolModal{{ $school->id }}">View</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editSchoolModal{{ $school->id }}">Edit</a>
                                                    <div class="dropdown-divider"></div>                                                  
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!--View Modal -->
                                    <div class="modal fade" id="viewSchoolModal{{ $school->id }}" tabindex="-1" role="dialog" aria-labelledby="viewSchoolModalLabel{{ $school->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewSchoolModalLabel{{ $school->id }}">School Details</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">                                                   
                                                    <div class="form-group">
                                                        <label for="modalName">Name:</label>
                                                        <input type="text" class="form-control" id="modalName" value="{{ $school->name }}" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="modalPhone">Location:</label>
                                                        <input type="text" class="form-control" id="modalPhone" value="{{ $school->location }}" readonly>
                                                    </div>
                                                    
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <!-- Edit Modal -->
                                    <div class="modal fade" id="editSchoolModal{{ $school->id }}" tabindex="-1" role="dialog" aria-labelledby="editSchoolModalLabel{{ $school->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editSchoolModalLabel{{ $school->id }}">Edit School</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('schools.update', $school->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name">School Name</label>
                                                            <input type="text" name="name" class="form-control" id="name" value="{{ $school->name }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="location">Location</label>
                                                            <input type="text" name="location" class="form-control" id="location" value="{{ $school->location }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
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
    new DataTable('#schools');
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
