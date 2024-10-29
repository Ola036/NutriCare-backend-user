<?php

namespace App\Http\Controllers\Authentication;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\ResetRequest;

class ResetPasswordController extends Controller
{
    public function reset(ResetRequest $request)
    {
        User::where('email', $request->email)
            ->first()
            ->update(['password' => '123456789']);

        return [
            'message' => 'Your password has been reset.'
        ];
    }
}
