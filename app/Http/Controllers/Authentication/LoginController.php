<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            return response()->json([
                "message" => "This is an invaild password.",
                "errors" => [
                    "email" => [
                        "This is an invaild password."
                    ]
                ]
            ], 422);
        }

        $user = $request->user();
        $token = $user->createToken('Ola');

        return [
            'message' => 'Welcome, ' . $user->name,
            'token' => $token->plainTextToken,
            'user' => $user
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'Goodbye! ' . $request->user()->name
        ];
    }
}
