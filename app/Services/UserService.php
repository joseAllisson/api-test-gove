<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
  public function paginateUsers(
    int $perPage = 10,
    string $orderBy = 'name',
    string $order = 'asc'
  ) {
    return User::with('permissions')
      ->orderBy($orderBy, $order)
      ->paginate($perPage);
  }

  public function findUserById(int $id): ?User
  {
    return User::with('permissions')->find($id);
  }

  public function createUser(array $data)
  {
    return DB::transaction(function () use ($data) {
      $user = User::create($data);

      if (!empty($data['permissions'])) {
        $user->permissions()->sync($data['permissions']);
      }

      return $user->load('permissions');
    });
  }

  public function updateUser(User $user, array $data)
  {
    return DB::transaction(function () use ($user, $data) {
      $user->update($data);

      if (array_key_exists('permissions', $data)) {
        $user->permissions()->sync($data['permissions'] ?? []);
      }

      return $user;
    });
  }

  public function deleteUser(User $user): void
  {
    $user->delete();
  }
}
