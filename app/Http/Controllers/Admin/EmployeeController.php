<?php
// app/Http/Controllers/Admin/EmployeeController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use App\Models\Designation;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(Request $request): View
    {
        $employees = User::with(['designation', 'department', 'role'])
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%")
                ->orWhere('employee_id', 'like', "%{$request->search}%"))
            ->when($request->department_id, fn($q) => $q->where('department_id', $request->department_id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->role_id, fn($q) => $q->where('role_id', $request->role_id))
            ->latest()->paginate(25)->withQueryString();

        $departments = Department::active()->get();
        $roles       = Role::all();

        return view('admin.employees.index',
            compact('employees', 'departments', 'roles'));
    }

    public function create(): View
    {
        $designations = Designation::active()->ordered()->get();
        $departments  = Department::active()->get();
        $roles        = Role::all();

        return view('admin.employees.create',
            compact('designations', 'departments', 'roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id'    => ['nullable', 'string', 'max:50', 'unique:users,employee_id'],
            'name'           => ['required', 'string', 'max:150'],
            'email'          => ['nullable', 'email', 'max:150', 'unique:users,email'],
            'mobile'         => ['nullable', 'string', 'max:15'],
            'gender'         => ['nullable', 'in:male,female,other'],
            'designation_id' => ['nullable', 'exists:designations,id'],
            'department_id'  => ['nullable', 'exists:departments,id'],
            'role_id'        => ['nullable', 'exists:roles,id'],
            'is_system_user' => ['boolean'],
            'password'       => ['nullable', 'required_if:is_system_user,1', 'min:8', 'confirmed'],
            'status'         => ['required', 'in:active,inactive'],
            'joining_date'   => ['nullable', 'date'],
            'notes'          => ['nullable', 'string'],
        ]);

        $validated['is_system_user'] = $request->boolean('is_system_user');

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $employee = User::create($validated);
        ActivityLog::log('created', 'employees', $employee);

        return redirect()->route('admin.employees.index')
            ->with('success', "Employee '{$employee->name}' created.");
    }

    public function show(User $employee): View
    {
        $employee->load(['designation', 'department', 'role', 'assignedAssets.category']);
        $assets = $employee->assignedAssets()->with('category')->paginate(10);
        return view('admin.employees.show', compact('employee', 'assets'));
    }

    public function edit(User $employee): View
    {
        $designations = Designation::active()->ordered()->get();
        $departments  = Department::active()->get();
        $roles        = Role::all();
        return view('admin.employees.edit',
            compact('employee', 'designations', 'departments', 'roles'));
    }

    public function update(Request $request, User $employee): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id'    => ['nullable', 'string', 'max:50', 'unique:users,employee_id,' . $employee->id],
            'name'           => ['required', 'string', 'max:150'],
            'email'          => ['nullable', 'email', 'max:150', 'unique:users,email,' . $employee->id],
            'mobile'         => ['nullable', 'string', 'max:15'],
            'gender'         => ['nullable', 'in:male,female,other'],
            'designation_id' => ['nullable', 'exists:designations,id'],
            'department_id'  => ['nullable', 'exists:departments,id'],
            'role_id'        => ['nullable', 'exists:roles,id'],
            'is_system_user' => ['boolean'],
            'status'         => ['required', 'in:active,inactive'],
            'joining_date'   => ['nullable', 'date'],
            'notes'          => ['nullable', 'string'],
        ]);

        $validated['is_system_user'] = $request->boolean('is_system_user');
        $employee->update($validated);
        ActivityLog::log('updated', 'employees', $employee);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee updated.');
    }

    public function destroy(User $employee): RedirectResponse
    {
        if ($employee->assignedAssets()->count() > 0) {
            return back()->with('error', 'Employee has assigned assets. Please reassign first.');
        }
        ActivityLog::log('deleted', 'employees', $employee);
        $employee->delete();
        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee deleted.');
    }

    public function assets(User $employee): View
    {
        $assets = $employee->assignedAssets()->with('category')->paginate(15);
        return view('admin.employees.assets', compact('employee', 'assets'));
    }

    public function ajaxList(Request $request): JsonResponse
    {
        $employees = User::active()
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->select('id', 'name', 'employee_id', 'designation_id')
            ->with('designation:id,name')
            ->limit(50)->get()
            ->map(fn($e) => [
                'id'   => $e->id,
                'text' => $e->name . ($e->employee_id ? " ({$e->employee_id})" : ''),
            ]);

        return response()->json(['data' => $employees]);
    }
}
