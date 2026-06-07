@extends('layouts.app')

@section('title', 'Warranty Report')

@section('page-title', 'Warranty Expiry Report')
@section('page-subtitle', 'Track warranty expiry dates')
@section('page-actions')

    <button type="button" class="btn btn-outline-danger" onclick="window.print()">
        <i class="fas fa-print"></i> Print
    </button>
@endsection
@section('content')

    <div class="card">

        <div class="card-header">
            Warranty Tracking
        </div>

        <div class="table-responsive">

            <table class="table table-hover mb-0">

                <thead>
                    <tr>
                        <th>Asset</th>
                        <th>Category</th>
                        <th>Vendor</th>
                        <th>Warranty Expiry</th>
                        <th>Days Left</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($assets as $asset)
                        <tr>

                            <td>{{ $asset->name }}</td>

                            <td>{{ $asset->category?->name }}</td>

                            <td>{{ $asset->vendor?->name }}</td>

                            <td>
                                {{ optional($asset->warranty_expiry_date)->format('d M Y') }}
                            </td>

                            <td>
                                @php
                                    $days = now()->diffInDays($asset->warranty_expiry_date, false);
                                @endphp

                                <span class="badge bg-{{ $days < 0 ? 'danger' : ($days <= 30 ? 'warning' : 'success') }}">
                                    {{ $days }}
                                </span>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                No warranty records found.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-3">
        {{ $assets->links('pagination::bootstrap-5') }}
    </div>
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
