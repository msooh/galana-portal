@extends('foundation::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Add Performance</div>

                <div class="card-body">
                    <form action="{{ route('performances.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="student_id">Student</label>
                            <select name="student_id" class="form-select" id="student_id" required>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            
                            <div class="form-group col-md-6 mb-3">
                                <label for="year">Form</label>
                                <select name="year" class="form-select" id="year" required>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="term">Term</label>
                                <select name="term" class="form-select" id="term" required>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">                          
                            <div class="form-group col-md-6 mb-3">
                                <label for="mid_mean_score">Mid Mean Score</label>
                                <input type="number" step="0.01" name="mid_mean_score" class="form-control" id="mid_mean_score" required>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="mid_term_position">Mid-Term Position</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="mid_term_position" name="mid_term_position_number" placeholder="Position" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">out of</span>
                                    </div>
                                    <input type="number" class="form-control" id="mid_term_position_total" name="mid_term_position_total" placeholder="Total Students" required>
                                </div>
                            </div>
                           
                        </div>
                        <div class="row">                            
                            <div class="form-group col-md-6 mb-3">
                                <label for="end_term_mean_score">End Term Mean Score</label>
                                <input type="number" step="0.01" name="end_term_mean_score" class="form-control" id="end_term_mean_score" required>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="end_term_position">End-Term Position</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="end_term_position" name="end_term_position_number" placeholder="Position" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">out of</span>
                                    </div>
                                    <input type="number" class="form-control" id="end_term_position_total" name="end_term_position_total" placeholder="Total Students" required>
                                </div>
                            </div>                            
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save Performance</button>
                        <a href="{{ route('performances.index') }}" class="btn btn-secondary">Back to List</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
