<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'username' => $fields['username'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->CreateToken('myapptoken')->plainTextToken;

        $response = [
            'username'   => $user,
            'token'      => $token
        ];

        return response($response, 201);

    }

    public function login(Request $request){
        $fields = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check username
        $user = User::where('username', $fields['username'])->first();

        // Check pwd
        if (!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message' => 'Incorrect login',
                'status'  => '401'
            ]);
        }

        $token = $user->CreateToken('myapptoken')->plainTextToken;

        $response = [
            'username'  => $user,
            'token'     => $token,
            'status'    => '201'
        ];

        return response($response);

    }

    public function logout (Request $request){
        $request->user()->tokens()->delete();

        return [
            'message' => 'Logged out!'
        ];
    }
}
