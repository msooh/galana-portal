@extends('suggestion::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Staff Suggestions</div>

                <div class="card-body">                    
                 <div class="table-responsive">
                    <table id="staffFeedbackTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Department</th>
                                <th>Suggestion</th>
                                <th>Anonymous</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Attachment</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>                            
                            @foreach($suggestions as $index => $suggestion)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $suggestion->suggestionType ?? '--' }}</td>
                                <td>{{ $suggestion->department ?? '--' }}</td>
                                <td>{{ $suggestion->suggestion }}</td>
                                <td>{{ $suggestion->anonymous ? 'Anonymous' : 'Not Anonymous' }}</td>
                                <td>{{ $suggestion->name ?? '--' }}</td>
                                <td>{{ $suggestion->email ?? '--' }}</td>
                                <td>
                                    @if($suggestion->attachment)
                                        <a href="{{ url($suggestion->attachment) }}" target="_blank" class="btn btn-primary">View <span><i class="fa fa-paperclip"></i></span></a>
                                    @else
                                        --
                                    @endif
                                </td>
                                <td>{{ $suggestion->created_at->format('Y-m-d H:i:s') }}</td>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Include Bootstrap 5 JS -->


<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        
        $('#staffFeedbackTable').DataTable({
            responsive: true,
            pagingType: 'full_numbers', 
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']], 
            order: [[8, 'desc']], 
        });
    });
</script>
@endsection
