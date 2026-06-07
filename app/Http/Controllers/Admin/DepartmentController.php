<?php
// app/Http/Controllers/Admin/DepartmentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(): View
    {
        $departments = Department::with(['parent', 'head'])
            ->withCount(['assets', 'employees'])
            ->whereNull('parent_id')
            ->latest()->paginate(20);

        return view('admin.departments.index', compact('departments'));
    }

    public function create(): View
    {
        $departments = Department::active()->whereNull('parent_id')->get();
        $employees   = User::active()->get();
        return view('admin.departments.create', compact('departments', 'employees'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:150'],
            'code'         => ['nullable', 'string', 'max:20', 'unique:departments,code'],
            'parent_id'    => ['nullable', 'exists:departments,id'],
            'head_user_id' => ['nullable', 'exists:users,id'],
            'building'     => ['nullable', 'string', 'max:100'],
            'block'        => ['nullable', 'string', 'max:50'],
            'floor'        => ['nullable', 'string', 'max:20'],
            'room_no'      => ['nullable', 'string', 'max:30'],
            'address'      => ['nullable', 'string'],
            'city'         => ['nullable', 'string', 'max:100'],
            'state'        => ['nullable', 'string', 'max:100'],
            'pincode'      => ['nullable', 'string', 'max:10'],
            'phone'        => ['nullable', 'string', 'max:20'],
            'email'        => ['nullable', 'email', 'max:150'],
            'status'       => ['required', 'in:active,inactive'],
            'notes'        => ['nullable', 'string'],
        ]);

        if (!empty($validated['code'])) {
            $validated['code'] = strtoupper($validated['code']);
        }

        $department = Department::create($validated);
        ActivityLog::log('created', 'departments', $department);

        return redirect()->route('admin.departments.index')
            ->with('success', "Department '{$department->name}' created successfully.");
    }

    public function show(Department $department): View
    {
        $department->load(['parent', 'head', 'children', 'assets.category']);
        $employees = User::where('department_id', $department->id)
            ->with('designation')->paginate(10);
        $assets = $department->assets()->with('category')
            ->latest()->paginate(10);

        return view('admin.departments.show',
            compact('department', 'employees', 'assets'));
    }

    public function edit(Department $department): View
    {
        $departments = Department::active()
            ->whereNull('parent_id')
            ->where('id', '!=', $department->id)
            ->get();
        $employees = User::active()->get();
        return view('admin.departments.edit',
            compact('department', 'departments', 'employees'));
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:150'],
            'code'         => ['nullable', 'string', 'max:20', 'unique:departments,code,' . $department->id],
            'parent_id'    => ['nullable', 'exists:departments,id'],
            'head_user_id' => ['nullable', 'exists:users,id'],
            'building'     => ['nullable', 'string', 'max:100'],
            'block'        => ['nullable', 'string', 'max:50'],
            'floor'        => ['nullable', 'string', 'max:20'],
            'room_no'      => ['nullable', 'string', 'max:30'],
            'address'      => ['nullable', 'string'],
            'city'         => ['nullable', 'string', 'max:100'],
            'state'        => ['nullable', 'string', 'max:100'],
            'pincode'      => ['nullable', 'string', 'max:10'],
            'phone'        => ['nullable', 'string', 'max:20'],
            'email'        => ['nullable', 'email', 'max:150'],
            'status'       => ['required', 'in:active,inactive'],
            'notes'        => ['nullable', 'string'],
        ]);

        $old = $department->toArray();
        $department->update($validated);
        ActivityLog::log('updated', 'departments', $department, $old, $department->toArray());

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department): RedirectResponse
    {
        if ($department->assets()->count() > 0) {
            return back()->with('error', 'Cannot delete department with assigned assets.');
        }
        if ($department->employees()->count() > 0) {
            return back()->with('error', 'Cannot delete department with assigned employees.');
        }

        ActivityLog::log('deleted', 'departments', $department);
        $department->delete();

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department deleted.');
    }

    public function ajaxList(Request $request): JsonResponse
    {
        $depts = Department::active()
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->select('id', 'name', 'code')
            ->limit(50)->get()
            ->map(fn($d) => ['id' => $d->id, 'text' => $d->name . ($d->code ? " ({$d->code})" : '')]);

        return response()->json(['data' => $depts]);
    }
}
