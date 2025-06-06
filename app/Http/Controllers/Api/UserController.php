<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  // Listar com paginação
  public function index(Request $request)
  {
    $perPage = $request->query('per_page', 10);
    $users = User::with('permissions')->paginate($perPage);

    return response()->json($users);
  }

  // Criar usuário
  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string',
      'email' => 'required|email|unique:users',
      'phone' => 'nullable|string',
      'last_login' => 'nullable|date',
      'user_type' => 'nullable|string',
      'sector' => 'nullable|string',
      'permissions' => 'nullable|array',
    ]);

    // Criar usuário
    $user = User::create($validated);

    // Atribuir permissões se existirem
    if (!empty($validated['permissions'])) {
      $user->permissions()->sync($validated['permissions']);
    }

    return response()->json($user->load('permissions'), 201);
  }

  // Mostrar usuário
  public function show($id)
  {
    $user = User::findOrFail($id);
    return response()->json($user);
  }

  // Atualizar usuário
  public function update(Request $request, $id)
  {
    $user = User::findOrFail($id);

    $validated = $request->validate([
      'name' => 'sometimes|required|string',
      'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
      'phone' => 'nullable|string',
      'last_login' => 'nullable|date',
      'user_type' => 'nullable|string',
      'sector' => 'nullable|string',
      'permissions' => 'nullable|array',
      'permissions.*' => 'exists:permissions,id',
    ]);

    $user->update($validated);

    if (array_key_exists('permissions', $validated)) {
      $user->permissions()->sync($validated['permissions'] ?? []);
    }

    return response()->json($user);
  }

  // Deletar usuário
  public function destroy($id)
  {
    $user = User::findOrFail($id);
    $user->delete();

    return response()->json(null, 204);
  }
}
