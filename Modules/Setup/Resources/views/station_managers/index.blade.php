@extends('retail::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Station Managers</div>
                    <div class="card-body">
                        <!--<div class="mb-3">
                            <a href="{{ route('station_managers.create') }}" class="btn btn-primary">Add Station Manager</a>
                        </div>-->
                        <div class="table-responsive">
                        <table class="table table-striped">                            
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>                                    
                                    <th>Is Active</th>                  
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stationManagers as $manager)
                                    <tr>
                                        <td>{{ $manager->name }}</td>
                                        <td>{{ $manager->phone_number }}</td>
                                        <td>{{ $manager->email }}</td>                                        
                                        <td>
                                            @if($manager->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>                      
                                        <td>
                                           <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewStationManagerModal{{ $manager->id }}">View</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editStationManagerModal{{ $manager->id }}">Edit</a>
                                                    <div class="dropdown-divider"></div>
                                                    @if ($manager->is_active)
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#deactivateStationManagerModal{{ $manager->id }}">Deactivate</a>
                                                    @else
                                                        <form action="{{ route('setup::station_managers.activate', $manager->id) }}" method="POST">
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
                                    <div class="modal fade" id="viewStationManagerModal{{ $manager->id }}" tabindex="-1" role="dialog" aria-labelledby="viewStationManagerModalLabel{{ $manager->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewStationManagerModalLabel{{ $manager->id }}">Station Manager Details</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="modalName">Name:</label>
                                                        <input type="text" class="form-control" id="modalName" value="{{ $manager->name }}" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="modalPhone">Phone:</label>
                                                        <input type="text" class="form-control" id="modalPhone" value="{{ $manager->phone_number }}" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="modalEmail">Email:</label>
                                                        <input type="text" class="form-control" id="modalEmail" value="{{ $manager->email }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                      <!-- Edit Modal -->
                                     <div class="modal fade" id="editStationManagerModal{{ $manager->id }}" tabindex="-1" role="dialog" aria-labelledby="editStationManagerModalLabel{{ $manager->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editStationManagerModalLabel{{ $manager->id }}">Edit Station Manager</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('station_managers.update', $manager->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                      
                                                        <div class="form-group">
                                                            <label for="editName">Name:</label>
                                                            <input type="text" class="form-control" id="editName" name="name" value="{{ $manager->name }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editPhone">Phone:</label>
                                                            <input type="text" class="form-control" id="editPhone" name="phone" value="{{ $manager->phone_number }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editEmail">Email:</label>
                                                            <input type="email" class="form-control" id="editEmail" name="email" value="{{ $manager->email }}">
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
                                    <!-- Deactivate Modal -->
                                    <div class="modal fade" id="deactivateStationManagerModal{{ $manager->id }}" tabindex="-1" aria-labelledby="deactivateStationManagerModalLabel{{ $manager->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deactivateStationManagerModalLabel{{ $manager->id }}">Deactivate Station Manager</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to deactivate {{ $manager->name }}?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <form action="{{ route('setup::station_managers.deactivate', $manager->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
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
