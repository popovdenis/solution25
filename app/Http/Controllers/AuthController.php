<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $r)
    {
        $data = $r->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string|min:8',
        ]);

        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>bcrypt($data['password']),
        ]);

        return response()->json(['user'=>$user], 201);
    }

    public function login(Request $r)
    {
        $creds = $r->validate(['email'=>'required|email','password'=>'required|string']);
        if (! $token = auth('api')->attempt($creds)) {
            return response()->json(['message'=>'Invalid credentials'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function logout() {
        auth('api')->logout();
        return response()->json([],200);
    }
    public function refresh() {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken(string $token)
    {
        $ttl = (int) auth('api')->factory()->getTTL();
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $ttl * 60,
        ]);
    }
}
