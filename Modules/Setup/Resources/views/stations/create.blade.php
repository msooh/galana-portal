@extends('retail::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create New Station</div>

                <div class="card-body">
                    <form action="{{ route('stations.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="long" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="long" name="long">
                            </div>
                            <div class="col">
                                <label for="lat" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="lat" name="lat">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="dealer_id" class="form-label">Dealer</label>
                                <select class="form-select" id="dealer_id" name="dealer_id">
                                    <option value="" selected>Choose...</option>
                                    @foreach($dealers as $dealer)
                                        <option value="{{ $dealer->id }}">{{ $dealer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="territory_manager_id" class="form-label">Territory Manager</label>
                                <select class="form-select" id="territory_manager_id" name="territory_manager_id">
                                    <option value="" selected>Choose...</option>
                                    @foreach($territoryManagers as $manager)
                                        <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="col">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="till_number" class="form-label">Till Number</label>
                                <input type="text" class="form-control" id="till_number" name="till_number">
                            </div>
                            <div class="col">
                                <label for="company_id" class="form-label">Company</label>
                                <select class="form-select" id="company_id" name="company_id">
                                    <option value="" selected>Choose...</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date">
                            </div>
                            <div class="col">
                                <label for="is_active" class="form-label">Is Active</label>
                                <select class="form-select" id="is_active" name="is_active">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                       
                        <button type="submit" class="btn btn-primary">Save Station</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Any additional scripts can be pushed here if needed -->
@endpush
