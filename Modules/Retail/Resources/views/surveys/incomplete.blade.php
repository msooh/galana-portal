@extends('retail::layouts.master')

@section('content')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">Incomplete Surveys</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="survey-incomplete" class="table table-bordered table-striped">
                                <thead class="table-dark">                    
                                    <tr>
                                        <th>#</th>
                                        <th>Station</th>
                                        <th>Category</th>
                                        <th>Last Saved</th> <!-- Now using created_at -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>   
                                    @if($surveys->isNotEmpty())
                                    @foreach($surveys as $index => $survey)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $survey->station->name ?? 'N/A' }}</td>
                                            <td>{{ $survey->category->name ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($survey->updated_at)->format('d M Y, H:i A') }}</td>
                                            <td>
                                                @if($survey->category)
                                                    <a href="{{ route('surveys.create', ['category' => $survey->category->id]) }}" class="btn btn-primary">Continue</a>
                                                @else
                                                    <button class="btn btn-secondary" disabled>Category Missing</button>
                                                @endif
                                            </td>                                  
                                        </tr>
                                    @endforeach
                                
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">No incomplete surveys found.</td>
                                        </tr>
                                    @endif
                                </tbody>                                
                            </table>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
