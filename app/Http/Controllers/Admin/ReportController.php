<?php
// app/Http/Controllers/Admin/ReportController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function assets(Request $request): View
    {
        $assets = Asset::with(['category', 'vendor', 'assignedDepartment', 'assignedEmployee'])
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->department_id, fn($q) => $q->where('assigned_department_id', $request->department_id))
            ->latest()->paginate(50);

        return view('admin.reports.assets', compact('assets'));
    }

    public function department(Request $request): View
    {
        $departments = Department::withCount('assets')
            ->with('assets.category')
            ->where('status', 'active')
            ->get();

        return view('admin.reports.department', compact('departments'));
    }

    public function depreciation(Request $request): View
    {
        $assets = Asset::with('category')
            ->whereNotNull('purchase_price')
            ->whereNotNull('depreciation_rate')
            ->latest()->paginate(50);

        return view('admin.reports.depreciation', compact('assets'));
    }

    public function warranty(Request $request): View
    {
        $assets = Asset::with(['category', 'vendor'])
            ->whereNotNull('warranty_expiry_date')
            ->orderBy('warranty_expiry_date')
            ->paginate(50);

        return view('admin.reports.warranty', compact('assets'));
    }

    public function amc(Request $request): View
    {
        $assets = Asset::with(['category', 'vendor'])
            ->where('under_amc', true)
            ->orderBy('amc_end_date')
            ->paginate(50);

        return view('admin.reports.amc', compact('assets'));
    }

    public function export(Request $request, string $type)
    {
        // Will implement with Excel/PDF export
        return back()->with('info', 'Export feature coming soon.');
    }
}
