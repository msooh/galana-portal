@extends('retail::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Checklist Items</div>

                <div class="card-body">
                    <a href="{{ route('checklists.create') }}" class="btn btn-primary mb-3">Add Checklist Item</a>
                 <div class="table-responsive">
                    <table class="table table-striped" id="checklists">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($checklists as $index => $checklist)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $checklist->name }}</td>
                                <td>{{ $checklist->subcategory->category->name }}</td>
                                <td>{{ $checklist->subcategory->name ?? 'No Subcategory' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{ $checklist->id }}">Edit</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $checklist->id }}">Delete</a></li>
                                        </ul>
                                    </div>                                    
                                </td>
                            </tr>
                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $checklist->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $checklist->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $checklist->id }}">Edit Checklist Item</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('checklists.update', $checklist->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group mb-3">
                                                        <label for="edit_name">Name</label>
                                                        <input type="text" class="form-control" id="edit_name" name="name" value="{{ $checklist->name }}" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="edit_category">Category</label>
                                                        <input type="text" class="form-control" id="edit_category" value="{{ $checklist->subcategory->category->name }}" readonly>
                                                        <input type="hidden" name="category_id" value="{{ $checklist->subcategory->category_id }}">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="edit_subcategory">Subcategory</label>
                                                        <input type="text" class="form-control" id="edit_subcategory" value="{{ $checklist->subcategory->name }}" readonly>
                                                        <input type="hidden" name="subcategory_id" value="{{ $checklist->sub_category_id }}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">                                                    
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>                                
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $checklist->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $checklist->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $checklist->id }}">Confirm Deletion</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this checklist item?</p>
                                            <p><strong>Name:</strong> {{ $checklist->name }}</p>
                                            <p><strong>Category:</strong> {{ $checklist->subcategory->category->name ?? 'No Category' }}</p>
                                            <p><strong>Sub Category:</strong> {{ $checklist->subcategory->name ?? 'No Subcategory' }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('checklists.destroy', $checklist->id) }}" method="POST">
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

<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    new DataTable('#checklists');
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
