<?php

namespace App\Services;

use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionService
{
    public function getAllPermissions()
    {
        return Permission::with('children')->whereNull('parent_id')->get();
    }

    public function createPermission(array $data): Permission
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['parent_id'])) {
                $this->validateParentPermission($data['parent_id']);
            }

            return Permission::create($data);
        });
    }

    public function updatePermission(Permission $permission, array $data): Permission
    {
        $permission->update($data);
        return $permission;
    }

    public function deletePermission(Permission $permission): void
    {
        $permission->delete();
    }

    protected function validateParentPermission(int $parentId): void
    {
        $parent = Permission::findOrFail($parentId);

        if ($parent->parent_id !== null) {
            throw new \InvalidArgumentException('A permissão pai não pode ser filha de outra.');
        }
    }
}