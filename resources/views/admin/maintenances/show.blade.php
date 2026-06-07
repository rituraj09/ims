@extends('layouts.app')

@section('title', 'Maintenance Details')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.maintenances.index') }}">Maintenance</a>
    <span class="bc-sep">/</span>
    <span class="bc-current">{{ $maintenance->reference_no ?? 'Details' }}</span>
@endsection

@section('page-title', 'Maintenance Record')
@section('page-subtitle', $maintenance->asset->asset_tag . ' • ' . ucfirst($maintenance->maintenance_type))

@section('page-actions')

    @can('maintenance.edit')
        <a href="{{ route('admin.maintenances.edit', $maintenance) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-pen"></i> Edit
        </a>
    @endcan

    <a href="{{ route('admin.assets.show', $maintenance->asset) }}" class="btn btn-outline-info btn-sm">
        <i class="fas fa-laptop"></i> Asset
    </a>

    <a href="{{ route('admin.maintenances.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back
    </a>

@endsection

@section('content')

    @php
        $statusColors = [
            'scheduled' => 'info',
            'in_progress' => 'warning',
            'completed' => 'success',
            'cancelled' => 'danger',
        ];

        $conditionColors = [
            'new' => 'success',
            'good' => 'info',
            'fair' => 'warning',
            'poor' => 'danger',
            'condemned' => 'dark',
        ];
    @endphp

    {{-- Status Summary --}}
    <div class="alert border-0 mb-3 d-flex justify-content-between align-items-center"
        style="background:linear-gradient(135deg,#f8fafc,#eff6ff);">

        <div class="d-flex align-items-center gap-2 flex-wrap">

            <span
                class="status-pill
            text-{{ $statusColors[$maintenance->status] ?? 'secondary' }}
            bg-{{ $statusColors[$maintenance->status] ?? 'secondary' }}
            bg-opacity-10">

                {{ ucfirst(str_replace('_', ' ', $maintenance->status)) }}
            </span>

            <span class="badge bg-secondary bg-opacity-10 text-secondary">
                {{ ucfirst($maintenance->maintenance_type) }}
            </span>

            @if ($maintenance->condition_after)
                <span
                    class="badge
                bg-{{ $conditionColors[$maintenance->condition_after] ?? 'secondary' }}
                bg-opacity-10
                text-{{ $conditionColors[$maintenance->condition_after] ?? 'secondary' }}">
                    Condition:
                    {{ ucfirst($maintenance->condition_after) }}
                </span>
            @endif

        </div>

        <div class="text-muted text-sm">
            Created {{ $maintenance->created_at->diffForHumans() }}
        </div>

    </div>

    <div class="row g-3">

        {{-- LEFT COLUMN --}}
        <div class="col-lg-8">

            {{-- Asset Details --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-laptop text-primary"></i>
                    Asset Information
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <div class="text-xs text-muted text-uppercase fw-700">
                                Asset Tag
                            </div>
                            <code>{{ $maintenance->asset->asset_tag }}</code>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="text-xs text-muted text-uppercase fw-700">
                                Asset Name
                            </div>
                            <div>{{ $maintenance->asset->name }}</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="text-xs text-muted text-uppercase fw-700">
                                Category
                            </div>
                            <div>{{ $maintenance->asset->category?->name ?? '—' }}</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="text-xs text-muted text-uppercase fw-700">
                                Serial No.
                            </div>
                            <div>{{ $maintenance->asset->serial_no ?? '—' }}</div>
                        </div>

                    </div>

                </div>
            </div>

            {{-- Maintenance Details --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-screwdriver-wrench text-warning"></i>
                    Maintenance Details
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <div class="text-xs text-muted fw-700 text-uppercase">
                                Maintenance Type
                            </div>
                            <div>{{ ucfirst($maintenance->maintenance_type) }}</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="text-xs text-muted fw-700 text-uppercase">
                                Reference No.
                            </div>
                            <div>{{ $maintenance->reference_no ?? '—' }}</div>
                        </div>

                        @if ($maintenance->issue_description)
                            <div class="col-12 mb-3">
                                <div class="text-xs text-muted fw-700 text-uppercase">
                                    Issue Description
                                </div>
                                <div>{{ $maintenance->issue_description }}</div>
                            </div>
                        @endif

                        @if ($maintenance->work_done)
                            <div class="col-12 mb-3">
                                <div class="text-xs text-muted fw-700 text-uppercase">
                                    Work Done
                                </div>
                                <div>{{ $maintenance->work_done }}</div>
                            </div>
                        @endif

                        @if ($maintenance->parts_replaced)
                            <div class="col-12">
                                <div class="text-xs text-muted fw-700 text-uppercase">
                                    Parts Replaced
                                </div>
                                <div>{{ $maintenance->parts_replaced }}</div>
                            </div>
                        @endif

                    </div>

                </div>
            </div>

            {{-- Remarks --}}
            @if ($maintenance->remarks)
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-comment text-secondary"></i>
                        Remarks
                    </div>

                    <div class="card-body">
                        {!! nl2br(e($maintenance->remarks)) !!}
                    </div>
                </div>
            @endif

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col-lg-4">

            {{-- Schedule --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-calendar-alt text-info"></i>
                    Schedule
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <div class="text-xs text-muted fw-700 text-uppercase">
                            Scheduled Date
                        </div>
                        <div>
                            {{ $maintenance->scheduled_date?->format('d/m/Y') ?? '—' }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="text-xs text-muted fw-700 text-uppercase">
                            Start Date
                        </div>
                        <div>
                            {{ $maintenance->start_date?->format('d/m/Y') }}
                        </div>
                    </div>

                    <div>
                        <div class="text-xs text-muted fw-700 text-uppercase">
                            Completion Date
                        </div>
                        <div>
                            {{ $maintenance->completion_date?->format('d/m/Y') ?? 'Pending' }}
                        </div>
                    </div>

                </div>
            </div>

            {{-- Vendor / Technician --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-user-cog text-success"></i>
                    Vendor / Technician
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <div class="text-xs text-muted fw-700 text-uppercase">
                            Vendor
                        </div>
                        <div>
                            {{ $maintenance->vendor?->name ?? '—' }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="text-xs text-muted fw-700 text-uppercase">
                            Technician
                        </div>
                        <div>
                            {{ $maintenance->technician_name ?? '—' }}
                        </div>
                    </div>

                    <div>
                        <div class="text-xs text-muted fw-700 text-uppercase">
                            Contact
                        </div>
                        <div>
                            {{ $maintenance->technician_contact ?? '—' }}
                        </div>
                    </div>

                </div>
            </div>

            {{-- Cost & Invoice --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-file-invoice-dollar text-primary"></i>
                    Cost & Invoice
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <div class="text-xs text-muted fw-700 text-uppercase">
                            Maintenance Cost
                        </div>

                        <div class="fs-5 fw-700 text-success">
                            @if ($maintenance->maintenance_cost)
                                ₹ {{ number_format($maintenance->maintenance_cost, 2) }}
                            @else
                                —
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="text-xs text-muted fw-700 text-uppercase">
                            Invoice No.
                        </div>

                        <div>{{ $maintenance->invoice_no ?? '—' }}</div>
                    </div>

                    @if ($maintenance->invoice_file)
                        <a href="{{ asset('storage/' . $maintenance->invoice_file) }}" target="_blank"
                            class="btn btn-outline-primary w-100">

                            <i class="fas fa-download"></i>
                            View Invoice
                        </a>
                    @endif

                </div>
            </div>

            {{-- Record Info --}}
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-circle-info text-secondary"></i>
                    Record Information
                </div>

                <div class="card-body">

                    <div class="mb-2">
                        <span class="text-muted">Created By:</span>
                        <strong>
                            {{ $maintenance->createdBy?->name ?? 'System' }}
                        </strong>
                    </div>

                    <div class="mb-2">
                        <span class="text-muted">Created On:</span>
                        <strong>
                            {{ $maintenance->created_at->format('d/m/Y H:i') }}
                        </strong>
                    </div>

                    @if ($maintenance->updatedBy)
                        <div class="mb-2">
                            <span class="text-muted">Updated By:</span>
                            <strong>
                                {{ $maintenance->updatedBy->name }}
                            </strong>
                        </div>
                    @endif

                    <div>
                        <span class="text-muted">Last Updated:</span>
                        <strong>
                            {{ $maintenance->updated_at->format('d/m/Y H:i') }}
                        </strong>
                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection
