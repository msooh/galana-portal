@extends('hsseq::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"> <b>New Accident/Incident Report</b></div>
                <div class="card-body">
                    <form class="row g-3" method="POST" enctype="multipart/form-data" action="{{ route('hsseq.store') }}">
                        @csrf                       

                        @php
                        $user = auth()->user();
                        $showLocationType = $user->hasRole('Admin') || $user->hasRole('Hsseq') || $user->hasRole('Retail Manager');
                        $showStationSelect = $user->hasRole('Station Manager');
                        $showLocationSelect = $user->hasRole('Depot');
                        @endphp

                        @if ($showLocationType)
                        <div class="row mb-3 mt-3">
                            <div class="col-md-12">
                                <label><b>Select Location Type</b></label>
                                <div>
                                    <input type="radio" id="stationOption" name="location_type" value="station" checked>
                                    <label for="stationOption">Station</label>
                                </div>
                                <div>
                                    <input type="radio" id="locationOption" name="location_type" value="location">
                                    <label for="locationOption">Other Location</label>
                                </div>
                            </div>
                        </div>
                        @endif
                       
                        @if ($showStationSelect || $showLocationType)
                        <div class="col-md-6" id="stationSelect">
                            <label for="station_id" class="form-label"><b>Select Station</b></label>
                            <select id="station_id" class="form-select @error('station_id') is-invalid @enderror" name="station_id">
                                <option value="">Select Station</option>
                                @foreach($stations as $station)
                                <option value="{{ $station->id }}" {{ old('station_id') == $station->id ? 'selected' : '' }}>{{ $station->name }}</option>
                                @endforeach
                            </select>
                            @error('station_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @endif

                        @if ($showLocationSelect || $showLocationType)
                        <div class="col-md-6 {{ $showLocationType ? 'd-none' : '' }}" id="locationSelect">
                            <label for="location_id" class="form-label"><b>Select Other Location</b></label>
                            <select id="location_id" class="form-select @error('location_id') is-invalid @enderror" name="location_id">
                                <option value="">Select Other Location</option>
                                @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                @endforeach
                            </select>
                            @error('location_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @endif
                        <div class="col-md-6">
                            <label for="type" class="form-label"><b>Type</b><span class="text-danger">*</span></label>
                            <select id="type" class="form-select @error('type') is-invalid @enderror" name="type" required>
                                <option value="">Select Type</option>
                                <option value="Accident" {{ old('type') == 'Accident' ? 'selected' : '' }}>Accident</option>
                                <option value="Incident" {{ old('type') == 'Incident' ? 'selected' : '' }}>Incident</option>
                            </select>
                            @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                   
                        

                        <div class="col-md-6">
                            <label for="date" class="form-label"><b>Date</b><span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                            @error('date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="time" class="form-label"><b>Time</b><span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('time') is-invalid @enderror" id="time" name="time" value="{{ old('time', date('H:i')) }}" required>
                            @error('time')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="comment" class="form-label"><b>A. Comment</b><span class="text-danger">*</span></label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" name="comment" id="comment" cols="20" rows="3" placeholder="Type Comment" required>{{ old('comment') }}</textarea>
                            @error('comment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="action" class="form-label"><b>B. Action</b><span class="text-danger">*</span></label>
                            <textarea class="form-control @error('action') is-invalid @enderror" name="action" id="action" cols="20" rows="3" placeholder="Details of Action Taken" required>{{ old('action') }}</textarea>
                            @error('action')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="accident_type_id" class="form-label"><b>C. Nature of Accident/Incident</b><span class="text-danger">*</span></label>
                            <select id="accident_type_id" class="form-select @error('accident_type_id') is-invalid @enderror" name="accident_type_id" required>
                                <option value="">Select Nature of Accident</option>
                                @foreach($accidents as $accident)
                                <option value="{{ $accident->id }}" {{ old('accident_type_id') == $accident->id ? 'selected' : '' }}>{{ $accident->name }}</option>
                                @endforeach
                            </select>
                            @error('accident_type_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="slightly_injured" class="form-label">Number of slightly injured persons given 1st aid (if applicable)</label>
                            <input type="number" class="form-control @error('slightly_injured') is-invalid @enderror" id="slightly_injured" name="slightly_injured" value="{{ old('slightly_injured') }}">
                            @error('slightly_injured')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="injured_medical_treatment" class="form-label">Number of injured persons with medical treatment (if applicable)</label>
                            <input type="number" class="form-control @error('injured_medical_treatment') is-invalid @enderror" id="injured_medical_treatment" name="injured_medical_treatment" value="{{ old('injured_medical_treatment') }}">
                            @error('injured_medical_treatment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="injured_hospitalization" class="form-label">Number of injured persons with hospitalization (if applicable)</label>
                            <input type="number" class="form-control @error('injured_hospitalization') is-invalid @enderror" id="injured_hospitalization" name="injured_hospitalization" value="{{ old('injured_hospitalization') }}">
                            @error('injured_hospitalization')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="fatalities" class="form-label">Number of Fatalities (if applicable)</label>
                            <input type="number" class="form-control @error('fatalities') is-invalid @enderror" id="fatalities" name="fatalities" value="{{ old('fatalities') }}">
                            @error('fatalities')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="other_details" class="form-label"><b>E. Other Details</b><span class="text-danger">*</span></label>
                            <textarea class="form-control @error('other_details') is-invalid @enderror" name="other_details" id="other_details" cols="20" rows="3">{{ old('other_details') }}</textarea>
                            @error('other_details')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="police_report" class="form-label">Matter reported to Police? (Select one)</label>
                            <select id="police_report" class="form-select @error('police_report') is-invalid @enderror" name="police_report">
                                <option value="">Select</option>
                                <option value="YES" {{ old('police_report') == 'YES' ? 'selected' : '' }}>YES</option>
                                <option value="NO" {{ old('police_report') == 'NO' ? 'selected' : '' }}>NO</option>
                            </select>
                            @error('police_report')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="police_file" class="form-label">Police file attachment (if applicable)</label>
                            <input type="file" name="police_file" id="police_file" class="form-control @error('police_file') is-invalid @enderror">
                            @error('police_file')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
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
        // Retain old input values and highlight the inputs with errors
        var errors = {!! json_encode($errors->toArray()) !!};
        var oldInput = {!! json_encode(old()) !!};

        $.each(errors, function(field, message) {
            // Highlight the field with error
            var $input = $('[name="' + field + '"]');
            $input.addClass('is-invalid');

            // Retain old input value
            if (oldInput[field] !== undefined) {
                if ($input.is('select[multiple]')) {
                    var oldValues = oldInput[field];
                    $input.val(Array.isArray(oldValues) ? oldValues : [oldValues]);
                } else {
                    $input.val(oldInput[field]);
                }
            }
        });

        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: '<p>' + '{!! implode('<br>', $errors->all()) !!}' + '</p>',
            confirmButtonText: 'OK'
        });
        @endif
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stationOption = document.getElementById('stationOption');
        const locationOption = document.getElementById('locationOption');
        const stationSelect = document.getElementById('stationSelect');
        const locationSelect = document.getElementById('locationSelect');
    
        stationOption.addEventListener('change', function() {
            if (stationOption.checked) {
                stationSelect.classList.remove('d-none');
                locationSelect.classList.add('d-none');
            }
        });
    
        locationOption.addEventListener('change', function() {
            if (locationOption.checked) {
                locationSelect.classList.remove('d-none');
                stationSelect.classList.add('d-none');
            }
        });
    });
    </script>
@endsection
