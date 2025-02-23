@extends('layouts.main')

@section('content')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Survey History</div>

                <div class="card-body">
                    @if($surveys->isEmpty())
                        <p>No surveys found.</p>
                    @else
                        <div class="table-responsive">
                            <table id="survey-history" class="table table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Station</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Total Marks</th>
                                        <th>Status</th>
                                        <th>Comment</th>
                                        <th>Created By</th>
                                        <th>Approved By</th>                                       
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($surveys as $survey)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $survey->station->name }}</td>
                                            <td>{{ $survey->date }}</td>
                                            <td>{{ $survey->time }}</td>
                                            <td>{{ $survey->total_marks }}%</td>
                                            <td>
                                                @if($survey->status == 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($survey->status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @endif
                                            </td>
                                            <td>{{ $survey->comment }}</td>
                                            <td>{{ $survey->creator->name }}</td>                                            
                                            <td>{{ $survey->approver->name ?? 'Null' }}</td>
                                            <td>
                                                @if($survey->status == 'pending')
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <!-- Approve Option -->
                                                        <li>
                                                            <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#approveModal{{ $survey->id }}">
                                                                Approve
                                                            </button>
                                                        </li>
                                                        <!-- Details Option (This is shown by default) -->
                                                        <li>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#surveyModal{{ $survey->id }}">Details</a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                    <!-- Approve Survey Modal -->
                                                    <div class="modal fade" id="approveModal{{ $survey->id }}" tabindex="-1" aria-labelledby="approveModalLabel{{ $survey->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="approveModalLabel{{ $survey->id }}">Approve Survey</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to approve this survey?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <form action="{{ route('surveys.approve', ['survey' => $survey->id]) }}" method="POST">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-primary">Approve</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#surveyModal{{ $survey->id }}">Details</a>
                                                @endif
                                            </td>
                                        </tr>
                                        
                                        <!-- Modal -->
                                        <div class="modal fade" id="surveyModal{{ $survey->id }}" tabindex="-1" role="dialog" aria-labelledby="surveyModalLabel{{ $survey->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="surveyModalLabel{{ $survey->id }}">Survey Responses - {{ $survey->date }} at {{ $survey->time }}
                                                            <span class="badge bg-primary">{{ $survey->total_marks }}% Marks</span>
                                                        </h5>

                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="accordion" id="responsesAccordion{{ $survey->id }}">
                                                            @foreach($categories as $category)
                                                                <div class="card">
                                                                    <div class="card-header" id="heading{{ $category->id }}" style="background-color: #3c4b64; color: white;">
                                                                        <h2 class="mb-0">
                                                                            <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $category->id }}" aria-expanded="true" aria-controls="collapse{{ $category->id }}">
                                                                                {{ $category->name }}
                                                                                <i class="fa fa-angle-down" style="color: white;"></i>
                                                                            </button>
                                                                        </h2>
                                                                    </div>

                                                                    <div id="collapse{{ $category->id }}" class="collapse" aria-labelledby="heading{{ $category->id }}" data-parent="#responsesAccordion{{ $survey->id }}">
                                                                        <div class="card-body">
                                                                            @foreach($category->checklists as $item)
                                                                                @php
                                                                                    $response = $survey->responses->where('checklist_item_id', $item->id)->first();
                                                                                @endphp
                                                                                @if($response)
                                                                                    <div class="row">
                                                                                        <div class="col-md-5"><strong>{{ $item->name }}</strong></div>
                                                                                        <div class="col-md-3">{{ $response->response }}</div>
                                                                                        <div class="col-md-4">
                                                                                            @if($response->file_path)
                                                                                            <button type="button" class="btn btn-link attachment-thumbnail" data-bs-toggle="modal" data-bs-target="#attachmentModal{{ $survey->id }}{{ $item->id }}">
                                                                                                <img src="{{ asset('storage/' . $response->file_path) }}" class="img-thumbnail img-fluid" alt="Image Thumbnail" style="max-width: 80px; max-height: 80px;">
                                                                                            </button>
                                                                                            
                                                                                            @else
                                                                                                No Attachment
                                                                                            @endif
                                                                                        </div>
                                                                                        
                                                                                    </div>
                                                                                @else
                                                                                    <div class="row">
                                                                                        <div class="col-md-5"><strong>{{ $item->name }}</strong></div>
                                                                                        <div class="col-md-3">N/A</div>
                                                                                        <div class="col-md-4">No Attachment</div>
                                                                                    </div>
                                                                                @endif
                                                                                <hr>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h4>Approved By:</h4>
                                                                @if($survey->approver)
                                                                <p>{{ $survey->approver->name }}</p>
                                                                @if($survey->approved_at)
                                                                    <p>Approved At: {{ $survey->approved_at }}</p>
                                                                @endif
                                                            @else
                                                                <p>Not Approved Yet</p>
                                                            @endif
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h4>Signed By:</h4>
                                                                @if($survey->signatures && $survey->signatures->isNotEmpty())
                                                                    @foreach($survey->signatures as $signature)
                                                                        <div class="signature">
                                                                            @if($signature->role == 'Dealer')
                                                                                <p>{{ $signature->survey->station->dealer->name }} - Dealer</p>
                                                                            @elseif($signature->role == 'Station Manager')
                                                                                <p>{{ $signature->survey->station->stationManager->name }} - Station Manager</p>
                                                                            @endif
                                                                            <img src="{{ asset('storage/' . $signature->signature_image) }}" class="img-thumbnail img-fluid" alt="Signature" style="max-width: 150px;">
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <p>No Signature</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal -->
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
<!-- Image Preview Modals -->
@foreach($surveys as $survey)
    @foreach($categories as $category)
        @foreach($category->checklists as $item)
            @php
                $response = $survey->responses->where('checklist_item_id', $item->id)->first();
            @endphp
            @if($response && $response->file_path)
                <div class="modal fade" id="attachmentModal{{ $survey->id }}{{ $item->id }}" tabindex="-1" aria-labelledby="attachmentModalLabel{{ $survey->id }}{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="attachmentModalLabel{{ $survey->id }}{{ $item->id }}">Image Preview</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="{{ asset('storage/' . $response->file_path) }}" class="img-fluid" alt="Image Preview">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach
@endforeach

<style>
    /* Custom CSS for accordion */
/* Custom CSS for accordion */
.card-header button {
    background-color: #3c4b64;
    color: white;
    width: 100%;
    text-align: left;
    padding: 10px;
    border: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
    text-decoration: none;
}

.card-header button:hover {
    background-color: #dadada;
    text-decoration: none;
}

.card-header button:focus {
    outline: none;
}


</style>
<script src="{{ asset('vendors/jquery/jquery.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('vendors/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendors/datatables/dataTables.bootstrap5.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#survey-history').DataTable();
    });
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
