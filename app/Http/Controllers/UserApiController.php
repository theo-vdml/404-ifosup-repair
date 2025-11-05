<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q', '');

        if (empty($q)) {
            return response()->json([]);
        }

        $users = \App\Models\User::whereRaw("CONCAT(name, ' ', email) LIKE ?", ["%{$q}%"])
            ->orderBy('name')
            ->limit(10)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'full_name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role ? ucfirst($user->role->value) : 'User',
                ];
            });

        return response()->json($users);
    }
}
