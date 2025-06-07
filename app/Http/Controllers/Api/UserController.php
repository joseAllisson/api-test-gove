<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
  public function __construct(
    private UserService $userService
  ) {}

  public function index(Request $request)
  {
    $perPage = $request->query('per_page', 10);
    $users = $this->userService->paginateUsers($perPage);

    return response()->json($users);
  }

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
      'permissions.*' => 'exists:permissions,id',
    ]);

    $user = $this->userService->createUser($validated);

    return response()->json($user, Response::HTTP_CREATED);
  }

  public function show($id)
  {
    $user = User::findOrFail($id);
    return response()->json($user);
  }

  public function update(Request $request, $id)
  {
    $user = User::findOrFail($id)->first();

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

    $updatedUser = $this->userService->updateUser($user, $validated);

    return response()->json($updatedUser);
  }

  public function destroy($id)
  {
    $user = User::findOrFail($id)->first();
    $this->userService->deleteUser($user);

    return response()->json(null, status: Response::HTTP_NO_CONTENT);
  }
}
