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
            max-height: 60px;
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
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <!-- Logo on the left -->
        <img src="{{ asset('path-to-your-logo/logo.png') }}" alt="Company Logo">
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
        <p><strong>Total Marks:</strong> {{ $survey->total_marks }}%</p>
        <p><strong>Comment:</strong> {{ $survey->comment }}</p>
        <p><strong>Created By:</strong> {{ $survey->creator->name }}</p>        
    </div>

    <!-- Survey Responses Table -->
    <h3>Survey Responses</h3>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Checklist Item</th>
                <th>Response</th>
                <th>Weight</th>
                <th>Attachment</th>
                <th>Comment</th>
            </tr>
        </thead>
        <tbody>
            @foreach($survey->responses as $response)
                @php
                    $item = $response->checklistItem;
                @endphp
                <tr>
                    <td>{{ $item->subcategory->name ?? 'N/A' }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $response->response }}</td>
                    <td>{{ $response->weight ?? 'No Weight' }}</td>
                    <td>
                        @if($response->file_path)
                            <a href="{{ asset($response->file_path) }}" target="_blank">View Attachment</a>
                        @else
                            No Attachment
                        @endif
                    </td>
                    <td>{{ $response->comment ?? 'No Comment' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
