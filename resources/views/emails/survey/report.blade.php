<x-mail::message>
# Survey Report

The following survey has been completed:

**Survey Type:** {{ $surveyDetails['type'] }}<br>
**Total Marks:** {{ $surveyDetails['total_marks'] }}<br>
**Surveyor:** {{ $surveyDetails['surveyor'] }}

<x-mail::button :url="$url">
    View Survey Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
