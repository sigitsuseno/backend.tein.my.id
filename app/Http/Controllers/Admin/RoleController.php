<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function page()
    {
        return view('admin.user-manager.role');
    }

    public function index()
    {
        $roles = Role::all();

        return response()->json(['data' => $roles]);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
            'level' => 'required|integer|min:1',
        ]);

        $slug = Str::slug($request->name);
        $i = 0;
        $originalSlug = $slug;

        while (Role::where('slug', $slug)->exists()) {
            $i++;
            $slug = $originalSlug.'-'.$i;
        }

        $validated['slug'] = $slug;

        Role::create($validated);

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        return response()->json(['data' => $role]);
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:roles,name,'.$id,
            'level' => 'required|integer|min:1',
        ]);

        $slug = Str::slug($request->name);
        $i = 0;
        $originalSlug = $slug;

        while (Role::where('slug', $slug)->exists()) {
            $i++;
            $slug = $originalSlug.'-'.$i;
        }

        $validated['slug'] = $slug;

        $role->update($validated);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Role::destroy($id);

        return response()->json(['success' => true]);
    }
}
