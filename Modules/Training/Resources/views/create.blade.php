@extends('training::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Training </div>
                <div class="card-body">   
                    <form action="{{ route('training.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Employee</label>
                            <select name="user_id" id="user_id" class="form-select">
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Training Facility</label>
                            <input type="text" name="training_facility" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cost (KES)</label>
                            <input type="number" name="cost" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Certificate (PDF/JPG/PNG)</label>
                            <input type="file" name="certificate" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>                      
</div>
@endsection
