@extends('foundation::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Fee Payments</div>

                <div class="card-body">
                    <!-- Button to open the create modal -->
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
                        Add Fee Payment
                    </button>

                    <!-- Table displaying fee payments -->
                    <table class="table" id="fees">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Form</th>
                                <th>Total Fees</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fees as $fee)
                                <tr>
                                    <td>{{ $fee->student->name }}</td>
                                    <td>{{ $fee->year }}</td>
                                    <td>{{ $fee->total_fees }}</td>
                                    <td>{{ ucfirst($fee->status) }}</td>
                                    <td>
                                         <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#viewModal{{ $fee->id }}">View</a></li>
                                                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal{{ $fee->id }}">Edit</a></li>
                                            </ul>
                                        </div>                                        
                                    </td>
                                </tr>

                                <!-- View Modal -->
                                <div class="modal fade" id="viewModal{{ $fee->id }}" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $fee->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewModalLabel{{ $fee->id }}">View Fee Payment</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Student Name:</strong> {{ $fee->student->name }}</p>
                                                <p><strong>Form:</strong> {{ $fee->year }}</p>
                                                <p><strong>Total Fees:</strong> {{ $fee->total_fees }}</p>
                                                <p><strong>Term One Fees:</strong> {{ $fee->term_one_fees }}</p>
                                                <p><strong>Term Two Fees:</strong> {{ $fee->term_two_fees }}</p>
                                                <p><strong>Term Three Fees:</strong> {{ $fee->term_three_fees }}</p>
                                                <p><strong>Status:</strong> {{ ucfirst($fee->status) }}</p>
                                                <p><strong>Uniform/Others Amount:</strong> {{ $fee->uniform_others_amount ?? 'N/A' }}</p>
                                                <p><strong>Mode of Payment:</strong> {{ $fee->mode_of_payment ?? 'N/A' }}</p>

                                                <!-- List of other payments -->
                                                <h5>Other Payments</h5>
                                                <ul>
                                                    @foreach($fee->otherPayments as $payment)
                                                        <li>{{ $payment->purpose }}: {{ $payment->amount }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $fee->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $fee->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{ $fee->id }}">Edit Fee Payment</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('fees.update', $fee->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="form-group">
                                                        <label for="student_id">Student</label>
                                                        <select name="student_id" class="form-control" id="student_id" required>
                                                            @foreach($students as $student)
                                                                <option value="{{ $student->id }}" {{ $fee->student_id == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="year">Form</label>
                                                        <select name="year" class="form-control" id="year" required>
                                                            <option value="1" {{ $fee->year == '1' ? 'selected' : '' }}>1</option>
                                                            <option value="2" {{ $fee->year == '2' ? 'selected' : '' }}>2</option>
                                                            <option value="3" {{ $fee->year == '3' ? 'selected' : '' }}>3</option>
                                                            <option value="4" {{ $fee->year == '4' ? 'selected' : '' }}>4</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="total_fees">Total Fees</label>
                                                        <input type="number" step="0.01" name="total_fees" class="form-control" id="total_fees" value="{{ $fee->total_fees }}" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="term_one_fees">Term One Fees</label>
                                                        <input type="number" step="0.01" name="term_one_fees" class="form-control" id="term_one_fees" value="{{ $fee->term_one_fees }}" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="term_two_fees">Term Two Fees</label>
                                                        <input type="number" step="0.01" name="term_two_fees" class="form-control" id="term_two_fees" value="{{ $fee->term_two_fees }}" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="term_three_fees">Term Three Fees</label>
                                                        <input type="number" step="0.01" name="term_three_fees" class="form-control" id="term_three_fees" value="{{ $fee->term_three_fees }}" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="status">Status</label>
                                                        <select name="status" class="form-control" id="status" required>
                                                            <option value="paid" {{ $fee->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                                            <option value="unpaid" {{ $fee->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="uniform_others_amount">Uniform/Others Amount</label>
                                                        <input type="number" step="0.01" name="uniform_others_amount" class="form-control" id="uniform_others_amount" value="{{ $fee->uniform_others_amount }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="mode_of_payment">Mode of Payment</label>
                                                        <input type="text" name="mode_of_payment" class="form-control" id="mode_of_payment" value="{{ $fee->mode_of_payment }}">
                                                    </div>

                                                    <!-- Other payments section -->
                                                    <h5>Other Payments</h5>
                                                    <div id="additional-fees">
                                                        @foreach($fee->otherPayments as $payment)
                                                            <div class="row align-items-center mt-4">
                                                                <div class="col-md-5">
                                                                    <input type="text" name="purpose[]" class="form-control" placeholder="Purpose" value="{{ $payment->purpose }}">
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <input type="number" step="0.01" name="amount[]" class="form-control" placeholder="Amount" value="{{ $payment->amount }}">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button type="button" class="btn btn-danger btn-sm remove-payment">Remove</button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <button type="button" class="btn btn-success mt-3" id="add-payment">Add Payment</button>
                                                    <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Add Fee Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('fees.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="student_id">Student</label>
                        <select name="student_id" class="form-control" id="student_id" required>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="year">Form</label>
                        <select name="year" class="form-control" id="year" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="total_fees">Total Fees</label>
                        <input type="number" step="0.01" name="total_fees" class="form-control" id="total_fees" required>
                    </div>

                    <div class="form-group">
                        <label for="term_one_fees">Term One Fees</label>
                        <input type="number" step="0.01" name="term_one_fees" class="form-control" id="term_one_fees" required>
                    </div>

                    <div class="form-group">
                        <label for="term_two_fees">Term Two Fees</label>
                        <input type="number" step="0.01" name="term_two_fees" class="form-control" id="term_two_fees" required>
                    </div>

                    <div class="form-group">
                        <label for="term_three_fees">Term Three Fees</label>
                        <input type="number" step="0.01" name="term_three_fees" class="form-control" id="term_three_fees" required>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control" id="status" required>
                            <option value="paid">Paid</option>
                            <option value="unpaid">Unpaid</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="uniform_others_amount">Uniform/Others Amount</label>
                        <input type="number" step="0.01" name="uniform_others_amount" class="form-control" id="uniform_others_amount">
                    </div>

                    <div class="form-group">
                        <label for="mode_of_payment">Mode of Payment</label>
                        <input type="text" name="mode_of_payment" class="form-control" id="mode_of_payment">
                    </div>

                    <!-- Other payments section -->
                    <h5>Other Payments</h5>
                    <div id="additional-fees-create">
                        <div class="row align-items-center mt-4">
                            <div class="col-md-5">
                                <input type="text" name="purpose[]" class="form-control" placeholder="Purpose">
                            </div>
                            <div class="col-md-5">
                                <input type="number" step="0.01" name="amount[]" class="form-control" placeholder="Amount">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-sm remove-payment">Remove</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success mt-3" id="add-payment">Add Payment</button>
                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('add-payment').addEventListener('click', function() {
        const container = document.getElementById('additional-fees-create');
        const index = container.children.length + 1;
        const newPayment = document.createElement('div');
        newPayment.className = 'row align-items-center mt-4';
        newPayment.innerHTML = `
            <div class="col-md-5">
                <input type="text" name="purpose[]" class="form-control" placeholder="Purpose">
            </div>
            <div class="col-md-5">
                <input type="number" step="0.01" name="amount[]" class="form-control" placeholder="Amount">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-payment">Remove</button>
            </div>
        `;
        container.appendChild(newPayment);
    });

    document.getElementById('additional-fees-create').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-payment')) {
            event.target.closest('.row').remove();
        }
    });

    document.getElementById('additional-fees-edit').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-payment')) {
            event.target.closest('.row').remove();
        }
    });

    document.getElementById('add-payment').addEventListener('click', function() {
        const container = document.getElementById('additional-fees-edit');
        const index = container.children.length + 1;
        const newPayment = document.createElement('div');
        newPayment.className = 'row align-items-center mt-4';
        newPayment.innerHTML = `
            <div class="col-md-5">
                <input type="text" name="purpose[]" class="form-control" placeholder="Purpose">
            </div>
            <div class="col-md-5">
                <input type="number" step="0.01" name="amount[]" class="form-control" placeholder="Amount">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-payment">Remove</button>
            </div>
        `;
        container.appendChild(newPayment);
    });
});
</script>
@endpush

@endsection
