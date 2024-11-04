<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateInformationRequest;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return $request->user();
    }

    public function update(UpdateInformationRequest $request)
    {
        $user = $request->user();
        $user->update($request->only('name', 'email'));

        $user->information->update(
            $request->only('health_conditions', 'dietary_preferences')
        );

        return [
            'message' => 'Your profile has been updated successfully.',
            'user' => $user
        ];
    }
}
