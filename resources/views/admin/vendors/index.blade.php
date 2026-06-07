{{-- resources/views/admin/vendors/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Vendors')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <span class="bc-current">Vendors</span>
@endsection

@section('page-title', 'Vendors')
@section('page-subtitle', 'Manage asset suppliers and AMC vendors')

@section('page-actions')
    @can('vendors.create')
        <a href="{{ route('admin.vendors.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Vendor
        </a>
    @endcan
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-truck me-2 text-primary"></i>All Vendors
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Vendor Name</th>
                            <th>Contact</th>
                            <th>GSTIN</th>
                            <th>AMC</th>
                            <th>Assets</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vendors as $i => $vendor)
                            <tr>
                                <td class="text-muted text-sm">{{ $vendors->firstItem() + $i }}</td>
                                <td>
                                    <a href="{{ route('admin.vendors.show', $vendor) }}"
                                        class="fw-600 text-dark text-decoration-none">
                                        {{ $vendor->name }}
                                    </a>
                                    @if ($vendor->code)
                                        <code class="ms-1 text-xs text-primary">{{ $vendor->code }}</code>
                                    @endif
                                    @if ($vendor->city)
                                        <div class="text-xs text-muted">{{ $vendor->city }}, {{ $vendor->state }}</div>
                                    @endif
                                </td>
                                <td class="text-sm">
                                    @if ($vendor->contact_person)
                                        <div class="fw-500">{{ $vendor->contact_person }}</div>
                                    @endif
                                    @if ($vendor->mobile)
                                        <div class="text-muted">{{ $vendor->mobile }}</div>
                                    @endif
                                </td>
                                <td class="text-sm">
                                    @if ($vendor->gstin)
                                        <code>{{ $vendor->gstin }}</code>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($vendor->provides_amc)
                                        <span class="badge bg-success bg-opacity-10 text-success">
                                            <i class="fas fa-check me-1"></i>Yes
                                        </span>
                                    @else
                                        <span class="text-muted text-sm">No</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        {{ $vendor->assets_count }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="status-pill text-{{ $vendor->status === 'active' ? 'success' : 'danger' }} bg-{{ $vendor->status === 'active' ? 'success' : 'danger' }} bg-opacity-10">
                                        {{ ucfirst($vendor->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.vendors.show', $vendor) }}"
                                            class="btn btn-icon btn-sm btn-outline-info">
                                            <i class="fas fa-eye fa-xs"></i>
                                        </a>
                                        @can('vendors.edit')
                                            <a href="{{ route('admin.vendors.edit', $vendor) }}"
                                                class="btn btn-icon btn-sm btn-outline-primary">
                                                <i class="fas fa-pen fa-xs"></i>
                                            </a>
                                        @endcan
                                        @can('vendors.delete')
                                            <form action="{{ route('admin.vendors.destroy', $vendor) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-sm btn-outline-danger"
                                                    data-confirm="Delete vendor '{{ $vendor->name }}'?">
                                                    <i class="fas fa-trash fa-xs"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-truck fa-3x opacity-25 d-block mb-3"></i>
                                    No vendors found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($vendors->hasPages())
            <div class="card-footer">{{ $vendors->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>
@endsection
