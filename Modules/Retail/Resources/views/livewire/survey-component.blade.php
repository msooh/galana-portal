<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create New Survey for {{ $category->name }}</div>
                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif

                    <form wire:submit.prevent="submit">
                        <input type="hidden" wire:model="latitude">
                        <input type="hidden" wire:model="longitude">

                        <div class="form-group">
                            <label for="station_id">Select Station:</label>
                            <select class="form-select" wire:model="station_id">
                                <option value="">Select Station</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id }}">{{ $station->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @foreach($category->subcategories as $index => $subcategory)
                        <div class="form-step{{ $index === 0 ? ' active' : '' }}" style="{{ $currentStep == $index ? '' : 'display: none;' }}">
                            <h3>{{ $subcategory->name }}</h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Checklist Item</th>
                                        <th>Yes</th>
                                        <th>No</th>
                                        <th>N/A</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subcategory->checklists as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td><input type="radio" wire:model="responses.{{ $item->id }}.response" value="Yes"></td>
                                        <td><input type="radio" wire:model="responses.{{ $item->id }}.response" value="No"></td>
                                        <td><input type="radio" wire:model="responses.{{ $item->id }}.response" value="N/A"></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endforeach

                        <div class="form-step" style="{{ $currentStep == count($category->subcategories) ? '' : 'display: none;' }}">
                            <h3>Signature</h3>
                            <canvas id="signatureCanvas" width="400" height="200"></canvas>
                            <input type="hidden" wire:model="signature">
                            <label for="role">Role:</label>
                            <select wire:model="role">
                                <option value="Dealer">Dealer</option>
                                <option value="Station Manager">Station Manager</option>
                            </select>
                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary" wire:click="$set('currentStep', $currentStep - 1)" {{ $currentStep == 0 ? 'disabled' : '' }}>Previous</button>
                            <button type="button" class="btn btn-primary" wire:click="$set('currentStep', $currentStep + 1)" {{ $currentStep == count($category->subcategories) ? 'disabled' : '' }}>Next</button>
                            <button type="submit" class="btn btn-success" {{ $currentStep == count($category->subcategories) ? '' : 'disabled' }}>Submit</button>
                            <button type="button" class="btn btn-warning" wire:click="saveProgress">Save Progress</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
