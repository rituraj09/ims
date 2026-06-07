{{-- resources/views/admin/roles/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Roles & Permissions')

@section('breadcrumb')
<span class="bc-sep">/</span>
<span class="bc-current">Roles</span>
@endsection

@section('page-title', 'Roles & Permissions')
@section('page-subtitle', 'Manage system roles and access permissions')

@section('content')
<div class="row g-3">
    @foreach($roles as $role)
    @php
        $roleColors = [
            'super_admin' => ['bg-danger',  'text-danger',  'fa-crown'],
            'admin'       => ['bg-primary', 'text-primary', 'fa-user-shield'],
            'author'      => ['bg-info',    'text-info',    'fa-pen-nib'],
            'user'        => ['bg-secondary','text-secondary','fa-user'],
        ];
        [$bg, $text, $icon] = $roleColors[$role->name] ?? ['bg-secondary','text-secondary','fa-user'];
    @endphp
    <div class="col-md-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body text-center py-4">
                <div class="mx-auto mb-3"
                     style="width:60px;height:60px;border-radius:15px;display:flex;align-items:center;justify-content:center;font-size:24px;"
                     class="{{ $bg }} bg-opacity-10 {{ $text }}">
                    <i class="fas {{ $icon }}"></i>
                </div>
                <h5 class="fw-800 mb-1">{{ $role->display_name }}</h5>
                <p class="text-muted text-sm mb-3">{{ $role->description ?? 'System role' }}</p>
                <div class="d-flex justify-content-center gap-3 mb-3">
                    <div class="text-center">
                        <div class="fw-700 fs-5">{{ $role->permissions_count }}</div>
                        <div class="text-xs text-muted">Permissions</div>
                    </div>
                    <div class="vr"></div>
                    <div class="text-center">
                        <div class="fw-700 fs-5">{{ $role->users_count }}</div>
                        <div class="text-xs text-muted">Users</div>
                    </div>
                </div>
                @if(!($role->name === 'super_admin'))
                <a href="{{ route('admin.roles.permissions', $role) }}"
                   class="btn btn-primary btn-sm w-100">
                    <i class="fas fa-key me-1"></i> Manage Permissions
                </a>
                @else
                <button class="btn btn-secondary btn-sm w-100" disabled>
                    <i class="fas fa-infinity me-1"></i> All Permissions
                </button>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
