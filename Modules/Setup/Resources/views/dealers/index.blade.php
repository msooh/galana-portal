@extends('setup::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dealers List</div>

                    <div class="card-body">
                        <div class="mb-3">
                            <a href="{{ route('dealers.create') }}" class="btn btn-primary">Add Dealer</a>
                        </div>
                        <div class="table-responsive">
                        <table id="dealers" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>                                   
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dealers as $dealer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>                                                                              
                                        <td>{{ $dealer->name }}</td>
                                        <td>{{ $dealer->phone_number ?? '--' }}</td> 
                                        <td>{{ $dealer->email }}</td>                                       
                 
                                        <td>
                                            @if($dealer->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif                                            
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewDealerModal{{ $dealer->id }}">View</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editDealerModal{{ $dealer->id }}">Edit</a>
                                                    <div class="dropdown-divider"></div>
                                                    @if ($dealer->is_active)
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#deactivateDealerModal{{ $dealer->id }}">Deactivate</a>
                                                    @else
                                                        <form action="{{ route('setup::dealers.activate', $dealer->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="dropdown-item">Activate</button>
                                                        </form>
                                                    @endif
                                                   
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!--View Modal -->
                                    <div class="modal fade" id="viewDealerModal{{ $dealer->id }}" tabindex="-1" role="dialog" aria-labelledby="viewDealerModalLabel{{ $dealer->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewDealerModalLabel{{ $dealer->id }}">Dealer Details</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                     <!--<div class="form-group">
                                                        <label for="modalName">Company Name:</label>
                                                        <input type="text" class="form-control" id="modalName" value="" readonly>
                                                    </div>-->
                                                    <div class="form-group">
                                                        <label for="modalName">Name:</label>
                                                        <input type="text" class="form-control" id="modalName" value="{{ $dealer->name }}" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="modalPhone">Phone:</label>
                                                        <input type="text" class="form-control" id="modalPhone" value="{{ $dealer->phone_number }}" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="modalEmail">Email:</label>
                                                        <input type="text" class="form-control" id="modalEmail" value="{{ $dealer->email }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <!-- Edit Modal -->
                                     <div class="modal fade" id="editDealerModal{{ $dealer->id }}" tabindex="-1" role="dialog" aria-labelledby="editDealerModalLabel{{ $dealer->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editDealerModalLabel{{ $dealer->id }}">Edit Dealer</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('dealers.update', $dealer->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <!--<div class="form-group">
                                                            <label for="editCompanyName">Company Name:</label>
                                                            <input type="text" class="form-control" id="editCompanyName" name="company_name" value="">
                                                        </div>-->
                                                        <div class="form-group">
                                                            <label for="editName">Name:</label>
                                                            <input type="text" class="form-control" id="editName" name="name" value="{{ $dealer->name }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editPhone">Phone:</label>
                                                            <input type="text" class="form-control" id="editPhone" name="phone" value="{{ $dealer->phone_number }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editEmail">Email:</label>
                                                            <input type="email" class="form-control" id="editEmail" name="email" value="{{ $dealer->email }}">
                                                        </div>
                                                                                                              
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deactivateDealerModal{{ $dealer->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteDealerModalLabel{{ $dealer->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deactivateDealerModalLabel{{ $dealer->id }}">Deactivate Dealer</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to deactivate {{$dealer->name}} ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('setup::dealers.deactivate', $dealer->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">Deactivate</button>
                                                    </form>
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
    new DataTable('#dealers');
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
