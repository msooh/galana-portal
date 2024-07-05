@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Users') }}</div>

                    <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone_number ?? '--' }}</td>
                                    <td>
                                        @if($user->roles->isNotEmpty())
                                            @foreach($user->roles as $role)
                                                {{ $role->name }}
                                                @if(!$loop->last),@endif
                                            @endforeach
                                        @else
                                            No Role Assigned
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewUserModal{{ $user->id }}">View</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">Edit</a>
                                                <div class="dropdown-divider"></div>
                                                @if($user->is_active)
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#deactivateUserModal{{ $user->id }}">Deactivate</a>
                                                @else
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#activateUserModal{{ $user->id }}">Activate</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- View User Modal -->
                                <div class="modal fade" id="viewUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="viewUserModal{{ $user->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewUserModal{{ $user->id }}Label">View User: {{ $user->name }}</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Name:</strong> {{ $user->name }}</p>
                                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                                <p><strong>Phone:</strong> {{ $user->phone_number }}</p>
                                                <p><strong>Roles:</strong>
                                                    @if($user->roles->isNotEmpty())
                                                        @foreach($user->roles as $role)
                                                            {{ $role->name }}
                                                            @if(!$loop->last),@endif
                                                        @endforeach
                                                    @else
                                                        No Role Assigned
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit User Modal -->
                                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editUserModal{{ $user->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editUserModal{{ $user->id }}Label">Edit User: {{ $user->name }}</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('users.update', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                
                                                    <div class="mb-3">
                                                        <label for="edit_name">Name</label>
                                                        <input type="text" class="form-control" id="edit_name" name="edit_name" value="{{ $user->name }}">
                                                    </div>
                                
                                                    <div class="mb-3">
                                                        <label for="edit_email">Email</label>
                                                        <input type="email" class="form-control" id="edit_email" name="edit_email" value="{{ $user->email }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="edit_phone">Phone Number</label>
                                                        <input type="text" class="form-control" id="edit_phone" name="edit_phone" value="{{ $user->phone_number }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="edit_password">Password</label>
                                                        <input type="password" class="form-control" id="edit_password" name="edit_password" placeholder="Leave blank to keep current password">
                                                    </div>
                                
                                                    <div class="mb-3">
                                                        <label for="edit_role">Role</label>
                                                        <select class="form-select" id="edit_role" name="edit_role">
                                                            @foreach($roles as $role)
                                                                <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                                                            @endforeach
                                                        </select>
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

                                <!-- Deactivate User Modal -->
                                <div class="modal fade" id="deactivateUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="deactivateUserModal{{ $user->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deactivateUserModal{{ $user->id }}Label">Deactivate User: {{ $user->name }}</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to deactivate this user?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('users.deactivate', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Deactivate</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Activate User Modal -->
                                <div class="modal fade" id="activateUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="activateUserModal{{ $user->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="activateUserModal{{ $user->id }}Label">Activate User: {{ $user->name }}</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to activate this user?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('users.activate', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Activate</button>
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
@endsection
