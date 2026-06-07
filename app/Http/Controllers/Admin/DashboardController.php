<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index(): View
    {
        // ── Stats ─────────────────────────────────────────
        $stats = [
            'total_assets'       => Asset::count(),
            'in_use'             => Asset::where('status', 'in_use')->count(),
            'available'          => Asset::where('status', 'available')->count(),
            'under_maintenance'  => Asset::where('status', 'under_maintenance')->count(),
            'disposed'           => Asset::where('status', 'disposed')->count(),
            'total_departments'  => Department::where('status', 'active')->count(),
        ];

        // ── Alerts ────────────────────────────────────────
        $alerts = [
            'warranty_expiring'   => Asset::warrantyExpiringSoon(30)->count(),
            'amc_expiring'        => Asset::amcExpiringSoon(30)->count(),
            'pending_maintenance' => AssetMaintenance::pending()->count(),
        ];

        // ── Recent Assets ─────────────────────────────────
        $recentAssets = Asset::with('category')
            ->latest()
            ->take(8)
            ->get();

        // ── Financial Summary ─────────────────────────────
        $financial = [
            'total_purchase_value' => Asset::sum('purchase_price') ?? 0,
            'total_current_value'  => Asset::sum('current_value') ?? 0,
            'total_depreciation'   => (Asset::sum('purchase_price') ?? 0)
                                    - (Asset::sum('current_value') ?? 0),
            'maintenance_cost_ytd' => AssetMaintenance::whereYear('start_date', date('Y'))
                                        ->sum('maintenance_cost') ?? 0,
        ];

        // ── Category Chart Data ───────────────────────────
        $categoryData  = Asset::selectRaw('category_id, count(*) as total')
            ->with('category:id,name')
            ->groupBy('category_id')
            ->get();

        $categoryChart = [
            'labels' => $categoryData->map(fn($c) => $c->category?->name ?? 'Unknown')
                                     ->toArray(),
            'data'   => $categoryData->pluck('total')->toArray(),
        ];

        // ── Top Departments ───────────────────────────────
        $topDepartments = Department::withCount('assets')
            ->where('status', 'active')
            ->orderByDesc('assets_count')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'stats',
            'alerts',
            'recentAssets',
            'financial',
            'categoryChart',
            'topDepartments'
        ));
    }
}
