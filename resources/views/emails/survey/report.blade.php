
<x-mail::message>
    <div style="font-family: Arial, sans-serif; color: #333; padding: 20px;">
        <h1 style="font-size: 24px; color: #0056b3;">Retail Survey Report</h1>

        <p style="font-size: 16px; line-height: 1.5;">
            The following survey has been completed:
        </p>

        <table style="width: 100%; margin-top: 20px; font-size: 16px; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9;">Survey Type:</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $surveyDetails['type'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9;">Total Marks:</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $surveyDetails['total_marks'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9;">Surveyor:</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $surveyDetails['surveyor'] }}</td>
            </tr>
        </table>

        <p style="font-size: 16px; margin-top: 20px;">
            <a href="{{ $url }}" style="display: inline-block; background-color: #0056b3; color: #fff; padding: 12px 20px; text-decoration: none; border-radius: 4px;">View Survey Details</a>
        </p>

        <p style="font-size: 16px; margin-top: 30px;">
            Thanks,<br>
            {{ config('app.name') }}
        </p>
    </div>
</x-mail::message>
