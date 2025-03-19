<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header img {
            max-height: 80px;
        }
        .details {
            text-align: right;
            font-size: 12px;
            color: #555;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .survey-info {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #283c98;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #d4e3fc;
        }

        td a {
            color: #283c98;
            text-decoration: none;
            font-weight: bold;
        }

        td a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <!-- Logo on the left -->
        <img src="{{ base_path('public/assets/img/New logo-01.png') }}" alt="Company Logo">
        <!-- Station Details on the right -->
        <div class="details">
            <p><strong>Station:</strong> {{ $survey->station->name }}</p>
            <p><strong>Date:</strong> {{ $survey->date }}</p>
            <p><strong>Time:</strong> {{ $survey->time }}</p>
        </div>
    </div>

    <!-- Survey Title -->
    <h1>Survey Report</h1>

    <!-- Survey Details -->
    <div class="survey-info">
        <p><strong>Checklist:</strong> {{ $survey->responses->first()->checklistItem->subcategory->category->name ?? 'N/A' }}</p>
        <p><strong>Total Marks:</strong> {{ number_format($survey->total_marks, 2) }}%</p>
        <p><strong>Comment:</strong> {{ $survey->comment }}</p>
        <p><strong>Created By:</strong> {{ $survey->creator->name }}</p>        
    </div>

    <!-- Survey Responses Table -->
    <h3>Survey Responses</h3>
    @php
        // Check which fields are available in the survey responses
        $hasWeight = $survey->responses->contains(fn($response) => !is_null($response->weight));
        $hasAttachment = $survey->responses->contains(fn($response) => !is_null($response->file_path));
        $hasComment = $survey->responses->contains(fn($response) => !is_null($response->comment));
    @endphp

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Category</th>
                <th>Checklist Item</th>
                <th>Response</th>
                @if($hasWeight) <th>Weight</th> @endif
                @if($hasAttachment) <th>Attachment</th> @endif
                @if($hasComment) <th>Comment</th> @endif
            </tr>
        </thead>
        <tbody>
            @foreach($survey->responses as $response)
                @php
                    $item = $response->checklistItem;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->subcategory->name ?? 'N/A' }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $response->response }}</td>
                    @if($hasWeight) <td>{{ $response->weight }}</td> @endif
                    @if($hasAttachment)
                        <td>
                            @if($response->file_path)
                                <a href="{{ asset($response->file_path) }}" target="_blank">View Attachment</a>
                            @endif
                        </td>
                    @endif
                    @if($hasComment) <td>{{ $response->comment }}</td> @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
