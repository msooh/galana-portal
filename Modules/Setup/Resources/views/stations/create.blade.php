@extends('retail::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create New Station</div>

                <div class="card-body">
                    <form class="row g-3" method="POST" action="{{ route('stations.store') }}">
                        @csrf

                        <div class="col-md-6">
                            <label for="name" class="form-label">Station Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="col-md-6">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location">
                        </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="dealer_id" class="form-label">Select Dealer</label>
                            <select id="dealer_id" class="form-select" name="dealer_id" required>
                                @foreach($dealers as $dealer)
                                    <option value="{{ $dealer->id }}">{{ $dealer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="manager_id" class="form-label">Select Station Manager</label>
                            <select id="manager_id" class="form-select" name="manager_id" required>
                                @foreach($managers as $manager)
                                    <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                        <div class="col-md-12">
                            <label for="territory_manager_id" class="form-label">Select Territory Manager</label>
                            <select id="territory_manager_id" class="form-select" name="territory_manager_id">
                                @foreach($territoryManagers as $tm)
                                    <option value="{{ $tm->id }}">{{ $tm->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Add Station</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush
