<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
  public function index()
  {
    $permissions = Permission::with('children')->whereNull('parent_id')->get();

    return response()->json($permissions);
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'name' => 'required|string|unique:permissions',
      'parent_id' => 'nullable|integer',
    ]);

    if (isset($data['parent_id'])) {
      $parent = Permission::find($data['parent_id']);

      if (!$parent) {
        return response()->json(['error' => 'Permissão pai não encontrada.'], 400);
      }

      if ($parent->parent_id !== null) {
        return response()->json(['error' => 'A permissão pai não pode ser filha de outra.'], 400);
      }
    }

    $permission = Permission::create($data);

    return response()->json($permission, 201);
  }

  public function show(Permission $permission)
  {
    return $permission;
  }

  public function update(Request $request, Permission $permission)
  {
    $data = $request->validate(['name' => 'required|string|unique:permissions,name,' . $permission->id]);
    $permission->update($data);

    return response()->json($permission);
  }

  public function destroy(Permission $permission)
  {
    $permission->delete();

    return response()->json(null, 204);
  }
}
