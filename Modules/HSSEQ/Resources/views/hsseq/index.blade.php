@extends('hsseq::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Historical Safety Reports</div>

                <div class="card-body">
                    @if ($safetyReports->isEmpty())
                        <p>No safety reports found.</p>
                    @else
                    <div class="table-responsive">
                        <table id="hsseq-history" class="table table-striped table-bordered">
                            <thead class="table-dark">
                                    <tr>
                                        <th>Rating</th>
                                        <th>Type</th>
                                        <th>Nature</th>
                                        <th>Location</th>
                                        <th>Date</th>
                                        <th>Time</th>                         
                                        <th>Police Report</th>
                                        <th>Sender's Name</th>
                                        <th>Status</th>                       
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($safetyReports as $report)
                                        <tr>
                                            <td>
                                                @if ($report->accidentType)
                                                    @if ($report->accidentType->rating == 'High')
                                                        <div class="p-2 bg-danger text-white">High</div>
                                                    @elseif ($report->accidentType->rating == 'Medium')
                                                        <div class="p-2 bg-warning text-dark">Medium</div>
                                                    @elseif ($report->accidentType->rating == 'Low')
                                                        <div class="p-2 bg-success text-white">Low</div>
                                                    @endif
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td>{{ $report->type }}</td>
                                            <td>{{ $report->accidentType->name }}</td>
                                            <td>
                                                @if ($report->station_id)
                                                    {{ $report->station->name }}
                                                @elseif ($report->other_location_id)
                                                    {{ $report->location->name }}
                                                @else
                                                    Unknown
                                                @endif
                                            </td>                                            
                                            <td>{{ $report->date }}</td>
                                            <td>{{ $report->time }}</td>
                                            <td>{{ $report->police_report }}</td>
                                            <td>{{ $report->createdBy->name ?? 'Null' }}</td>
                                            <td>
                                                @if ($report->status == 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif ($report->status == 'In-Progress')
                                                    <span class="badge bg-primary">In-Progress</span>
                                                @elseif ($report->status == 'Closed')
                                                    <span class="badge bg-success">Closed</span>
                                                @endif
                                            </td>
                                           
                                            <th>{{ $report->created_at}}</th>
                                            <td>       
                                                @if ($report->status == 'pending')
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" type="button" id="actionDropdown{{ $report->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $report->id }}">
                                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#reportModal{{ $report->id }}">View Details</a></li>
                                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#assignTaskModal{{ $report->id }}">Assign Task</a></li>
                                                    </ul>
                                                </div>
                                            <!-- Assigning Tasks Modal -->
                                            <div class="modal fade assign-task-modal" id="assignTaskModal{{ $report->id }}" tabindex="-1" aria-labelledby="assignTaskModalLabel{{ $report->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="assignTaskModalLabel{{ $report->id }}">Assign Task</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('safety.assignTask', $report->id) }}" method="POST">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="department_id" class="form-label">Select Department</label>
                                                                    <select class="form-select department-select" id="department_id{{ $report->id }}" name="department_id" required>
                                                                        <option value="" selected disabled>Select Department</option>
                                                                        @foreach($departments as $department)
                                                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="user_id" class="form-label">Assign to User</label>
                                                                    <select class="form-select user-select" id="user_id{{ $report->id }}" name="user_id" required>
                                                                        <option value="" selected disabled>Select User</option>
                                                                    </select>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary">Assign</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                                
                                            @else
                                                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#reportModal{{ $report->id }}">View</button>
                                            @endif                                        
                                                
                                                                                   
                                            <!-- Modal -->
                                            <div class="modal fade" id="reportModal{{ $report->id }}" tabindex="-1" aria-labelledby="reportModalLabel{{ $report->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="reportModalLabel{{ $report->id }}">Safety Report Details
                                                            
                                                                @if ($report->status == 'pending')
                                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                                @elseif ($report->status == 'In-Progress')
                                                                    <span class="badge bg-primary">In-Progress</span>
                                                                @elseif ($report->status == 'Closed')
                                                                    <span class="badge bg-success">Closed</span>
                                                                @endif
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <th>Type:</th>
                                                                        <td>{{ $report->type }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Station:</th>
                                                                        <td>@if ($report->station_id)
                                                                            {{ $report->station->name }}
                                                                        @elseif ($report->other_location_id)
                                                                            {{ $report->location->name }}
                                                                        @else
                                                                            Unknown
                                                                        @endif</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Date:</th>
                                                                        <td>{{ $report->date }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Time:</th>
                                                                        <td>{{ $report->time }}</td>
                                                                    </tr>
                                                                     <tr>
                                                                        <th>Nature of Accident/Incident:</th>
                                                                        <td>{{$report->accidentType ? $report->accidentType->name : '--' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Comment:</th>
                                                                        <td>{{ $report->comment }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Action Taken:</th>
                                                                        <td>{{ $report->action }}</td>
                                                                    </tr>
                                                                   
                                                                    <tr>
                                                                        <th>Slightly Injured:</th>
                                                                        <td>{{ $report->slightly_injured }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Injured with Medical Treatment:</th>
                                                                        <td>{{ $report->injured_medical_treatment }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Injured with Hospitalization:</th>
                                                                        <td>{{ $report->injured_hospitalization }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Fatalities:</th>
                                                                        <td>{{ $report->fatalities }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Other Details:</th>
                                                                        <td>{{ $report->other_details }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Police Report:</th>
                                                                        <td>{{ $report->police_report }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Police File:</th>
                                                                        <td>
                                                                            @if ($report->police_file)
                                                                                <a href="{{ asset($report->police_file) }}" target="_blank" class="btn btn-primary">View File</a>
                                                                            @else
                                                                                No file uploaded
                                                                            @endif
                                                                        </td>                                                                   
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Created By:</th>
                                                                        <td>{{ $report->createdBy->name ?? 'Null' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Updated By:</th>
                                                                        <td>{{ $report->updatedBy->name ?? 'Null' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Created At:</th>
                                                                        <td>{{ $report->created_at }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Updated At:</th>
                                                                        <td>{{ $report->updated_at }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Assigned To:</th>
                                                                        <td>{{ $report->assignedTo->name ?? 'Null' }}</td>
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
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Include Bootstrap 5 JS -->


<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
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
        // Retain old input values and highlight the inputs with errors
        var errors = {!! json_encode($errors->toArray()) !!};
        var oldInput = {!! json_encode(old()) !!};

        $.each(errors, function(field, message) {
            // Highlight the field with error
            var $input = $('[name="' + field + '"]');
            $input.addClass('is-invalid');

            // Retain old input value
            if (oldInput[field] !== undefined) {
                if ($input.is('select[multiple]')) {
                    var oldValues = oldInput[field];
                    $input.val(Array.isArray(oldValues) ? oldValues : [oldValues]);
                } else {
                    $input.val(oldInput[field]);
                }
            }
        });

        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: '<p>' + '{!! implode('<br>', $errors->all()) !!}' + '</p>',
            confirmButtonText: 'OK'
        });
        @endif
    });
</script>

<script>
    new DataTable('#hsseq-history');
</script>


<script>

document.addEventListener('DOMContentLoaded', function () {
    const usersByDepartment = @json($usersByDepartment);
    
    // Event delegation for department select change
    document.addEventListener('change', function (e) {
        if (e.target && e.target.classList.contains('department-select')) {
            const departmentSelect = e.target;
            const modal = departmentSelect.closest('.assign-task-modal');
            const userSelect = modal.querySelector('.user-select');
            const selectedDepartmentId = departmentSelect.value;
            const users = usersByDepartment[selectedDepartmentId] || [];
            
            userSelect.innerHTML = '<option value="" selected disabled>Select User</option>';
            users.forEach(function (user) {
                const option = document.createElement('option');
                option.value = user.id;
                option.textContent = user.name;
                userSelect.appendChild(option);
            });
        }
    });
});

</script>

@endsection
