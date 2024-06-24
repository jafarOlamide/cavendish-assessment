<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {

        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = $this->create($request->all());

        //Sanctum API Token
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    protected function create(array $data)
    {
        $role = Role::select('id')->where('name', RoleTypes::USER)->first();
        $role_id = $role->id;

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id'  => $role_id
        ]);
    }
}
