@extends('retail::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create New Survey for {{ $category->name }}</div>
                <div class="card-body">
                    <form id="regForm" action="{{ route('surveys.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <div class="form-group">
                            <label for="station_id">Select Station:</label>
                            <select class="form-select" id="station_id" name="station_id" required>
                                <option value="">Select Station</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id }}">{{ $station->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="formSteps">
                            @foreach($category->subcategories as $index => $subcategory)
                            <div class="form-step{{ $index === 0 ? ' active' : '' }}" id="step-{{ $index }}">
                                <h3>{{ $subcategory->name }}</h3>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Checklist Item</th>
                                                <th>Yes</th>
                                                <th>No</th>
                                                <th>N/A</th>
                                                @if(in_array($category->type, ['attachment', 'weight', 'comment']))
                                                    <th>@if($category->type === 'weight')
                                                         Weight 
                                                        @elseif($category->type === 'attachment') 
                                                        Attachment 
                                                        @else 
                                                        Comment 
                                                        @endif
                                                    </th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($subcategory->checklists->isEmpty())
                                            <tr>
                                                <td colspan="{{ 5 + (in_array($category->type, ['attachment', 'weight', 'comment']) ? 1 : 0) }}" class="text-center">No checklist items in this category.</td>
                                            </tr>
                                            @endif
                                            @foreach($subcategory->checklists as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    <label class="custom-radio">
                                                        <input type="radio" name="responses[{{ $item->id }}][response]" value="Yes" required>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="custom-radio">
                                                        <input type="radio" name="responses[{{ $item->id }}][response]" value="No" required>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="custom-radio">
                                                        <input type="radio" name="responses[{{ $item->id }}][response]" value="N/A" required>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                @if($category->type === 'attachment')
                                                <td>
                                                    <input type="file" name="responses[{{ $item->id }}][file]" accept="image/*">
                                                </td>
                                                @elseif($category->type === 'weight')
                                                <td>
                                                    <select name="responses[{{ $item->id }}][weight]" class="form-select">
                                                        <option value="">Select weight</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                    </select>
                                                </td>
                                                @elseif($category->type === 'comment')
                                                <td>
                                                    <textarea class="form-control" name="responses[{{ $item->id }}][comment]"></textarea>
                                                </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endforeach

                            <!-- Signature Pad -->
                            <div class="form-step" id="step-signature" style="display: none;">
                                <h3>TM Signature</h3>
                                <p>This section is to be filled by the Territory Manager</p>
                                <div>
                                    <canvas id="signatureCanvas" width="400" height="200" style="border: 1px solid black;"></canvas>
                                    <!-- Hidden input for signature image -->
                                    <input type="hidden" id="signature" name="signature_image">
                                </div>
                                <button type="button" class="btn btn-danger mt-3" onclick="clearSignature()">Clear Signature</button>
                                <!--<div class="form-group mt-3 mb-3">
                                        <label for="role">Select Your Role</label>
                                        <select class="form-control" id="role" name="role" required>
                                            <option value="Dealer">Dealer</option>
                                            <option value="Station Manager">Station Manager</option>
                                        </select>
                                    </div>
                                -->
                            </div>
                        </div>
                        <div style="overflow:auto;">
                            <div style="float:right;">
                                <button type="button" class="btn btn-primary" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                                <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Next</button>
                                <button type="submit" class="btn btn-primary" id="submitButton" style="display: none;" disabled>Submit</button>
                            </div>
                        </div>

                        <!-- Circles which indicate the steps of the form -->
                        <div style="text-align:center;margin-top:40px;">
                            @foreach($category->subcategories as $index => $subcategory)
                                <span class="step{{ $index === 0 ? ' active' : '' }}"></span>
                            @endforeach
                            <span class="step"></span> <!-- Signature Step -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 4 JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>

<script>
    var currentStep = 0;
    var formSteps = document.getElementsByClassName("form-step");
    var progressSteps = document.getElementsByClassName("step");
    var nextButton = document.getElementById("nextBtn");
    var prevButton = document.getElementById("prevBtn");
    var submitButton = document.getElementById("submitButton");

    showStep(currentStep); // Show the first step

    function showStep(step) {
    if (formSteps.length === 0 || step < 0 || step >= formSteps.length) {
        return;
    }

    for (var i = 0; i < formSteps.length; i++) {
        formSteps[i].style.display = "none";
    }
    formSteps[step].style.display = "block";
    updateButtons(step);
    updateProgressBar(step);
    }

    function nextPrev(step) {
    if (step === 1 && !validateStep(currentStep)) {
        return false;
    }
    currentStep += step;
    showStep(currentStep);

    if (currentStep === formSteps.length - 1) {
        nextButton.style.display = "none";
        submitButton.style.display = "inline";
    } else {
        nextButton.style.display = "inline";
        submitButton.style.display = "none";
    }
    }

    function validateStep(step) {
    if (formSteps.length === 0 || step < 0 || step >= formSteps.length) {
        return false;
    }

    var radios = formSteps[step].querySelectorAll('input[type="radio"]');
    var checkedCount = 0;
    var checklistItemsCount = radios.length / 3; // Each item has 3 radio buttons

    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
        checkedCount++;
        }
    }

    if (checkedCount !== checklistItemsCount) {
        Swal.fire({
        title: 'Oops...',
        text: 'Please select an option for each checklist item before proceeding.',
        icon: 'warning'
        });
        return false;
    }

    return true;
    }

    function updateButtons(step) {
    if (!prevButton || !nextButton || !submitButton) {
        return;
    }

    if (step === 0) {
        prevButton.style.display = "none";
    } else {
        prevButton.style.display = "inline";
    }

    if (step === formSteps.length - 1) {
        nextButton.style.display = "none"; // Hide Next button on last step
        submitButton.style.display = "inline"; // Show Submit button on last step
    } else {
        nextButton.style.display = "inline";
        submitButton.style.display = "none";
    }
    }

    function updateProgressBar(step) {
    for (var i = 0; i < progressSteps.length; i++) {
        progressSteps[i].className = progressSteps[i].className.replace(" active", "");
    }
    progressSteps[step].className += " active";
    }

    // Signature Pad Implementation
    var canvas = document.getElementById("signatureCanvas");
    var ctx = canvas.getContext("2d");
    var isDrawing = false;
    var lastX = 0;
    var lastY = 0;

    // Calculate canvas bounds for precise positioning
    function getCanvasOffset() {
        var rect = canvas.getBoundingClientRect();
        return {
            x: rect.left,
            y: rect.top,
            scaleX: canvas.width / rect.width,
            scaleY: canvas.height / rect.height
        };
    }

    canvas.addEventListener("touchstart", function (e) {
        isDrawing = true;
        const offset = getCanvasOffset();
        lastX = (e.touches[0].clientX - offset.x) * offset.scaleX;
        lastY = (e.touches[0].clientY - offset.y) * offset.scaleY;
        ctx.beginPath();
        ctx.arc(lastX, lastY, 2, 0, 2 * Math.PI);
        ctx.fillStyle = "red";
        ctx.fill();
    });

    canvas.addEventListener("touchmove", function (e) {
        if (!isDrawing) return;
        e.preventDefault();
        const offset = getCanvasOffset();
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        lastX = (e.touches[0].clientX - offset.x) * offset.scaleX;
        lastY = (e.touches[0].clientY - offset.y) * offset.scaleY;
        ctx.lineTo(lastX, lastY);
        ctx.strokeStyle = "black";
        ctx.lineWidth = 2;
        ctx.stroke();
    });

    canvas.addEventListener("touchend", function () {
        isDrawing = false;
        saveSignature();
    });

    canvas.addEventListener("mousedown", function (e) {
        isDrawing = true;
        const offset = getCanvasOffset();
        lastX = (e.clientX - offset.x) * offset.scaleX;
        lastY = (e.clientY - offset.y) * offset.scaleY;
    });

    canvas.addEventListener("mousemove", function (e) {
        if (!isDrawing) return;
        const offset = getCanvasOffset();
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        lastX = (e.clientX - offset.x) * offset.scaleX;
        lastY = (e.clientY - offset.y) * offset.scaleY;
        ctx.lineTo(lastX, lastY);
        ctx.strokeStyle = "black";
        ctx.lineWidth = 2;
        ctx.stroke();
    });

    canvas.addEventListener("mouseup", function () {
        isDrawing = false;
        saveSignature();
    });

    canvas.addEventListener("mouseleave", function () {
        isDrawing = false;
        saveSignature();
    });

    function saveSignature() {
        var signatureInput = document.getElementById("signature");
        if (!ctx || ctx.getImageData(0, 0, canvas.width, canvas.height).data.reduce((a, b) => a + b) === 0) {            
            submitButton.disabled = true; // Disable submit button if signature is not provided
            return false;
        }
        var dataURL = canvas.toDataURL('image/png');
        signatureInput.value = dataURL;
        submitButton.disabled = false; // Enable submit button once signature is provided
        return true;
    }

    function clearSignature() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    document.getElementById("signature").value = '';
    }

    document.getElementById('regForm').addEventListener('submit', function (event) {
    if (!saveSignature()) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
    });

    function initMap() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
        document.getElementById('latitude').value = position.coords.latitude;
        document.getElementById('longitude').value = position.coords.longitude;
        }, function () {
        Swal.fire({
            title: 'Location Access Denied',
            text: 'Please enable location access to continue with the survey.',
            icon: 'warning'
        });
        });
    } else {
        Swal.fire({
        title: 'Geolocation Not Supported',
        text: 'Your browser does not support geolocation.',
        icon: 'error'
        });
    }
    }
</script> 
@endsection

