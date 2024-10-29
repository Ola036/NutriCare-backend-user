<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
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
        
        $token = $request->user()->createToken('Ola');

        return [
            'token' => $token->plainTextToken,
            'user' => $request->user()
        ];
    }
}
