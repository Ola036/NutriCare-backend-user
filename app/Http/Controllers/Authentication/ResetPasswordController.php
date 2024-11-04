<?php

namespace App\Http\Controllers\Authentication;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\ResetRequest;
use App\Http\Requests\Authentication\ForgotRequest;
use App\Notifications\Authentication\ForgotPasswordNotification;

class ResetPasswordController extends Controller
{
    public function forgot(ForgotRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        $user->update([
            'reset_code' => rand(111111, 999999)
        ]);

        $user->notify(new ForgotPasswordNotification);

        return [
            'message' => 'Your reset password email has been sent.'
        ];
    }

    public function reset(ResetRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user->reset_code != $request->code) {
            return response()->json([
                'message' => 'Invalid Code',
                'errors' => [
                    'code' => [
                        'Invalid code'
                    ]
                ]
            ]);
        }

        $user->update([
            'password' => $request->password,
            'reset_code' => null
        ]);

        return [
            'message' => 'Your password has been reset successfully.'
        ];
    }
}
