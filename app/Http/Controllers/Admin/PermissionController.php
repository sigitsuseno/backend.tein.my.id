<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function page()
    {
        return view('admin.user-manager.permission');
    }

    public function index()
    {
        $permissions = Permission::all();

        return response()->json(['data' => $permissions]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
            'group_name' => 'nullable|string|max:100',
        ]);
        $slug = Str::slug($request->name);
        $i = 0;
        $originalSlug = $slug;

        while (Permission::where('slug', $slug)->exists()) {
            $i++;
            $slug = $originalSlug.'-'.$i;
        }

        $validated['slug'] = $slug;
        Permission::create($validated);

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return response()->json(['data' => $permission]);
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:roles,name,'.$id,
            'group_name' => 'required|integer|min:1',
        ]);

        $slug = Str::slug($request->name);
        $i = 0;
        $originalSlug = $slug;

        while (Permission::where('slug', $slug)->exists()) {
            $i++;
            $slug = $originalSlug.'-'.$i;
        }

        $validated['slug'] = $slug;

        $permission->update($validated);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Permission::destroy($id);

        return response()->json(['success' => true]);
    }
}
