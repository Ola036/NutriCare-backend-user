<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        $user->information()->create();

        $user->sendEmailVerificationNotification();

        $token = $user->createToken('Ola');

        return [
            'token' => $token->plainTextToken,
            'user' => $user->load('information')
        ];
    }
}
