{{-- resources/views/admin/settings/organisation.blade.php --}}
@extends('layouts.app')
@section('title', 'Organisation Settings')

@section('breadcrumb')
<span class="bc-sep">/</span>
<a href="{{ route('admin.settings.general') }}">Settings</a>
<span class="bc-sep">/</span>
<span class="bc-current">Organisation</span>
@endsection

@section('page-title', 'Organisation Settings')
@section('page-subtitle', 'Configure your organisation details')

@section('content')
<div class="row g-3">
<div class="col-lg-3">
    @include('admin.settings._nav')
</div>
<div class="col-lg-9">
    <form action="{{ route('admin.settings.organisation.update') }}"
          method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-landmark text-primary"></i> Organisation Details
        </div>
        <div class="card-body">
            <div class="row g-3">

                {{-- Logo Upload --}}
                <div class="col-12">
                    <label class="form-label">Organisation Logo</label>
                    <div class="d-flex align-items-center gap-3">
                        @if($settings['org_logo'] ?? false)
                        <img src="{{ asset('storage/' . $settings['org_logo']) }}"
                             alt="Logo" style="max-height:60px;border-radius:8px;border:1px solid #e2e8f0;">
                        @else
                        <div style="width:60px;height:60px;border-radius:8px;background:#f1f5f9;border:2px dashed #e2e8f0;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-image text-muted fa-lg"></i>
                        </div>
                        @endif
                        <div>
                            <input type="file" name="org_logo"
                                   class="form-control form-control-sm"
                                   accept="image/*" style="max-width:280px;">
                            <div class="form-text">Recommended: PNG, max 500KB, 200×200px</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <label class="form-label">Organisation Name</label>
                    <input type="text" name="org_name" class="form-control"
                           value="{{ $settings['org_name'] ?? '' }}"
                           placeholder="Full name of the government office">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Website</label>
                    <input type="url" name="org_website" class="form-control"
                           value="{{ $settings['org_website'] ?? '' }}"
                           placeholder="https://...">
                </div>
                <div class="col-12">
                    <label class="form-label">Address</label>
                    <textarea name="org_address" class="form-control" rows="2"
                              placeholder="Full address">{{ $settings['org_address'] ?? '' }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">City</label>
                    <input type="text" name="org_city" class="form-control"
                           value="{{ $settings['org_city'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">State</label>
                    <input type="text" name="org_state" class="form-control"
                           value="{{ $settings['org_state'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Pincode</label>
                    <input type="text" name="org_pincode" class="form-control"
                           value="{{ $settings['org_pincode'] ?? '' }}" maxlength="6">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Phone</label>
                    <input type="text" name="org_phone" class="form-control"
                           value="{{ $settings['org_phone'] ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="org_email" class="form-control"
                           value="{{ $settings['org_email'] ?? '' }}">
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Save Settings
        </button>
    </div>
    </form>
</div>
</div>
@endsection
