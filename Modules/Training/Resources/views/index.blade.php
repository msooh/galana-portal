@extends('training::layouts.master')

@section('content')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Training Records</div>
                <div class="card-body">
                    <a href="{{ route('training.create') }}" class="btn btn-primary mb-3">Add Training</a>
                    <div class="table-responsive">
                        <table id="training-records" class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th> 
                                    <th>Employee</th>
                                    <th>Training Facility</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Cost (KES)</th>
                                    <th>Certificate</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trainings as $index => $training)
                                <tr>
                                    <td>{{ $index + 1 }}</td> 
                                    <td>{{ $training->user->name }}</td>
                                    <td>{{ $training->training_facility }}</td>
                                    <td>{{ $training->start_date }}</td>
                                    <td>{{ $training->end_date }}</td>
                                    <td>{{ number_format($training->cost, 2) }}</td>
                                    <td>
                                        @if($training->certificate)
                                            <a href="{{ asset('storage/' . $training->certificate) }}" target="_blank">View</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('training.destroy', $training->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- DataTables Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#training-records').DataTable({
            "ordering": true,    
            "paging": true,      
            "searching": true,   
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]], 
            "columnDefs": [
                { "orderable": false, "targets": [0, 6, 7] } 
            ]
        });
    });
</script>

@endsection
