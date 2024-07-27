<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getAllUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function getUserById($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function createUser(Request $request)
    {
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user, 200);
    }

    public function deleteUser($id)
    {
        User::destroy($id);
        return response()->json(null, 204);
    }

    
}

