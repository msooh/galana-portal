@extends('foundation::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Bank Details</div>

                <div class="card-body">
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createBankDetailModal">
                        Add Bank Details
                    </button>
                    <div class="table-responsive">
                        <table id="details" class="table table-striped">                     
                            <thead>
                                <tr>
                                    <th>School</th>
                                    <th>Bank</th>
                                    <th>Account Number</th>
                                    <th>Account Name</th>
                                    <th>Branch</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bankDetails as $detail)
                                <tr>
                                    <td>{{ $detail->school->name }}</td>
                                    <td>{{ $detail->bank }}</td>
                                    <td>{{ $detail->account_no }}</td>
                                    <td>{{ $detail->account_name }}</td>
                                    <td>{{ $detail->branch }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewBankDetailModal{{ $detail->id }}">View</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editBankDetailModal{{ $detail->id }}">Edit</a>
                                            </div>
                                        </div>                                   
                                    </td>
                                </tr>

                                <!-- View Bank Detail Modal -->
                                <div class="modal fade" id="viewBankDetailModal{{ $detail->id }}" tabindex="-1" role="dialog" aria-labelledby="viewBankDetailModalLabel{{ $detail->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewBankDetailModalLabel{{ $detail->id }}">View Bank Detail</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Bank:</strong> {{ $detail->bank }}</p>
                                                <p><strong>Account Number:</strong> {{ $detail->account_no }}</p>
                                                <p><strong>Account Name:</strong> {{ $detail->account_name }}</p>
                                                <p><strong>Branch:</strong> {{ $detail->branch }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Bank Detail Modal -->
                                <div class="modal fade" id="editBankDetailModal{{ $detail->id }}" tabindex="-1" role="dialog" aria-labelledby="editBankDetailModalLabel{{ $detail->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editBankDetailModalLabel{{ $detail->id }}">Edit Bank Detail</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('bank-details.update', $detail->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="form-group">
                                                        <label for="bank">Bank</label>
                                                        <input type="text" name="bank" class="form-control" id="bank" value="{{ $detail->bank }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="account_no">Account Number</label>
                                                        <input type="text" name="account_no" class="form-control" id="account_no" value="{{ $detail->account_no }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="account_no">Account Name</label>
                                                        <input type="text" name="account_name" class="form-control" id="account_name" value="{{ $detail->account_name }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="branch">Branch</label>
                                                        <input type="text" name="branch" class="form-control" id="branch" value="{{ $detail->branch }}" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-3">Update Bank Detail</button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
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

<!-- Create Bank Detail Modal -->
<div class="modal fade" id="createBankDetailModal" tabindex="-1" role="dialog" aria-labelledby="createBankDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBankDetailModalLabel">Add Bank Detail</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('bank-details.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="school_id">School</label>
                        <select name="school_id" class="form-select" id="school_id" required>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bank">Bank</label>
                        <input type="text" name="bank" class="form-control" id="bank" required>
                    </div>
                    <div class="form-group">
                        <label for="account_no">Account Number</label>
                        <input type="text" name="account_no" class="form-control" id="account_no" required>
                    </div>
                    <div class="form-group">
                        <label for="account_no">Account Name</label>
                        <input type="text" name="account_name" class="form-control" id="account_name" required>
                    </div>
                    <div class="form-group">
                        <label for="branch">Branch</label>
                        <input type="text" name="branch" class="form-control" id="branch" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Add Bank Detail</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    new DataTable('#details');
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
