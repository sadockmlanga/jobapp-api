<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'company' => 'string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:recruiter,user'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }


        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'company' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $roleName = $request->role;
        $role = Role::where('name', $roleName)->first();

        if ($role) {
            $user->assignRole($role);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        $details = [
            'name' => $user->firstName . ' ' . $user->lastName,
            'email' => $user->email,
            'role' => $role->id,
            'token' => $token

        ];
        return response()->json(["user" => $details ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        
        if (Auth::attempt($credentials)) {        
            // dd($credentials);
                $user = Auth::user();
                $roleId = $user->roles()->pluck('id')->first();

                $token = $user->createToken('authToken')->plainTextToken;

                $details = [
                    'name' => $user->firstName . ' ' . $user->lastName,
                    'email' => $user->email,
                    'role' => $roleId,
                    'token' => $token

                ];

                return response()->json(['user' => $details], 200);
            }
            else {
                return response()->json(['message' => 'Unauthorized'], 401);

            }
        }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }


}
