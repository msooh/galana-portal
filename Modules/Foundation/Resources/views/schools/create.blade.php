@extends('foundation::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Schools</div>

                <div class="card-body"> 
                    <h2>Create New School</h2>
                    <form action="{{ route('schools.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">School Name</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" name="location" class="form-control" id="location" value="{{ old('location') }}">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Create School</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection