<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('permission.index'), only: ['index']),
            new Middleware(PermissionMiddleware::using('permission.create'), only: ['store']),
            new Middleware(PermissionMiddleware::using('permission.update'), only: ['update']),
            new Middleware(PermissionMiddleware::using('permission.delete'), only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::query()
            ->withCount('roles')
            ->orderBy('name')
            ->paginate(10);

        $modalState = null;

        if (session()->has('errors') && session()->hasOldInput('name')) {
            $modalState = [
                'open' => true,
                'mode' => old('permission_id') ? 'edit' : 'create',
                'permissionId' => old('permission_id'),
                'name' => old('name'),
            ];
        }

        return view('dashboard.permissions.index', [
            'permissions' => $permissions,
            'modalState' => $modalState,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-z][a-z0-9-]*(\.[a-z][a-z0-9-]*)*$/', 'unique:permissions,name'],
        ]);

        Permission::create(['name' => $validated['name']]);

        return redirect()->route('dashboard.permissions.index')
            ->with('success', 'Permission berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-z][a-z0-9-]*(\.[a-z][a-z0-9-]*)*$/', Rule::unique('permissions', 'name')->ignore($permission->id)],
        ]);

        $permission->update(['name' => $validated['name']]);

        return redirect()->route('dashboard.permissions.index')
            ->with('success', 'Permission berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return back()->with('success', 'Permission berhasil dihapus.');
    }
}
