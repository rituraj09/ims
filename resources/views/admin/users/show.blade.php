@extends('layouts.app')

@section('title', 'User Details')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.users.index') }}">Users</a>
    <span class="bc-sep">/</span>
    <span class="bc-current">{{ $user->name }}</span>
@endsection

@section('page-title', 'User Details')
@section('page-subtitle', 'View employee information and assigned assets')

@section('page-actions')
    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
        <i class="fas fa-edit"></i> Edit
    </a>

    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
@endsection

@section('content')

    <div class="row g-3">

        {{-- Profile Card --}}
        <div class="col-lg-4">

            <div class="card">
                <div class="card-body text-center">

                    <img src="{{ $user->profile_photo_url }}" class="rounded-circle border shadow-sm mb-3" width="120"
                        height="120" alt="{{ $user->name }}">

                    <h4 class="mb-1">{{ $user->name }}</h4>

                    <p class="text-muted mb-3">
                        {{ $user->designation?->name ?? 'No Designation' }}
                    </p>

                    <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($user->status) }}
                    </span>

                    @if ($user->is_system_user)
                        <span class="badge bg-primary">
                            System User
                        </span>
                    @endif

                    <hr>

                    <div class="text-start">

                        <div class="mb-3">
                            <small class="text-muted d-block">Employee ID</small>
                            <strong>{{ $user->employee_id ?: 'N/A' }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Email</small>
                            <strong>{{ $user->email }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Mobile</small>
                            <strong>{{ $user->mobile ?: 'N/A' }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Gender</small>
                            <strong>{{ ucfirst($user->gender ?? 'N/A') }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Joining Date</small>
                            <strong>
                                {{ $user->joining_date?->format('d M Y') ?? 'N/A' }}
                            </strong>
                        </div>

                        @if ($user->leaving_date)
                            <div class="mb-3">
                                <small class="text-muted d-block">Leaving Date</small>
                                <strong>{{ $user->leaving_date->format('d M Y') }}</strong>
                            </div>
                        @endif

                    </div>

                </div>
            </div>

        </div>

        {{-- Details --}}
        <div class="col-lg-8">

            {{-- Organization Information --}}
            <div class="card mb-3">

                <div class="card-header">
                    <i class="fas fa-sitemap text-primary"></i>
                    Organization Information
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block">Role</small>
                            <strong>{{ $user->role?->name ?? 'N/A' }}</strong>
                        </div>

                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block">Department</small>
                            <strong>{{ $user->department?->name ?? 'N/A' }}</strong>
                        </div>

                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block">Designation</small>
                            <strong>{{ $user->designation?->name ?? 'N/A' }}</strong>
                        </div>

                    </div>

                </div>

            </div>

            {{-- Assigned Assets --}}
            <div class="card mb-3">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-laptop text-primary"></i>
                        Assigned Assets
                    </span>

                    <span class="badge bg-primary">
                        {{ $user->assignedAssets->count() }}
                    </span>
                </div>

                <div class="card-body p-0">

                    @if ($user->assignedAssets->count())

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">
                                    <tr>
                                        <th>Asset Tag</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($user->assignedAssets as $asset)
                                        <tr>

                                            <td>
                                                <span class="fw-semibold">
                                                    {{ $asset->asset_tag }}
                                                </span>
                                            </td>

                                            <td>
                                                {{ $asset->name }}
                                            </td>

                                            <td>
                                                {{ $asset->category?->name ?? 'N/A' }}
                                            </td>

                                            <td>
                                                <span class="badge bg-info">
                                                    {{ ucfirst($asset->status) }}
                                                </span>
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-box-open fa-2x mb-2 opacity-50"></i>
                            <div>No assets assigned</div>
                        </div>

                    @endif

                </div>

            </div>
            @php
                $user = auth()->user();
                $isSuperAdmin = $user->isSuperAdmin();
                $isAdmin = $user->isAdmin();
                $can = ['activity-logs' => $isSuperAdmin || $user->hasPermission('activity-logs')];
            @endphp
            @if ($can['activity-logs'])
                {{-- Recent Activity --}}
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>
                            <i class="fas fa-history text-primary"></i>
                            Recent Activity
                        </span>

                        <span class="badge bg-secondary">
                            {{ $recentLogs->count() }}
                        </span>
                    </div>

                    <div class="card-body p-0">

                        @if ($recentLogs->count())

                            <div class="table-responsive">
                                <table class="table table-hover mb-0">

                                    <thead class="table-light">
                                        <tr>
                                            <th>Action</th>
                                            <th>Module</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($recentLogs as $log)
                                            <tr>

                                                <td>
                                                    <span class="badge bg-primary">
                                                        {{ ucfirst($log->action) }}
                                                    </span>
                                                </td>

                                                <td>
                                                    {{ ucfirst($log->module ?? '-') }}
                                                </td>

                                                <td>
                                                    {{ $log->created_at->format('d M Y h:i A') }}
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>
                        @else
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-history fa-2x mb-2 opacity-50"></i>
                                <div>No activity logs found</div>
                            </div>

                        @endif

                    </div>

                </div>
            @endif
        </div>

    </div>

@endsection
