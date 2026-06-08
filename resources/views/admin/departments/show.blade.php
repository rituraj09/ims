@extends('layouts.app')

@section('title', $department->name)

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.departments.index') }}">Departments</a>
    <span class="bc-sep">/</span>
    <span class="bc-current">{{ $department->name }}</span>
@endsection

@section('page-title', $department->name)
@section('page-subtitle', 'Department Details')

@section('page-actions')
@can('departments.edit')
    <a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-primary">
        <i class="fas fa-edit"></i> Edit
    </a>
@endcan
    <a href="{{ route('admin.departments.index') }}" class="btn btn-outline-secondary">
        Back
    </a>

@endsection

@section('content')

    <div class="row g-3">

        {{-- Information --}}
        <div class="col-lg-4">

            <div class="card mb-3">

                <div class="card-header">
                    Department Information
                </div>

                <div class="card-body">

                    <table class="table table-sm">

                        <tr>
                            <th>Code</th>
                            <td>{{ $department->code ?: '-' }}</td>
                        </tr>

                        <tr>
                            <th>Parent</th>
                            <td>{{ $department->parent?->name ?: '-' }}</td>
                        </tr>

                        <tr>
                            <th>Head</th>
                            <td>{{ $department->head?->name ?: '-' }}</td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-{{ $department->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($department->status) }}
                                </span>
                            </td>
                        </tr>

                    </table>

                </div>

            </div>

            <div class="card mb-3">

                <div class="card-header">
                    Location
                </div>

                <div class="card-body">

                    <p class="mb-2">
                        {{ $department->full_location }}
                    </p>

                    <small class="text-muted">
                        {{ $department->address }}
                    </small>

                </div>

            </div>

            <div class="card">

                <div class="card-header">
                    Contact
                </div>

                <div class="card-body">

                    <div>{{ $department->phone ?: 'N/A' }}</div>
                    <div>{{ $department->email ?: 'N/A' }}</div>

                </div>

            </div>

        </div>

        {{-- Employees & Assets --}}
        <div class="col-lg-8">

            {{-- Employees --}}
            <div class="card mb-3">

                <div class="card-header">
                    Employees ({{ $employees->total() }})
                </div>

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Email</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($employees as $employee)
                                <tr>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->designation?->name }}</td>
                                    <td>{{ $employee->email }}</td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        No employees found.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- Assets --}}
            <div class="card">

                <div class="card-header">
                    Assigned Assets ({{ $assets->total() }})
                </div>

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead>
                            <tr>
                                <th>Asset Tag</th>
                                <th>Name</th>
                                <th>Category</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($assets as $asset)
                                <tr>
                                    <td>{{ $asset->asset_tag }}</td>
                                    <td>{{ $asset->name }}</td>
                                    <td>{{ $asset->category?->name }}</td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        No assets assigned.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection
