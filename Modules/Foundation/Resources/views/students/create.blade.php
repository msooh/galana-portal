@extends('foundation::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create New Student</div>

                <div class="card-body">                    
                    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="form-group col-md-6">
                                <label for="name">Student Name</label>
                                <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="gender">Gender</label>
                                <select name="gender" class="form-select" id="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>                            
                        </div>
                        <div class="row mb-3">
                            <div class="form-group col-md-6">
                                <label for="county">County</label>
                                <input type="text" name="county" class="form-control" id="county" value="{{ old('county') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="sub_county">Sub-County</label>
                                <input type="text" name="sub_county" class="form-control" id="sub_county" value="{{ old('sub_county') }}" required>
                            </div>                            
                        </div>
                        <div class="row mb-3">                            
                            <div class="form-group col-md-6">
                                <label for="age">Age</label>
                                <input type="number" name="age" class="form-control" id="age" value="{{ old('age') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="location">Location</label>
                                <input type="text" name="location" class="form-control" id="location" value="{{ old('location') }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="form-group col-md-6">
                                <label for="father_name">Father's Name</label>
                                <input type="text" name="father_name" class="form-control" id="father_name" value="{{ old('father_name') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="father_phone">Father's Phone</label>
                                <input type="text" name="father_phone" class="form-control" id="father_phone" value="{{ old('father_phone') }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="form-group col-md-6">
                                <label for="mother_name">Mother's Name</label>
                                <input type="text" name="mother_name" class="form-control" id="mother_name" value="{{ old('mother_name') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mother_phone">Mother's Phone</label>
                                <input type="text" name="mother_phone" class="form-control" id="mother_phone" value="{{ old('mother_phone') }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="form-group col-md-6">
                                <label for="guardian_name">Guardian's Name</label>
                                <input type="text" name="guardian_name" class="form-control" id="guardian_name" value="{{ old('guardian_name') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="guardian_phone">Guardian's Phone</label>
                                <input type="text" name="guardian_phone" class="form-control" id="guardian_phone" value="{{ old('guardian_phone') }}">
                            </div>
                        </div>                       
                        <div class="row mb-3">
                            <div class="form-group col-md-6 mb-3 ">
                                <label for="school_id">School</label>
                                <select name="school_id" class="form-select" id="school_id" required>
                                    <option value="">Select School</option>
                                    @foreach($schools as $school)
                                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="photo">Photo</label>
                                <input type="file" name="photo" class="form-control-file" id="photo">
                            </div>
                        </div>                       
                        <button type="submit" class="btn btn-primary mt-3">Create Student</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
