@extends('layouts.app')

@section('title', 'Asset Assignments')

@section('page-title', 'Asset Assignment History')
@section('page-subtitle', 'Track handovers, takeovers and transfers')

@section('page-actions')
@endsection

@section('content')

    <div class="card mb-3">
        <div class="card-body">

            <form method="GET">
                <div class="row g-2">

                    <div class="col-md-3">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                            placeholder="Form No / Asset Tag / Asset Name">
                    </div>

                    <div class="col-md-3">
                        <select name="type" class="form-select">
                            <option value="">All Types</option>
                            <option value="handover" @selected(request('type') == 'handover')>Handover</option>
                            <option value="takeover" @selected(request('type') == 'takeover')>Takeover</option>
                            <option value="transfer" @selected(request('type') == 'transfer')>Transfer</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
                    </div>

                    <div class="col-md-1 col-6 d-flex gap-1">
                        <button type="submit"class="btn btn-primary"
                            style="flex: 1;
                                       justify-content: center;
                                       padding: 8px 12px;
                                       white-space: nowrap;">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="{{ route('admin.assignments.index') }}" class="btn btn-outline-secondary"
                            title="Clear Filters"
                            style="padding: 8px 10px;
                                      justify-content: center;
                                      flex-shrink: 0;">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <div class="card">

        <div class="card-header">
            Assignment Records
        </div>

        <div class="table-responsive">

            <table class="table table-hover mb-0">

                <thead>
                    <tr>
                        <th>Form No</th>
                        <th>Asset Tag</th>
                        <th>Asset Name</th>
                        <th>Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($assignments as $assignment)
                        <tr>

                            <td>
                                <code>{{ $assignment->form_no }}</code>
                            </td>

                            <td>
                                <a href="{{ route('admin.assets.show', $assignment->asset) }}">
                                    {{ $assignment->asset->asset_tag }}
                                </a>
                            </td>
                            <td>
                                {{ $assignment->asset->name ?? '-' }}
                            </td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ ucfirst($assignment->transaction_type) }}
                                </span>
                            </td>

                            <td>{{ $assignment->from_holder_name }}</td>

                            <td>{{ $assignment->to_holder_name }}</td>

                            <td>
                                {{ $assignment->transaction_date->format('d/m/Y') }}
                            </td>

                            <td>

                                <a href="{{ route('admin.assignments.show', $assignment->id) }}"
                                    class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('admin.assignments.print', $assignment->id) }}" target="_blank"
                                    class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-print"></i>
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center py-5">
                                No assignment records found.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="card-footer">
            {{ $assignments->links('pagination::bootstrap-5') }}
        </div>

    </div>

@endsection
