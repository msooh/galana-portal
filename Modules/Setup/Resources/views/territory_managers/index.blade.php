@extends('retail::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Territory Managers</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="{{ route('territory_managers.create') }}" class="btn btn-primary">Add Territory Manager</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="managers">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Station</th>
                                        <th>Is Active</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($territoryManagers as $manager)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $manager->name }}</td>
                                            <td>{{ $manager->phone_number }}</td>
                                            <td>{{ $manager->email }}</td>
                                            <td>
                                                @foreach($manager->stations as $station)
                                                    {{ $station->name }}@if(!$loop->last), @endif
                                                @endforeach
                                            </td>
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
                                                        @if($manager->stations->isEmpty())
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#assignStationModal{{ $manager->id }}">Assign Station</a>
                                                        @else
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#reassignStationModal{{ $manager->id }}">Re-Assign Station</a>
                                                        @endif
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
                                                        <h5 class="modal-title" id="viewStationManagerModalLabel{{ $manager->id }}">Territory Manager Details</h5>
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
                                                        <div class="form-group">
                                                            <label for="modalStation">Station:</label>
                                                            @if($manager->managedStations->isEmpty())
                                                                <input type="text" class="form-control" id="modalStation" value="No station assigned" readonly>
                                                            @else
                                                                <input type="text" class="form-control" id="modalStation" value="{{ $manager->managedStations->pluck('name')->join(', ') }}" readonly>
                                                            @endif
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
                                                        <h5 class="modal-title" id="editStationManagerModalLabel{{ $manager->id }}">Edit Territory Manager</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('territory_managers.update', $manager->id) }}" method="POST">
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
                                        <!-- Assign Station Modal -->
                                        <div class="modal fade" id="assignStationModal{{ $manager->id }}" tabindex="-1" aria-labelledby="assignStationModalLabel{{ $manager->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="assignStationModalLabel{{ $manager->id }}">Assign Station to {{ $manager->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('territory_managers.assign_station', $manager->id) }}" method="POST">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label for="station_id{{ $manager->id }}" class="form-label">Select Station</label>
                                                                <select data-mdb-select-init multiple data-mdb-placeholder="Select Stations" class="form-control" id="station_ids" name="station_ids[]">
                                                                    @foreach($stations as $station)
                                                                        <option value="{{ $station->id }}" {{ in_array($station->id, $manager->stations->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                                            {{ $station->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Assign Station</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Re-Assign Station Modal -->
                                        <div class="modal fade" id="reassignStationModal{{ $manager->id }}" tabindex="-1" aria-labelledby="reassignStationModalLabel{{ $manager->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="reassignStationModalLabel{{ $manager->id }}">Re-Assign Station for {{ $manager->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('territory_managers.reassign_station', $manager->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="mb-3">
                                                                
                                                                <label for="reassign_station_id{{ $manager->id }}" class="form-label">Select New Station</label>
                                                                <select data-mdb-select-init multiple data-mdb-placeholder="Select Stations" class="form-control" id="station_ids" name="station_ids[]">
                                                                    @foreach($stations as $station)
                                                                        <option value="{{ $station->id }}" {{ in_array($station->id, $manager->stations->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                                            {{ $station->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>                                                                
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Re-Assign Station</button>
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
                                                        <form action="{{ route('setup::territory_managers.deactivate', $manager->id) }}" method="POST">
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
    <!-- Include Bootstrap 5 JS -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script>
        new DataTable('#managers');
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
