{{-- resources/views/partials/alerts.blade.php --}}
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 shadow-sm"
     role="alert">
    <div class="d-flex gap-3">
        <i class="fas fa-circle-exclamation fa-lg mt-1 text-danger"></i>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-1 ps-3">
                @foreach($errors->all() as $error)
                <li style="font-size:13px;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
