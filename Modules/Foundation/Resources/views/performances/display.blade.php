<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Student Performance</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/searchpanes/2.0.0/css/searchPanes.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-lg">
                        <div class="card-header">Student Performance</div>

                        <div class="card-body">
                            <!-- Performance Table -->
                            <div class="table-responsive">
                                <table id="performanceTable" class="table table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Student Name</th>
                                            <th>School</th>
                                            <th>Gender</th>
                                            <th>Form</th>
                                            <th>Term</th>
                                            <th>Mid Term Mean Score</th>
                                            <th>Mid Term Grade</th>
                                            <th>Mid Term Position</th>
                                            <th>End Term Mean Score</th>
                                            <th>End Term Grade</th>
                                            <th>End Term Position</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($performances as $performance)
                                            <tr>
                                                <td>{{ $performance->student->name }}</td>
                                                <td>{{ $performance->student->school->name }}</td>
                                                <td>{{ ucfirst($performance->student->gender) }}</td>
                                                <td>{{ $performance->year }}</td>
                                                <td>{{ $performance->term }}</td>
                                                <td>{{ $performance->mid_mean_score ? $performance->mid_mean_score . '%' : '--' }}</td>
                                                <td>{{ $performance->mid_term_grade ?? '--' }}</td>
                                                <td>{{ $performance->mid_term_position_number ?? '--' }} / {{ $performance->mid_term_position_total ?? '--' }}</td>
                                                <td>{{ $performance->end_term_mean_score ? $performance->end_term_mean_score . '%' : '--' }}</td>
                                                <td>{{ $performance->end_term_grade ?? '--' }}</td>
                                                <td>{{ $performance->end_term_position_number ?? '--' }} / {{ $performance->end_term_position_total ?? '--' }}</td>
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
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.0.0/js/dataTables.searchPanes.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#performanceTable').DataTable({
                dom: 'PBfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                searchPanes: {
                    layout: 'columns-2',
                    cascadePanes: true,
                    viewTotal: true,
                    columns: [0, 1]
                },
                columnDefs: [{
                    searchPanes: {
                        show: true,
                    },
                    targets: '_all'
                }],
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                pageLength: 10,
            });
        });
    </script>
</body>
</html>
