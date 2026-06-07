@extends('layouts.app')

@section('title', 'Depreciation Report')

@section('page-title', 'Depreciation Report')
@section('page-subtitle', 'Asset depreciation tracking')
@section('page-actions')

    <button type="button" class="btn btn-outline-danger" onclick="window.print()">
        <i class="fas fa-print"></i> Print
    </button>
@endsection
@section('content')

    <div class="card">

        <div class="card-header">
            Depreciation Summary
        </div>

        <div class="table-responsive">

            <table class="table table-hover mb-0">

                <thead>
                    <tr>
                        <th>Asset</th>
                        <th>Category</th>
                        <th>Purchase Price</th>
                        <th>Rate (%)</th>
                        <th>Purchase Date</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($assets as $asset)
                        <tr>
                            <td>{{ $asset->name }}</td>
                            <td>{{ $asset->category?->name }}</td>
                            <td>{{ number_format($asset->purchase_price, 2) }}</td>
                            <td>{{ $asset->depreciation_rate }}</td>
                            <td>{{ $asset->purchase_date }}</td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                No records found
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
