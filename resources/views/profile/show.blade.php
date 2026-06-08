{{-- resources/views/profile/show.blade.php --}}
@extends('layouts.app')
@section('title', 'My Profile')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <span class="bc-current">My Profile</span>
@endsection

@section('page-title', 'My Profile')
@section('page-subtitle', 'View and update your profile information')

@section('content')
    <div class="row g-3">

        {{-- Profile Card --}}
        <div class="col-lg-4">
            <div class="card text-center">
                <div class="card-body py-4">
                    <div class="position-relative d-inline-block mb-3">
                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="rounded-circle"
                            style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:3px solid #e2e8f0;">
                        <button type="button" class="btn btn-warning btn-sm rounded-circle position-absolute"
                            data-bs-toggle="modal" data-bs-target="#profilePhotoModal"
                            style="bottom:5px;right:5px;width:34px;height:34px;">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                    <h5 class="fw-800 mb-1">{{ $user->name }}</h5>
                    <p class="text-muted text-sm mb-2">{{ $user->designation?->name ?? 'N/A' }}</p>
                    @if ($user->role)
                        <span class="badge bg-primary bg-opacity-10 text-primary">
                            {{ $user->role->display_name }}
                        </span>
                    @endif
                    <hr>
                    <div class="text-start">
                        @if ($user->employee_id)
                            <div class="d-flex justify-content-between py-1 border-bottom">
                                <span class="text-muted text-sm">Employee ID</span>
                                <code class="text-primary">{{ $user->employee_id }}</code>
                            </div>
                        @endif
                        @if ($user->email)
                            <div class="d-flex justify-content-between py-1 border-bottom">
                                <span class="text-muted text-sm">Email</span>
                                <span class="text-sm fw-500">{{ $user->email }}</span>
                            </div>
                        @endif
                        @if ($user->mobile)
                            <div class="d-flex justify-content-between py-1 border-bottom">
                                <span class="text-muted text-sm">Mobile</span>
                                <span class="text-sm">{{ $user->mobile }}</span>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span class="text-muted text-sm">Department</span>
                            <span class="text-sm">{{ $user->department?->name ?? 'N/A' }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-1">
                            <span class="text-muted text-sm">Status</span>
                            <span class="status-pill text-success bg-success bg-opacity-10">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Assigned Assets --}}
            <div class="card mt-3">
                <div class="card-header">
                    <i class="fas fa-boxes-stacked text-primary"></i>
                    My Assets ({{ $user->assignedAssets->count() }})
                </div>
                <div class="card-body p-0">
                    @forelse($user->assignedAssets->take(5) as $asset)
                        <div class="d-flex align-items-center gap-2 px-3 py-2 border-bottom">
                            <i class="{{ $asset->category?->icon ?? 'fas fa-box' }} text-primary"></i>
                            <div class="flex-grow-1">
                                <div class="text-sm fw-600">{{ $asset->name }}</div>
                                <div class="text-xs text-muted">{{ $asset->asset_tag }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-3 text-muted text-sm">
                            No assets assigned
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Edit Profile --}}
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-pen text-primary"></i> Edit Profile
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                        class="needs-validation" novalidate>
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="">-- Select --</option>
                                    <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>Female
                                    </option>
                                    <option value="other" {{ $user->gender === 'other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mobile</label>
                                <input type="text" name="mobile" class="form-control"
                                    value="{{ old('mobile', $user->mobile) }}">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Profile
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Change Password --}}
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-key text-warning"></i> Change Password
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.password.update') }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Current Password <span class="text-danger">*</span></label>
                                <input type="password" name="current_password"
                                    class="form-control @error('current_password') is-invalid @enderror" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">New Password <span class="text-danger">*</span></label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required minlength="8">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-key"></i> Change Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- Profile Photo Modal -->
    <div class="modal fade" id="profilePhotoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">
                            Update Profile Photo
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="text-center mb-3">
                            <img src="{{ $user->profile_photo_url }}" class="rounded-circle"
                                style="width:120px;height:120px;object-fit:cover;">
                        </div>

                        <div>
                            <label class="form-label">
                                Select New Photo
                            </label>

                            <input type="file" name="photo" class="form-control" accept="image/*" required>

                            <small class="text-muted">
                                JPG, PNG, WEBP. Max 2MB
                            </small>

                            @error('photo')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i>
                            Upload Photo
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
