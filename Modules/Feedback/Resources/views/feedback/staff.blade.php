<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Staff Feedback Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .feedback-form {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        .form-header {
            text-align: center;
            margin-bottom: 20px;
            display: flex; 
            justify-content: center; 
            align-items: center; 
            flex-direction: column; 
        }
        .form-header img {
            width: 100px;
            margin-bottom: 10px;
        }
        .form-header i {
            font-size: 50px;
            color: #ffc107;
        }
        .form-header h2 {
            font-size: 24px;
            margin-top: 10px;
        }
        .form-label {
            font-weight: bold;
        }
        .anonymous-info {
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
            text-align: center;
        }
        .btn-submit {
            background-color: #ffc107;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="feedback-form">
            <div class="form-header">
                <img src="{{ asset('assets/img/New logo-01.png') }}" alt="Company Logo">
                
                <h2>Virtual Staff Feedback</h2>
                <i class="fas fa-lightbulb"></i>
            </div>
            <p class="anonymous-info">Your feedback is anonymous and will help us improve our services.</p>
            <form action="{{ route('feedback.submit') }}" method="POST">
                @csrf               
                <div class="mb-3">
                    <label for="feedbackType" class="form-label">Feedback Type</label>
                    <select class="form-select" id="feedbackType" name="feedbackType">
                        <option selected>Select feedback type</option>
                        <option value="suggestion">Suggestion</option>
                        <option value="issue">Issue</option>
                        <option value="compliment">Compliment</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="feedback" class="form-label">Feedback</label>
                    <textarea class="form-control" id="feedback" name="feedback" rows="4" placeholder="Enter your feedback"></textarea>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
</html>
