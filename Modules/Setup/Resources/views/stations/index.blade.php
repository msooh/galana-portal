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
                        <table class="table table-striped ">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Dealer</th>
                                    <th scope="col">Station Manager</th>
                                    <th scope="col">Territory Manager</th>
                                    <th scope="col">Created By</th>
                                    <th scope="col">Updated By</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Updated At</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stations as $index => $station)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $station->name }}</td>
                                    <td>{{ $station->location }}</td>
                                    <td>{{ $station->dealer->name }}</td>
                                    <td>{{ $station->stationManager->name ?? 'Not Assigned' }}</td>
                                    <td>{{ $station->territoryManager->name ?? 'Not Assigned' }}</td>
                                    <td>  @if($station->createdBy)
                                        {{ $station->createdBy->name }}
                                    @else
                                        N/A
                                    @endif</td>
                                    <td>  @if($station->createdBy)
                                        {{ $station->updatedBy->name }}
                                    @else
                                        N/A
                                    @endif</td>
                                    <td>{{ $station->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>{{ $station->updated_at->format('Y-m-d H:i:s') }}</td>
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
                                                <p><strong>Location:</strong> {{ $station->location }}</p>
                                                <p><strong>Dealer:</strong> {{ $station->dealer->name }}</p>
                                                <p><strong>Station Manager:</strong> {{ $station->stationManager ? $station->stationManager->name : 'Not Assigned' }}</p>
                                                <p><strong>Territory Manager:</strong> {{ $station->territoryManager->name ?? 'Not Assigned' }}</p>
                                                <p><strong>Created By:</strong> {{ $station->createdBy ? $station->createdBy->name : 'N/A' }}</p>
                                                <p><strong>Updated By:</strong> {{ $station->updatedBy ? $station->updatedBy->name : 'N/A' }}</p>
                                                <p><strong>Created At:</strong> {{ $station->created_at->format('Y-m-d H:i:s') }}</p>
                                                <p><strong>Updated At:</strong> {{ $station->updated_at->format('Y-m-d H:i:s') }}</p>
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
                                                    <!-- Name Field -->
                                                    <div class="mb-3">
                                                        <label for="edit_name{{ $station->id }}" class="form-label">Name</label>
                                                        <input type="text" class="form-control" id="edit_name{{ $station->id }}" name="name" value="{{ $station->name }}" required>
                                                    </div>
                                                    <!-- Location Field -->
                                                    <div class="mb-3">
                                                        <label for="edit_location{{ $station->id }}" class="form-label">Location</label>
                                                        <input type="text" class="form-control" id="edit_location{{ $station->id }}" name="location" value="{{ $station->location }}">
                                                    </div>
                                                    <!-- Dealer Field -->
                                                    <div class="mb-3">
                                                        <label for="edit_dealer{{ $station->id }}" class="form-label">Dealer</label>
                                                        <select class="form-select" id="edit_dealer{{ $station->id }}" name="dealer_id" required>
                                                            @foreach($dealers as $dealer)
                                                                <option value="{{ $dealer->id }}" {{ $dealer->id == $station->dealer_id ? 'selected' : '' }}>{{ $dealer->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <!-- Territory Manager Field -->
                                                    <div class="mb-3">
                                                        <label for="edit_manager{{ $station->id }}" class="form-label">Territory Manager</label>
                                                        <select class="form-select" id="edit_manager{{ $station->id }}" name="territory_manager_id">
                                                            <option value="" {{ $station->territory_manager_id == null ? 'selected' : '' }}>Not Assigned</option>
                                                            @foreach($users as $user)
                                                                <option value="{{ $user->id }}" {{ $user->id == $station->territory_manager_id ? 'selected' : '' }}>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <!-- Station Manager Field -->
                                                    <div class="mb-3">
                                                        <label for="edit_station_manager{{ $station->id }}" class="form-label">Station Manager</label>
                                                        <select class="form-select" id="edit_station_manager{{ $station->id }}" name="station_manager_id">
                                                            <option value="" {{ $station->station_manager_id == null ? 'selected' : '' }}>Not Assigned</option>
                                                            @foreach($managers as $manager)
                                                                <option value="{{ $manager->id }}" {{ $manager->id == $station->station_manager_id ? 'selected' : '' }}>{{ $manager->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <!-- Add more fields as needed -->
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
                                                <p><strong>Dealer:</strong> {{ $station->dealer->name }}</p>
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
