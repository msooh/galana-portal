<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-10">
                <form id="regForm" action="{{ route('suggestion.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <img src="{{ asset('assets/img/New logo-01.png') }}" alt="Company Logo">
                    <h1 id="register">Virtual Staff Suggestion Box</h1>

                    <!-- Step icons -->
                    <div class="all-steps" id="all-steps">
                        <span class="step active"><i class="fa fa-pencil"></i></span>
                        <span class="step"><i class="fa fa-building"></i></span>
                        <span class="step"><i class="fa fa-comment"></i></span>
                        <span class="step"><i class="fa fa-paperclip"></i></span>
                        <span class="step"><i class="fa fa-user-secret"></i></span>
                        <span class="step"><i class="fa fa-envelope"></i></span>
                    </div>   

                    <!-- Individual steps -->
                    <div class="tab">
                        <h6>Suggestion Type</h6>
                        <p>
                            <select name="suggestionType" onchange="this.className = ''">
                                <option value="">Select Suggestion Type</option>
                                <option value="Business/Product Suggestion">Business/Product Suggestion</option>
                                <option value="Process/Policy Suggestions">Process/Policy Suggestions</option>
                                <option value="Complaint">Complaint</option>
                                <option value="Other">Other</option>
                            </select>
                        </p>
                    </div>
                    <div class="tab">
                        <h6>Department</h6>
                        <p>
                            <select name="department" onchange="this.className = ''">
                                <option value="">Select Department (optional)</option>
                                <option value="HR & Admin">HR & Admin</option>
                                <option value="ICT">ICT</option>
                                <option value="Finance">Finance</option>
                                <option value="Operations">Operations</option>
                                <option value="Retail">Retail</option>
                                <option value="Lubricants">Lubricants</option>
                                <option value="Consumer">Consumer</option>
                                <option value="Engineering">Engineering</option>
                                <option value="Supply, Trading & Exports">Supply, Trading & Exports</option>
                            </select>
                        </p>
                    </div>
                    <div class="tab">
                        <h6>Suggestion</h6>
                        <p><textarea placeholder="Enter your suggestion..." oninput="this.className = ''" name="suggestion"></textarea></p>
                    </div>
                    <div class="tab">
                        <h6>Attachment</h6>
                        <p><input type="file" name="attachment"></p>
                    </div>
                    <div class="tab">
                        <h6>Anonymous Select</h6>
                        <p>
                            <select name="anonymous" onchange="this.className = ''">
                                <option value="Remain Anonymous">Remain Anonymous</option>
                                <option value="Not Anonymous">Not Anonymous</option>
                            </select>
                        </p>
                    </div>
                    <div class="tab" id="nameEmailTab">
                        <h6>Enter Name and Email</h6>
                        <p><input placeholder="Name..." oninput="this.className = ''" name="name"></p>
                        <p><input type="email" placeholder="Email..." oninput="this.className = ''" name="email"></p>
                    </div>

                    <div class="tab text-center" id="submitTab">
                        <h6>All done?</h6>
                        <p>Submit your suggestion now.</p>
                        <button type="submit" id="submitBtn">Submit <i class="fa fa-paper-plane"></i></button>
                        
                    </div>
                    
                    <!-- Navigation buttons -->
                    <div style="overflow:auto;" id="nextprevious">
                        <div style="float:right;">
                            <button type="button" id="prevBtn" onclick="nextPrev(-1)"><i class="fa fa-angle-double-left"></i> </button>
                            <button type="button" id="nextBtn" onclick="nextPrev(1)"> <i class="fa fa-angle-double-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/suggestion.js')}}"></script>

</body>
</html>
