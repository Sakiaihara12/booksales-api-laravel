<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(['success' => true, 'message' => 'List Data User', 'data' => User::latest()->get()]);
    }

    public function show(User $user)
    {
        return response()->json(['success' => true, 'message' => 'Detail User', 'data' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'username' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:8|confirmed',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);
        return response()->json(['success' => true, 'message' => 'User diperbarui', 'data' => $user]);
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'Tidak bisa menghapus akunmu sendiri'], 403);
        }
        $user->delete();
        return response()->json(['success' => true, 'message' => 'User dihapus']);
    }
}
