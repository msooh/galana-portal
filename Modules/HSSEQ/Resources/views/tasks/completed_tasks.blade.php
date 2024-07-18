@extends('hsseq::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Tasks Closed by Me</div>

                <div class="card-body">                   

                    <div class="table-responsive">
                        <table class="table table-striped" id="closed">
                            <thead class="table-dark">
                                <tr>
                                    <th>Type</th>
                                    <th>Station</th>
                                    <th>Reporting Date</th>
                                    <th>Reporting Time</th>
                                    <th>Assigned By</th>
                                    <th>Assigned At</th>
                                    <th>Closed At</th>
                                    <th>Notes</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($closedTasks as $task)
                                <tr>
                                    <td>{{ $task->type }}</td>
                                    <td>{{ $task->station->name }}</td>
                                    <td>{{ $task->date }}</td>
                                    <td>{{ $task->time }}</td>
                                    <td>{{ $task->updatedBy->name ?? 'Null' }}</td>
                                    <td>{{ $task->assigned_at }}</td>
                                    <td>{{ $task->updated_at }}</td>
                                    <td>{{ $task->notes }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewDetailsModal{{ $task->id }}">
                                            Details
                                        </button>                                  
                                    
                                    <!-- View Details Modal -->
                                    <div class="modal fade" id="viewDetailsModal{{ $task->id }}" tabindex="-1" aria-labelledby="viewDetailsModalLabel{{ $task->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewDetailsModalLabel{{ $task->id }}">Task Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <th>Type:</th>
                                                                <td>{{ $task->type }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Station:</th>
                                                                <td>{{ $task->station->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Date Reported:</th>
                                                                <td>{{ $task->date }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Time Reported:</th>
                                                                <td>{{ $task->time }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Comment:</th>
                                                                <td>{{ $task->comment }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Action Taken:</th>
                                                                <td>{{ $task->action }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Slightly Injured:</th>
                                                                <td>{{ $task->slightly_injured }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Injured with Medical Treatment:</th>
                                                                <td>{{ $task->injured_medical_treatment }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Injured with Hospitalization:</th>
                                                                <td>{{ $task->injured_hospitalization }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Fatalities:</th>
                                                                <td>{{ $task->fatalities }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Other Details:</th>
                                                                <td>{{ $task->other_details }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Police Report:</th>
                                                                <td>{{ $task->police_report }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Police File:</th>
                                                                <td>
                                                                    @if($task->police_file)
                                                                        <a href="{{ asset('storage/' . $task->police_file) }}" target="_blank" class="btn btn-primary">View File</a>
                                                                    @else
                                                                        No file uploaded
                                                                    @endif                                                                        
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Created By:</th>
                                                                <td>{{ $task->createdBy->name ?? 'Null' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Updated By:</th>
                                                                <td>{{ $task->updatedBy->name ?? 'Null' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Created At:</th>
                                                                <td>{{ $task->created_at }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Updated At:</th>
                                                                <td>{{ $task->updated_at }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <td>
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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Include Bootstrap 5 JS -->
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script>
    new DataTable('#closed');
</script>
@endsection
