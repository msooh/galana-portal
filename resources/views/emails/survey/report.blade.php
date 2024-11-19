<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            padding: 20px;
            margin: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            max-width: 600px;
            margin: 20px auto;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            color: #283c98;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
        }
        table {
            width: 100%;
            margin-top: 20px;
            font-size: 16px;
            border-collapse: collapse;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .header-cell {
            background-color: #f9f9f9;
            font-weight: bold;
        }
        a.button {
            display: inline-block;
            background-color: #283c98;
            color: #fff;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>Retail Survey Report</h1>

        <p>The following survey has been completed:</p>

        <table>
            <tr>
                <td class="header-cell">Survey Type:</td>
                <td>{{ $surveyDetails['type'] }}</td>
            </tr>
            <tr>
                <td class="header-cell">Total Marks:</td>
                <td>{{ $surveyDetails['total_marks'] }}</td>
            </tr>
            <tr>
                <td class="header-cell">Surveyor:</td>
                <td>{{ $surveyDetails['surveyor'] }}</td>
            </tr>
        </table>

        <p>
            <a href="{{ $url }}" class="button">View Survey Details</a>
        </p>

        <p style="margin-top: 30px;">
            Thanks,<br>
            {{ config('app.name') }}
        </p>
    </div>
</body>
</html>
