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
        $request->user()->update($request->validated());

        return [
            'message' => 'Your profile has been updated successfully.',
            'user' => $request->user()
        ];
    }
}
