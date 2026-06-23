@extends('layouts.app')

@section('title', 'Assign Asset')

@section('page-title', 'Assign Asset')
@section('page-subtitle', $asset->asset_tag)

@section('content')

    <form action="{{ route('admin.assets.assign.store', $asset) }}" method="POST">

        @csrf

        <div class="row g-3">

            <div class="col-lg-8">

                <div class="card mb-3">

                    <div class="card-header">
                        Asset Information
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6">
                                <label>Asset Tag</label>
                                <input class="form-control" value="{{ $asset->asset_tag }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label>Asset Name</label>
                                <input class="form-control" value="{{ $asset->name }}" readonly>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="card">

                    <div class="card-header">
                        Assignment Details
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label>Transaction Type</label>
                                <select name="transaction_type" class="form-select" required>

                                    <option value="handover">Handover</option>
                                    <option value="transfer">Transfer</option>
                                    <option value="maintenance">Maintenance</option>

                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Assign To</label>

                                <select name="to_type" id="to_type" class="form-select" required>

                                    <option value="department">Department</option>
                                    <option value="employee">Employee</option>

                                </select>

                            </div>

                            <div class="col-md-6 department-field">
                                <label>Department</label>

                                <select name="to_department_id" id="to_department_id"
                                    class="form-select select2 @error('to_department_id') is-invalid @enderror" >
                                    <option value="">--Select Department--</option>

                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" data-rate="{{ $department->name }}">
                                            {{ $department->name }}
                                        </option>
                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-6 employee-field d-none">
                                <label>Employee</label>
                                <select name="to_employee_id" id="to_employee_id"
                                    class="form-select select2 @error('to_employee_id') is-invalid @enderror" >
                                    <option value="">-- Select Employee --</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" data-rate="{{ $employee->name }}">
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>



                            </div>

                            <div class="col-md-4">
                                <label>Building</label>
                                <input type="text" name="to_location_building" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>Floor</label>
                                <input type="text" name="to_location_floor" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>Room No.</label>
                                <input type="text" name="to_location_room_no" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Condition</label>

                                <select name="condition_at_handover" class="form-select" required>

                                    <option value="new">New</option>
                                    <option value="good">Good</option>
                                    <option value="fair">Fair</option>
                                    <option value="poor">Poor</option>
                                    <option value="condemned">Condemned</option>

                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Transaction Date</label>

                                <input type="date" name="transaction_date" class="form-control"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-12">
                                <label>Remarks</label>
                                <textarea name="remarks" rows="3" class="form-control"></textarea>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="card">

                    <div class="card-body">

                        <button class="btn btn-primary w-100">
                            <i class="fas fa-save"></i>
                            Assign Asset
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

    <script>
        document.getElementById('to_type').addEventListener('change', function() {

            document.querySelector('.department-field')
                .classList.toggle('d-none', this.value !== 'department');

            document.querySelector('.employee-field')
                .classList.toggle('d-none', this.value !== 'employee');
        });
    </script>

@endsection
