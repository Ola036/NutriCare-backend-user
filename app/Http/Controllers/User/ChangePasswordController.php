<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function __invoke(ChangePasswordRequest $request)
    {
        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return [
                "message" => "Invaild password",
                "errors" => [
                    "current_password" => [
                        "Invalid password"
                    ]
                ]
            ];
        }

        $user->update(['password' => $request->new_password]);

        return [
            'message' => 'Your password has been updated successfully.'
        ];
    }
}
