<?php
// app/Http/Controllers/Admin/VendorController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class VendorController extends Controller
{
    public function index(): View
    {
        $vendors = Vendor::withCount(['assets', 'maintenances'])
            ->latest()->paginate(20);

        return view('admin.vendors.index', compact('vendors'));
    }

    public function create(): View
    {
        return view('admin.vendors.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:150'],
            'code'           => ['nullable', 'string', 'max:20', 'unique:vendors,code'],
            'contact_person' => ['nullable', 'string', 'max:100'],
            'mobile'         => ['nullable', 'string', 'max:15'],
            'phone'          => ['nullable', 'string', 'max:20'],
            'email'          => ['nullable', 'email', 'max:150'],
            'website'        => ['nullable', 'url', 'max:255'],
            'address'        => ['nullable', 'string'],
            'city'           => ['nullable', 'string', 'max:100'],
            'state'          => ['nullable', 'string', 'max:100'],
            'pincode'        => ['nullable', 'string', 'max:10'],
            'gstin'          => ['nullable', 'string', 'max:20'],
            'pan'            => ['nullable', 'string', 'max:15'],
            'bank_name'      => ['nullable', 'string', 'max:100'],
            'bank_account_no'=> ['nullable', 'string', 'max:30'],
            'bank_ifsc'      => ['nullable', 'string', 'max:15'],
            'provides_amc'   => ['boolean'],
            'amc_terms'      => ['nullable', 'string'],
            'status'         => ['required', 'in:active,inactive'],
            'notes'          => ['nullable', 'string'],
        ]);

        $validated['provides_amc'] = $request->boolean('provides_amc');
        $validated['created_by']   = auth()->id();

        $vendor = Vendor::create($validated);
        ActivityLog::log('created', 'vendors', $vendor);

        return redirect()->route('admin.vendors.index')
            ->with('success', "Vendor '{$vendor->name}' created.");
    }

    public function show(Vendor $vendor): View
    {
        $vendor->load(['assets.category', 'maintenances.asset']);
        return view('admin.vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor): View
    {
        return view('admin.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor): RedirectResponse
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:150'],
            'code'           => ['nullable', 'string', 'max:20', 'unique:vendors,code,' . $vendor->id],
            'contact_person' => ['nullable', 'string', 'max:100'],
            'mobile'         => ['nullable', 'string', 'max:15'],
            'phone'          => ['nullable', 'string', 'max:20'],
            'email'          => ['nullable', 'email', 'max:150'],
            'website'        => ['nullable', 'url', 'max:255'],
            'address'        => ['nullable', 'string'],
            'city'           => ['nullable', 'string', 'max:100'],
            'state'          => ['nullable', 'string', 'max:100'],
            'pincode'        => ['nullable', 'string', 'max:10'],
            'gstin'          => ['nullable', 'string', 'max:20'],
            'pan'            => ['nullable', 'string', 'max:15'],
            'provides_amc'   => ['boolean'],
            'amc_terms'      => ['nullable', 'string'],
            'status'         => ['required', 'in:active,inactive'],
            'notes'          => ['nullable', 'string'],
        ]);

        $validated['provides_amc'] = $request->boolean('provides_amc');
        $validated['updated_by']   = auth()->id();

        $vendor->update($validated);
        ActivityLog::log('updated', 'vendors', $vendor);

        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendor updated successfully.');
    }

    public function destroy(Vendor $vendor): RedirectResponse
    {
        if ($vendor->assets()->count() > 0) {
            return back()->with('error', 'Cannot delete vendor with associated assets.');
        }

        ActivityLog::log('deleted', 'vendors', $vendor);
        $vendor->delete();

        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendor deleted.');
    }

    public function ajaxList(Request $request): JsonResponse
    {
        $vendors = Vendor::active()
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->select('id', 'name', 'mobile', 'email')
            ->limit(50)->get()
            ->map(fn($v) => ['id' => $v->id, 'text' => $v->name]);

        return response()->json(['data' => $vendors]);
    }
}
