<?php
// app/Http/Controllers/Admin/DesignationController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class DesignationController extends Controller
{
    public function index(): View
    {
        $designations = Designation::withCount('users')
            ->ordered()->paginate(25);

        return view('admin.designations.index', compact('designations'));
    }

    public function create(): View
    {
        return view('admin.designations.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'                => ['required', 'string', 'max:100'],
            'slug'                => ['nullable', 'string', 'max:100', 'unique:designations,slug'],
            'department_category' => ['nullable', 'string', 'max:100'],
            'sort_order'          => ['nullable', 'integer', 'min:0'],
            'status'              => ['required', 'in:active,inactive'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        Designation::create($validated);

        return redirect()->route('admin.designations.index')
            ->with('success', 'Designation created successfully.');
    }

    public function edit(Designation $designation): View
    {
        return view('admin.designations.edit', compact('designation'));
    }

    public function update(Request $request, Designation $designation): RedirectResponse
    {
        $validated = $request->validate([
            'name'                => ['required', 'string', 'max:100'],
            'slug'                => ['nullable', 'string', 'max:100',
                                     'unique:designations,slug,' . $designation->id],
            'department_category' => ['nullable', 'string', 'max:100'],
            'sort_order'          => ['nullable', 'integer', 'min:0'],
            'status'              => ['required', 'in:active,inactive'],
        ]);

        $designation->update($validated);

        return redirect()->route('admin.designations.index')
            ->with('success', 'Designation updated.');
    }

    public function destroy(Designation $designation): RedirectResponse
    {
        if ($designation->users()->count() > 0) {
            return back()->with('error', 'Cannot delete designation with assigned employees.');
        }

        $designation->delete();

        return redirect()->route('admin.designations.index')
            ->with('success', 'Designation deleted.');
    }

    public function show(Designation $designation): View
    {
        return view('admin.designations.show', compact('designation'));
    }
}
