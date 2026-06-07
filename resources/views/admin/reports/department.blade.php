@extends('layouts.app')

@section('title', 'Department Asset Report')

@section('page-title', 'Department Report')
@section('page-subtitle', 'Assets grouped by department')
@section('page-actions')

    <button type="button" class="btn btn-outline-danger" onclick="window.print()">
        <i class="fas fa-print"></i> Print
    </button>
@endsection
@section('content')

    @foreach ($departments as $department)
        <div class="card mb-3">

            <div class="card-header d-flex justify-content-between">

                <strong>{{ $department->name }}</strong>

                <span class="badge bg-primary">
                    {{ $department->assets_count }} Assets
                </span>

            </div>

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead>
                        <tr>
                            <th>Asset Tag</th>
                            <th>Name</th>
                            <th>Category</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($department->assets as $asset)
                            <tr>
                                <td>{{ $asset->asset_tag }}</td>
                                <td>{{ $asset->name }}</td>
                                <td>{{ $asset->category?->name }}</td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    No assets assigned
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    @endforeach
    @push('styles')
        <style>
            @media print {

                body {
                    background: #fff !important;
                }

                .sidebar,
                .navbar,
                .topbar,
                .page-actions,
                .btn,
                .pagination,
                footer,
                .breadcrumb {
                    display: none !important;
                }

                .card {
                    border: none !important;
                    box-shadow: none !important;
                }

                .card-header {
                    background: transparent !important;
                    border-bottom: 2px solid #000 !important;
                    font-weight: bold;
                }

                .table {
                    width: 100% !important;
                    border-collapse: collapse !important;
                }

                .table th,
                .table td {
                    border: 1px solid #000 !important;
                    padding: 6px !important;
                }

                .container-fluid,
                .content-wrapper,
                .main-content {
                    width: 100% !important;
                    margin: 0 !important;
                    padding: 0 !important;
                }

                @page {
                    size: A4 landscape;
                    margin: 10mm;
                }
            }
        </style>
    @endpush
@endsection
