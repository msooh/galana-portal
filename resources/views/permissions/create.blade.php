@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Permissions') }}</div>

                    <div class="card-body">
                        <!-- Button to trigger the modal -->
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createPermissionModal">
                            Add New Permission
                        </button>

                        <form action="{{ route('permissions.create') }}" method="GET">
                            <div class="form-group">
                                <label for="role_id">Select Role</label>
                                <select name="role_id" id="role_id" class="form-control" onchange="this.form.submit()">
                                    <option value="">Select a role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                        <form action="{{ route('permissions.assign') }}" method="POST">
                            @csrf
                            <input type="hidden" name="role_id" value="{{ request('role_id') }}">

                            <div class="form-group mt-3">
                                <label for="permissions">Permissions <span class="text-danger">*</span></label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="select-all">
                                    <label class="custom-control-label" for="select-all">Give All Permissions</label>
                                </div>
                            </div>

                            <div class="row">
                                @foreach($permissionGroups as $groupName => $permissions)
                                    <div class="col-lg-4 col-md-6 mb-3">
                                        <div class="card h-100 border-0 shadow">
                                            <div class="card-header">
                                                {{ $groupName }}
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    @foreach($permissions->chunk(2) as $chunk)
                                                        <div class="row mb-2">
                                                            @foreach($chunk as $permission)
                                                                <div class="col-md-6">
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" class="custom-control-input" id="permission_{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}" {{ $assignedPermissions->contains($permission->id) ? 'checked' : '' }}>
                                                                        <label class="custom-control-label" for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Assign Permissions</button>
                        </form>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="createPermissionModal" tabindex="-1" role="dialog" aria-labelledby="createPermissionModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createPermissionModalLabel">Add New Permission</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('permissions.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name">Permission Name</label>
                                            <input type="text" name="name" id="name" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="group">Permission Group</label>
                                            <select name="group" id="group" class="form-control">
                                                @foreach($permissionGroups as $groupName => $permissions)
                                                    <option value="{{ $groupName }}">{{ $groupName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save Permission</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>     
            </div>
        </div>
    </div>

    <!-- Include Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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

        // Handle select all checkbox
        $('#select-all').on('change', function () {
            let isChecked = $(this).is(':checked');
            $('input[name="permissions[]"]').prop('checked', isChecked);
        });
    </script>
@endsection
