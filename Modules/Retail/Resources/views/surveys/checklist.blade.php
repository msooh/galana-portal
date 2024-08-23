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
                                                    <input type="number" name="responses[{{ $item->id }}][weight]" step="0.01">
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
                                <h3>Station Signature</h3>
                                <p>This section is to be filled by either the Dealer or Station Manager</p>
                                <div>
                                    <canvas id="signatureCanvas" width="400" height="200" style="border: 1px solid black;"></canvas>
                                    <!-- Hidden input for signature image -->
                                    <input type="hidden" id="signature" name="signature_image">
                                </div>
                                <button type="button" class="btn btn-danger mt-3" onclick="clearSignature()">Clear Signature</button>
                                <div class="form-group mt-3 mb-3">
                                    <label for="role">Select Your Role</label>
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="Dealer">Dealer</option>
                                        <option value="Station Manager">Station Manager</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div style="overflow:auto;">
                            <div style="float:right;">
                                <button type="button" class="btn btn-primary" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                                <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Next</button>
                                <button type="submit" class="btn btn-primary" id="submitButton" style="display: none;">Submit</button>
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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                text: 'Please select an option for each checklist item before proceeding.'
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
        if (progressSteps.length === 0 || step < 0 || step >= progressSteps.length) {
            return;
        }

        for (var i = 0; i < progressSteps.length; i++) {
            progressSteps[i].classList.remove("active");
        }
        progressSteps[step].classList.add("active");
    }

    var canvas = document.getElementById("signatureCanvas");
    var ctx = canvas.getContext("2d");
    var isDrawing = false;
    var lastX = 0;
    var lastY = 0;

    canvas.addEventListener("mousedown", function (e) {
        isDrawing = true;
        [lastX, lastY] = [e.offsetX, e.offsetY];
    });

    canvas.addEventListener("mousemove", function (e) {
        if (!isDrawing) return;
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(e.offsetX, e.offsetY);
        ctx.strokeStyle = "black";
        ctx.lineWidth = 2;
        ctx.stroke();
        [lastX, lastY] = [e.offsetX, e.offsetY];
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
        var signatureCanvas = document.getElementById("signatureCanvas");
        var signatureInput = document.getElementById("signature");

        // Check if canvas is empty
        if (!ctx || ctx.getImageData(0, 0, signatureCanvas.width, signatureCanvas.height).data.reduce((a, b) => a + b) === 0) {
            Swal.fire({
                title: 'Oops...',
                text: 'Please provide a signature before proceeding.',
                icon: 'error'
            });
            return false;
        }

        // Get the data URL of the canvas
        var dataURL = signatureCanvas.toDataURL();

        // Set the value of the hidden input
        signatureInput.value = dataURL;

        return true;
    }

    function clearSignature() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        signatureInput.value = ''; // Clear the signature input value
    }

    var form = document.getElementById('regForm');
    form.addEventListener('submit', function (event) {
        if (!saveSignature()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                // Get the latitude and longitude from the position object
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                // Set the values in the hidden input fields
                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;
            }, function (error) {
                console.error("Error getting location: " + error.message);
            });
        } else {
            console.error("Geolocation is not supported by this browser.");
        }
    });
</script>

@endsection
