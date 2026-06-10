@extends('layouts.app')

@section('title', $assignment->form_no)

@section('breadcrumb') <span class="bc-sep">/</span> <a href="{{ route('admin.assignments.index') }}">Assignments</a>
    <span class="bc-sep">/</span> <span class="bc-current">{{ $assignment->form_no }}</span>
@endsection

@section('page-title', 'Assignment Details')
@section('page-subtitle', $assignment->form_no)

@section('page-actions')

    <div class="d-flex gap-2">
        @if(!$assignment->handover_form_path)
            <a href="{{ route('admin.assignments.print', $assignment->id) }}" target="_blank" class="btn btn-outline-danger">
                <i class="fas fa-print"></i> Print
            </a>
        @endif
        <a href="{{ route('admin.assignments.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>

    </div>
@endsection

@section('content')

    <div class="row g-3">


        {{-- LEFT --}}
        <div class="col-lg-8">

            {{-- Transaction Summary --}}
            <div class="card mb-3">

                <div class="card-header">
                    <i class="fas fa-file-signature text-primary"></i>
                    Transaction Information
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="text-muted text-xs">FORM NO</div>
                            <code>{{ $assignment->form_no }}</code>
                        </div>

                        <div class="col-md-4">
                            <div class="text-muted text-xs">TYPE</div>

                            @php
                                $colors = [
                                    'handover' => 'primary',
                                    'takeover' => 'warning',
                                    'transfer' => 'info',
                                    'maintenance' => 'secondary',
                                ];
                            @endphp

                            <span class="badge bg-{{ $colors[$assignment->transaction_type] ?? 'secondary' }}">
                                {{ ucfirst($assignment->transaction_type) }}
                            </span>
                        </div>

                        <div class="col-md-4">
                            <div class="text-muted text-xs">DATE</div>
                            <strong>
                                {{ $assignment->transaction_date?->format('d/m/Y') }}
                            </strong>
                        </div>

                    </div>

                </div>

            </div>

            {{-- Asset Information --}}
            <div class="card mb-3">

                <div class="card-header">
                    <i class="fas fa-box text-success"></i>
                    Asset Information
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <div class="text-muted text-xs">ASSET TAG</div>
                            <code>{{ $assignment->asset->asset_tag }}</code>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="text-muted text-xs">CATEGORY</div>
                            <strong>{{ $assignment->asset->category?->name }}</strong>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="text-muted text-xs">ASSET NAME</div>
                            {{ $assignment->asset->name }}
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="text-muted text-xs">SERIAL NO</div>
                            {{ $assignment->asset->serial_no ?? 'N/A' }}
                        </div>

                    </div>

                </div>

            </div>

            {{-- Movement Details --}}
            <div class="card mb-3">

                <div class="card-header">
                    <i class="fas fa-exchange-alt text-info"></i>
                    Movement Details
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="border rounded p-3 h-100">

                                <div class="fw-bold mb-2 text-danger">
                                    FROM
                                </div>

                                <div>
                                    {{ $assignment->from_holder_name }}
                                </div>

                                @if ($assignment->from_location_building)
                                    <small class="text-muted d-block">
                                        Building:
                                        {{ $assignment->from_location_building }}
                                    </small>
                                @endif

                                @if ($assignment->from_location_floor)
                                    <small class="text-muted d-block">
                                        Floor:
                                        {{ $assignment->from_location_floor }}
                                    </small>
                                @endif

                                @if ($assignment->from_location_room_no)
                                    <small class="text-muted d-block">
                                        Room:
                                        {{ $assignment->from_location_room_no }}
                                    </small>
                                @endif

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="border rounded p-3 h-100">

                                <div class="fw-bold mb-2 text-success">
                                    TO
                                </div>

                                <div>
                                    {{ $assignment->to_holder_name }}
                                </div>

                                @if ($assignment->to_location_building)
                                    <small class="text-muted d-block">
                                        Building:
                                        {{ $assignment->to_location_building }}
                                    </small>
                                @endif

                                @if ($assignment->to_location_floor)
                                    <small class="text-muted d-block">
                                        Floor:
                                        {{ $assignment->to_location_floor }}
                                    </small>
                                @endif

                                @if ($assignment->to_location_room_no)
                                    <small class="text-muted d-block">
                                        Room:
                                        {{ $assignment->to_location_room_no }}
                                    </small>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Condition --}}
            <div class="card mb-3">

                <div class="card-header">
                    <i class="fas fa-shield-alt text-warning"></i>
                    Asset Condition
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="text-muted text-xs">
                                CONDITION AT HANDOVER
                            </div>

                            <span class="badge bg-success">
                                {{ ucfirst($assignment->condition_at_handover ?? 'N/A') }}
                            </span>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted text-xs">
                                CONDITION AT RETURN
                            </div>

                            <span class="badge bg-warning text-dark">
                                {{ ucfirst($assignment->condition_at_return ?? 'N/A') }}
                            </span>
                        </div>

                    </div>

                </div>

            </div>

            {{-- Remarks --}}
            <div class="card">

                <div class="card-header">
                    <i class="fas fa-comment text-secondary"></i>
                    Remarks
                </div>

                <div class="card-body">

                    {{ $assignment->remarks ?: 'No remarks available.' }}

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="col-lg-4">

            {{-- Upload Form --}}
            <div class="card mb-3">

                <div class="card-header">
                    <i class="fas fa-file-upload"></i>
                    Signed Form
                </div>

                <div class="card-body">

                    @if ($assignment->handover_form_path)
                        <a href="{{ asset('storage/' . $assignment->handover_form_path) }}" target="_blank"
                            class="btn btn-success w-100">

                            <i class="fas fa-file-pdf"></i>
                            View Uploaded Form

                        </a>
                    @else
                        @php
                            $canManage =
                                auth()->user()->role?->name === 'super_admin' ||
                                auth()->user()->department_id === $assignment->asset->home_department_id;
                        @endphp
                        @if ($canManage)
                            <form action="{{ route('admin.assignments.upload-form', $assignment->id) }}" method="POST"
                                enctype="multipart/form-data">

                                @csrf

                                <div class="mb-3">
                                    <input type="file" name="form_file" class="form-control" required>
                                </div>

                                <button class="btn btn-primary w-100">
                                    <i class="fas fa-upload"></i>
                                    Upload Signed Form
                                </button>

                            </form>
                        @else
                            No Sign form available
                        @endif
                    @endif

                </div>

            </div>

            {{-- Authorization --}}
            <div class="card mb-3">

                <div class="card-header">
                    <i class="fas fa-user-check"></i>
                    Authorization
                </div>

                <div class="card-body">

                    <div class="mb-2">
                        <small class="text-muted">Authorized By</small>
                        <div>
                            {{ $assignment->authorizedBy?->name ?? 'Not Assigned' }}
                        </div>
                    </div>

                    <div class="mb-2">
                        <small class="text-muted">Created By</small>
                        <div>
                            {{ $assignment->createdBy?->name ?? 'System' }}
                        </div>
                    </div>

                    <div>
                        <small class="text-muted">Created At</small>
                        <div>
                            {{ $assignment->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>

                </div>

            </div>

            {{-- Documents --}}
            <div class="card">

                <div class="card-header">
                    <i class="fas fa-paperclip"></i>
                    Documents
                </div>

                <div class="card-body">

                    @forelse($assignment->documents as $doc)
                        <div class="border rounded p-2 mb-2">

                            <div class="fw-semibold">
                                {{ $doc->title }}
                            </div>

                            <a href="{{ route('admin.documents.download', $doc) }}"
                                class="btn btn-sm btn-outline-primary mt-2">

                                Download

                            </a>

                        </div>

                    @empty

                        <div class="text-muted">
                            No documents attached.
                        </div>
                    @endforelse

                </div>

            </div>

        </div>

    </div>

@endsection
