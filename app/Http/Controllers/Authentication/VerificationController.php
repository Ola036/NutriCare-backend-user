<?php

namespace App\Http\Controllers\Authentication;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\VerifyRequest;

class VerificationController extends Controller
{
    public function __invoke(VerifyRequest $request)
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
            'reset_code' => null,
            'email_verified_at' => now()
        ]);

        return [
            'message' => 'Your account has been verified successfully.'
        ];
    }
}
