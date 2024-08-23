@extends('retail::layouts.master')

@section('content')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
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
                                            <th>Category</th>
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
                                                @php
                                                    // Assuming each survey has a list of responses
                                                    $firstResponse = $survey->responses->first();
                                                    $categoryName = 'N/A'; // Default to N/A
                                            
                                                    if ($firstResponse && $firstResponse->checklistItem && $firstResponse->checklistItem->subcategory && $firstResponse->checklistItem->subcategory->category) {
                                                        $categoryName = $firstResponse->checklistItem->subcategory->category->name;
                                                    }
                                                @endphp
                                                <td>{{ $categoryName }}</td>
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
                                                                @foreach($category->subcategories as $subcategory)
                                                                    @if($subcategory->checklists->isNotEmpty())
                                                                    <div class="card">
                                                                        <div class="card-header" id="heading{{ $subcategory->id }}" style="background-color: #3c4b64; color: white;">
                                                                            <h2 class="mb-0">
                                                                                <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $subcategory->id }}" aria-expanded="true" aria-controls="collapse{{ $subcategory->id }}">
                                                                                    {{ $subcategory->name }}
                                                                                    <i class="fa fa-angle-down" style="color: white;"></i>
                                                                                </button>
                                                                            </h2>
                                                                        </div>

                                                                        <div id="collapse{{ $subcategory->id }}" class="collapse" aria-labelledby="heading{{ $subcategory->id }}" data-parent="#responsesAccordion{{ $survey->id }}">
                                                                            <div class="card-body">
                                                                                @foreach($subcategory->checklists as $item)
                                                                                    @php
                                                                                        $response = $survey->responses->where('checklist_item_id', $item->id)->first();
                                                                                    @endphp
                                                                                    @if($response)
                                                                                    <div class="row">
                                                                                        <div class="col-md-7"><strong>{{ $item->name }}</strong></div>
                                                                                        <div class="col-md-2">{{ $response->response }}</div>
                                                                                        <div class="col-md-3">
                                                                                            @if($category->type === 'weight')
                                                                                                {{ $response->weight ?? 'No Weight' }}
                                                                                            @elseif($category->type === 'attachment')
                                                                                                @if($response->file_path)
                                                                                                    <button type="button" class="btn btn-link attachment-thumbnail" data-bs-toggle="modal" data-bs-target="#attachmentModal{{ $survey->id }}{{ $item->id }}">
                                                                                                        <img src="{{ asset('storage/' . $response->file_path) }}" class="img-thumbnail img-fluid" alt="Image Thumbnail" style="max-width: 80px; max-height: 80px;">
                                                                                                    </button>
                                                                                                @else
                                                                                                    No Attachment
                                                                                                @endif
                                                                                            @elseif($category->type === 'comment')
                                                                                                {{ $response->comment ?? 'No Comment' }}
                                                                                            @else
                                                                                                {{ $response->response ?? 'N/A' }}
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>
                                                                                @endif
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    @endforeach
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
                                                            <div class="row">                
                                                                <!--Map Goes Here-->
                                                                <div id="map{{ $survey->id }}" style="height: 400px; width: 100%;"></div>                                                            
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
    @foreach($subcategories as $subcategory)
        @foreach($subcategory->checklists as $item)
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!--<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>-->

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ermIwyEWez3cLATTNMw5ksOoyZjs188&callback=initMap"></script>
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
<!-- Include the Google Maps JavaScript API -->

<script>
    function initMap() {
    @foreach($surveys as $survey)
        @if($survey->latitude && $survey->longitude)
            var mapContainerId = 'map{{ $survey->id }}';
            var mapOptions = {
                zoom: 15,
                center: { lat: {{ $survey->latitude }}, lng: {{ $survey->longitude }} },
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var map = new google.maps.Map(document.getElementById(mapContainerId), mapOptions);

            // Use standard Marker class
            var marker = new google.maps.Marker({
                position: { lat: {{ $survey->latitude }}, lng: {{ $survey->longitude }} },
                map: map,
                title: 'Survey Location'
            });
        @else
            var mapOptions = {
                zoom: 3,
                center: { lat: 0, lng: 0 },
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var map = new google.maps.Map(document.getElementById('map'), mapOptions);

            var infoWindow = new google.maps.InfoWindow({
                content: "Location data not available"
            });

            infoWindow.open(map);
        @endif
    @endforeach
}

</script>

@endsection
