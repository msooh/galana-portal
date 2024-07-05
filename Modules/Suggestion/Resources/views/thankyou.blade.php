<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Suggestion Box</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}">
    <link href="{{ asset('css/suggestions.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10 text-center">
                <div id="regForm">
                    <img src="{{ asset('assets/img/New logo-01.png') }}" alt="Company Logo">
                    <span style="font-size: 50px;"><i class="fa fa-thumbs-up"></i></span>
                    <h3>Thank you for your feedback!</h3>
                    <p>Thanks for your valuable information. It helps us to improve our services!</p>
                    <a href="{{ url('/suggestion') }}" class="btn btn-primary">Another Suggestion?</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
