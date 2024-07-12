@extends('retail::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Stations</div>

                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('stations.create') }}" class="btn btn-primary">Add Station</a>
                    </div>

                    <div class="table-responsive">
                        <table id="stations" class="table table-striped ">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Dealer</th>
                                    <th scope="col">Station Manager</th>
                                    <th scope="col">Territory Manager</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone No.</th>                                    
                                    <th scope="col">Company</th>
                                    <th scope="col">Created at</th>                                    
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stations as $station)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $station->name }}</td>
                                    <td>{{ $station->location ?? '--' }}</td>                                    
                                    <td>{{ $station->dealer ? $station->dealer->name : 'Not Assigned' }}</td>                                    
                                    <td>@if($station->managers->isEmpty())
                                            Not Assigned
                                        @else
                                            @foreach($station->managers as $manager)
                                                {{ $manager->name }}@if(!$loop->last), @endif
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $station->territoryManager ? $station->territoryManager->name : 'Not Assigned' }}</td>
                                    <td>{{ $station->email ?? '--' }}</td>
                                    <td>{{ $station->phone ?? '--' }}</td>                                    
                                    <td>{{ $station->company ? $station->company->name : 'Not Assigned' }}</td>
                                    <td>{{ $station->created_at }}</td>                                    
                                    <td>
                                        @if($station->is_active)
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
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewModal{{ $station->id }}">View</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{ $station->id }}">Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $station->id }}">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                    
                                </tr>
                                  <!-- View Modal -->
                                <div class="modal fade" id="viewModal{{ $station->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $station->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewModalLabel{{ $station->id }}">View Station Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Name:</strong> {{ $station->name }}</p>
                                                <p><strong>Location:</strong> {{ $station->location ?? 'Not Provided' }}</p>
                                                <p><strong>Longitude:</strong> {{ $station->long ?? 'Not Provided' }}</p>
                                                <p><strong>Latitude:</strong> {{ $station->lat ?? 'Not Provided' }}</p>
                                                <p><strong>Dealer:</strong> {{ $station->dealer->name ?? 'Not Assigned' }}</p>
                                                <p><strong>Station Manager:</strong> 
                                                    @if($station->managers->isEmpty())
                                                        Not Assigned
                                                    @else
                                                        @foreach($station->managers as $manager)
                                                            {{ $manager->name }}@if(!$loop->last), @endif
                                                        @endforeach
                                                    @endif
                                                </p>
                                                <p><strong>Territory Manager:</strong> {{ $station->territoryManager->name ?? 'Not Assigned' }}</p>
                                                <p><strong>Email:</strong> {{ $station->email ?? 'Not Provided' }}</p>
                                                <p><strong>Phone:</strong> {{ $station->phone ?? 'Not Provided' }}</p>
                                                <p><strong>Till Number:</strong> {{ $station->till_number ?? 'Not Provided' }}</p>
                                                <p><strong>Company:</strong> {{ $station->company->company_name ?? 'Not Assigned' }}</p>
                                                <p><strong>Start Date:</strong> {{ $station->start_date ? $station->start_date->format('Y-m-d') : 'Not Provided' }}</p>
                                                <p><strong>End Date:</strong> {{ $station->end_date ? $station->end_date->format('Y-m-d') : 'Not Provided' }}</p>
                                                <p><strong>Created By:</strong> {{ $station->createdBy ? $station->createdBy->name : 'N/A' }}</p>
                                                <p><strong>Updated By:</strong> {{ $station->updatedBy ? $station->updatedBy->name : 'N/A' }}</p>
                                                <p><strong>Created At:</strong> {{ $station->created_at->format('Y-m-d H:i:s') }}</p>
                                                <p><strong>Updated At:</strong> {{ $station->updated_at->format('Y-m-d H:i:s') }}</p>
                                                <p><strong>Status:</strong> 
                                                    @if($station->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                               <!-- Edit Modal -->                                                             
                            <div class="modal fade" id="editModal{{ $station->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $station->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $station->id }}">Edit Station Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('stations.update', $station->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <!-- Name Field -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="edit_name{{ $station->id }}" class="form-label">Name</label>
                                                        <input type="text" class="form-control" id="edit_name{{ $station->id }}" name="name" value="{{ $station->name }}" required>
                                                    </div>
                                                    <!-- Location Field -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="edit_location{{ $station->id }}" class="form-label">Location</label>
                                                        <input type="text" class="form-control" id="edit_location{{ $station->id }}" name="location" value="{{ $station->location }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- Dealer Field -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="edit_dealer{{ $station->id }}" class="form-label">Dealer</label>
                                                        <select class="form-select" id="edit_dealer{{ $station->id }}" name="dealer_id" required>
                                                            @foreach($dealers as $dealer)
                                                                <option value="{{ $dealer->id }}" {{ $dealer->id == $station->dealer_id ? 'selected' : '' }}>{{ $dealer->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <!-- Territory Manager Field -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="edit_manager{{ $station->id }}" class="form-label">Territory Manager</label>
                                                        <select class="form-select" id="edit_manager{{ $station->id }}" name="territory_manager_id">
                                                            <option value="" {{ $station->territory_manager_id == null ? 'selected' : '' }}>Not Assigned</option>
                                                            @foreach($tms as $user)
                                                                <option value="{{ $user->id }}" {{ $user->id == $station->territory_manager_id ? 'selected' : '' }}>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                   <!-- Company Field -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="edit_company{{ $station->id }}" class="form-label">Company</label>
                                                        <select class="form-select" id="edit_company{{ $station->id }}" name="company_id">
                                                            <option value="" {{ $station->company_id == null ? 'selected' : '' }}>Not Assigned</option>
                                                            @foreach($companies as $company)
                                                                <option value="{{ $company->id }}" {{ $company->id == $station->company_id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <!-- Email Field -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="edit_email{{ $station->id }}" class="form-label">Email</label>
                                                        <input type="email" class="form-control" id="edit_email{{ $station->id }}" name="email" value="{{ $station->email }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- Phone Field -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="edit_phone{{ $station->id }}" class="form-label">Phone</label>
                                                        <input type="text" class="form-control" id="edit_phone{{ $station->id }}" name="phone" value="{{ $station->phone }}">
                                                    </div>
                                                    <!-- Till Number Field -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="edit_till_number{{ $station->id }}" class="form-label">Till Number</label>
                                                        <input type="text" class="form-control" id="edit_till_number{{ $station->id }}" name="till_number" value="{{ $station->till_number }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                     <!-- Latitude Field -->
                                                     <div class="col-md-6 mb-3">
                                                        <label for="edit_lat{{ $station->id }}" class="form-label">Latitude</label>
                                                        <input type="text" class="form-control" id="edit_lat{{ $station->id }}" name="lat" value="{{ $station->lat }}">
                                                    </div>
                                                    <!-- Longitude Field -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="edit_long{{ $station->id }}" class="form-label">Longitude</label>
                                                        <input type="text" class="form-control" id="edit_long{{ $station->id }}" name="long" value="{{ $station->long }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                   
                                                    <!-- Start Date Field -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="edit_start_date{{ $station->id }}" class="form-label">Start Date</label>
                                                        <input type="date" class="form-control" id="edit_start_date{{ $station->id }}" name="start_date" value="{{ $station->start_date }}">
                                                    </div>
                                                    <!-- End Date Field -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="edit_end_date{{ $station->id }}" class="form-label">End Date</label>
                                                        <input type="date" class="form-control" id="edit_end_date{{ $station->id }}" name="end_date" value="{{ $station->end_date }}">
                                                    </div>
                                                </div>
                                              
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $station->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $station->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $station->id }}">Confirm Deletion</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this station?</p>
                                                <p><strong>Name:</strong> {{ $station->name }}</p>
                                                <p><strong>Location:</strong> {{ $station->location }}</p>
                                                <p><strong>Dealer:</strong> {{ $station->dealer->name ?? 'Not Assigned' }}</p>
                                                <p><strong>Territory Manager:</strong> {{ $station->territoryManager->name ?? 'Not Assigned' }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('stations.destroy', $station->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
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
    new DataTable('#stations');
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
