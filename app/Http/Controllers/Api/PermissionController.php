<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PermissionController extends Controller
{
  public function __construct(
    private PermissionService $permissionService
  ) {}

  public function index()
  {
    $permissions = $this->permissionService->getAllPermissions();

    return response()->json($permissions);
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'name' => 'required|string|unique:permissions',
      'parent_id' => 'nullable|integer',
    ]);

    $permission = $this->permissionService->createPermission($data);
    return response()->json($permission, Response::HTTP_CREATED);
  }

  public function show(Permission $permission)
  {
    return response()->json($permission);
  }

  public function update(Request $request, Permission $permission)
  {
    $data = $request->validate([
      'name' => 'required|string|unique:permissions,name,' . $permission->id
    ]);

    $permission = $this->permissionService->updatePermission($permission, $data);
    return response()->json($permission);
  }

  public function destroy(Permission $permission)
  {
    $this->permissionService->deletePermission($permission);
    return response()->json(null, Response::HTTP_NO_CONTENT);
  }
}
