{{-- resources/views/components/layout/footer.blade.php --}}
<footer class="page-footer">
    <span>
        &copy; {{ date('Y') }}
        <strong>{{ config('app.name', 'GovAsset Manager') }}</strong>
        &mdash; Government Asset Management System
    </span>
    <span class="d-none d-md-inline">
        Version 1.0.0
        &bull; PHP {{ PHP_VERSION }}
        &bull; Laravel {{ app()->version() }}
    </span>
</footer>
