@extends('setup::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Other Locations</h4>                    
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLocationModal">Add Other Location</button>
                    </div>
                    
                   
                    <div class="table-responsive">
                        <table class="table table-striped ">
                            <thead class="table-dark">
                            <tr>
                                <th>Name</th>
                                <th>Location Details</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($locations as $location)
                                <tr>
                                    <td>{{ $location->name }}</td>
                                    <td>{{ $location->location_details }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewModal{{ $location->id }}">View</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editLocationModal{{ $location->id }}">Edit</a>
                                                <div class="dropdown-divider"></div>                                               
                                            </div>
                                        </div>

                                    </td>
                                </tr>

                                <!-- Edit Location Modal -->
                                <div class="modal fade" id="editLocationModal{{ $location->id }}" tabindex="-1" aria-labelledby="editLocationModalLabel{{ $location->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editLocationModalLabel{{ $location->id }}">Edit Location</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('locations.update', $location->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="name{{ $location->id }}" class="form-label">Name</label>
                                                        <input type="text" class="form-control" id="name{{ $location->id }}" name="name" value="{{ $location->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="location_details{{ $location->id }}" class="form-label">Location Details</label>
                                                        <textarea class="form-control" id="location_details{{ $location->id }}" name="location_details" required>{{ $location->location_details }}</textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update Location</button>
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

<!-- Add Location Modal -->
<div class="modal fade" id="addLocationModal" tabindex="-1" aria-labelledby="addLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLocationModalLabel">Add Other Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('locations.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="location_details" class="form-label">Location Details</label>
                        <textarea class="form-control" id="location_details" name="location_details" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Location</button>
                </form>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
