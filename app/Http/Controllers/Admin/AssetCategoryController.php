<?php
// app/Http/Controllers/Admin/AssetCategoryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssetCategory;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class AssetCategoryController extends Controller
{
    public function index(): View
    {
        $categories = AssetCategory::withCount('assets')
            ->latest()->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        $icons = $this->getIconList();
        return view('admin.categories.create', compact('icons'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:100'],
            'code'              => ['required', 'string', 'max:20', 'unique:asset_categories,code'],
            'description'       => ['nullable', 'string'],
            'icon'              => ['nullable', 'string', 'max:100'],
            'depreciation_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'status'            => ['required', 'in:active,inactive'],
        ]);

        $validated['code']       = strtoupper($validated['code']);
        $validated['created_by'] = auth()->id();

        $category = AssetCategory::create($validated);

        ActivityLog::log('created', 'categories', $category);

        return redirect()->route('admin.categories.index')
            ->with('success', "Category '{$category->name}' created successfully.");
    }

    public function show(AssetCategory $category): View
    {
        $category->load('assets');
        $assets = $category->assets()->with(['vendor', 'assignedDepartment', 'assignedEmployee'])
            ->latest()->paginate(15);

        return view('admin.categories.show', compact('category', 'assets'));
    }

    public function edit(AssetCategory $category): View
    {
        $icons = $this->getIconList();
        return view('admin.categories.edit', compact('category', 'icons'));
    }

    public function update(Request $request, AssetCategory $category): RedirectResponse
    {
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:100'],
            'code'              => ['required', 'string', 'max:20', 'unique:asset_categories,code,' . $category->id],
            'description'       => ['nullable', 'string'],
            'icon'              => ['nullable', 'string', 'max:100'],
            'depreciation_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'status'            => ['required', 'in:active,inactive'],
        ]);

        $validated['code']       = strtoupper($validated['code']);
        $validated['updated_by'] = auth()->id();

        $old = $category->toArray();
        $validated['sub_categories'] = json_decode(
            $request->sub_categories,
            true
        ) ?? [];
        $category->update($validated);

        ActivityLog::log('updated', 'categories', $category, $old, $category->toArray());

        return redirect()->route('admin.categories.index')
            ->with('success', "Category updated successfully.");
    }

    public function destroy(AssetCategory $category): RedirectResponse
    {
        if ($category->assets()->count() > 0) {
            return back()->with('error', 'Cannot delete category with existing assets.');
        }

        ActivityLog::log('deleted', 'categories', $category);
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    // ── Sub Category Methods ───────────────────────────

    public function addSubCategory(Request $request, AssetCategory $category): JsonResponse
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'code'        => ['required', 'string', 'max:20'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['id']     = (string) Str::uuid();
        $validated['status'] = 'active';
        $validated['code']   = strtoupper($validated['code']);

        $category->addSubCategory($validated);

        return response()->json([
            'success'      => true,
            'message'      => 'Sub-category added.',
            'sub_category' => $validated,
        ]);
    }

    public function updateSubCategory(Request $request, AssetCategory $category, string $uuid): JsonResponse
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'code'        => ['required', 'string', 'max:20'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:active,inactive'],
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $updated = $category->updateSubCategory($uuid, $validated);

        return response()->json([
            'success' => $updated,
            'message' => $updated ? 'Sub-category updated.' : 'Sub-category not found.',
        ]);
    }

    public function deleteSubCategory(AssetCategory $category, string $uuid): JsonResponse
    {
        $deleted = $category->removeSubCategory($uuid);

        return response()->json([
            'success' => $deleted,
            'message' => $deleted ? 'Sub-category deleted.' : 'Not found.',
        ]);
    }

    // ── AJAX ──────────────────────────────────────────

    public function ajaxList(Request $request): JsonResponse
    {
        $categories = AssetCategory::active()
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->select('id', 'name', 'code', 'depreciation_rate')
            ->limit(50)->get()
            ->map(fn($c) => ['id' => $c->id, 'text' => "{$c->name} ({$c->code})",'rate'=>$c->depreciation_rate]);

        return response()->json(['data' => $categories]);
    }

    public function ajaxSubCategories(AssetCategory $category): JsonResponse
    {
        return response()->json([
            'data' => collect($category->sub_categories ?? [])
                ->where('status', 'active')
                ->values(),
        ]);
    }

    private function getIconList(): array
    {
        return [
            'fas fa-laptop'          => 'Laptop',
            'fas fa-desktop'         => 'Desktop',
            'fas fa-print'           => 'Printer',
            'fas fa-server'          => 'Server',
            'fas fa-phone'           => 'Phone',
            'fas fa-mobile-alt'      => 'Mobile',
            'fas fa-chair'           => 'Chair',
            'fas fa-couch'           => 'Furniture',
            'fas fa-car'             => 'Vehicle',
            'fas fa-tools'           => 'Tools',
            'fas fa-plug'            => 'Electrical',
            'fas fa-wifi'            => 'Network',
            'fas fa-camera'          => 'Camera',
            'fas fa-tv'              => 'Display/TV',
            'fas fa-keyboard'        => 'Keyboard',
            'fas fa-hdd'             => 'Storage',
            'fas fa-microchip'       => 'Electronics',
            'fas fa-boxes-stacked'   => 'General',
            'fas fa-fire-extinguisher'=> 'Safety',
            'fas fa-fan'             => 'Appliances',
            'fas fa-building'        => 'Infrastructure',
            'fas fa-book'            => 'Books/Stationery',
            'fas fa-shield-halved'   => 'Security',
            'fas fa-stethoscope'     => 'Medical',
        ];
    }
}
