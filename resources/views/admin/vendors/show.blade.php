```blade
{{-- resources/views/admin/vendors/show.blade.php --}}
@extends('layouts.app')

@section('title', $vendor->name)

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.vendors.index') }}">Vendors</a>
    <span class="bc-sep">/</span>
    <span class="bc-current">{{ $vendor->name }}</span>
@endsection

@section('page-title', $vendor->name)
@section('page-subtitle', 'Vendor Details')

@section('page-actions')
    <a href="{{ route('admin.vendors.edit', $vendor) }}" class="btn btn-primary">
        <i class="fas fa-edit"></i> Edit
    </a>

    <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary">
        Back
    </a>
@endsection

@section('content')

    <div class="row g-3">

        <div class="col-lg-4">

            <div class="card">

                <div class="card-header">
                    Vendor Information
                </div>

                <div class="card-body">

                    <table class="table table-sm">

                        <tr>
                            <th>Code</th>
                            <td>{{ $vendor->code ?: '-' }}</td>
                        </tr>

                        <tr>
                            <th>Contact</th>
                            <td>{{ $vendor->contact_person ?: '-' }}</td>
                        </tr>

                        <tr>
                            <th>Mobile</th>
                            <td>{{ $vendor->mobile ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $vendor->phone ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $vendor->email ?: '-' }}</td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-{{ $vendor->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($vendor->status) }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>AMC</th>
                            <td>
                                {!! $vendor->provides_amc
                                    ? '<span class="badge bg-success">Yes</span>'
                                    : '<span class="badge bg-secondary">No</span>' !!}
                            </td>
                        </tr>

                    </table>

                </div>

            </div>

            <div class="card mt-3">

                <div class="card-header">
                    Address
                </div>

                <div class="card-body">
                    {{ $vendor->full_address }}
                </div>

            </div>

        </div>

        <div class="col-lg-8">

            <div class="card mb-3">

                <div class="card-header">
                    Assets ({{ $vendor->assets->count() }})
                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover mb-0">

                            <thead>
                                <tr>
                                    <th>Asset Tag</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($vendor->assets as $asset)
                                    <tr>
                                        <td>{{ $asset->asset_tag }}</td>
                                        <td>{{ $asset->name }}</td>
                                        <td>{{ $asset->category?->name }}</td>
                                        <td>{{ ucfirst($asset->status) }}</td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            No assets found.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <div class="card">

                <div class="card-header">
                    Maintenance Records
                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover mb-0">

                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Asset</th>
                                    <th>Type</th>
                                    <th>Cost</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($vendor->maintenances as $maintenance)
                                    <tr>
                                        <td>{{ $maintenance->maintenance_date }}</td>
                                        <td>{{ $maintenance->asset?->name }}</td>
                                        <td>{{ $maintenance->maintenance_type }}</td>
                                        <td>{{ number_format($maintenance->cost ?? 0, 2) }}</td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            No maintenance records found.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
```
