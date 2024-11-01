<?php

namespace App\Http\Controllers\User;

use BaconQrCode\Writer;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use App\Http\Controllers\Controller;
use BaconQrCode\Renderer\GDLibRenderer;
use App\Http\Requests\User\TwoFA\TwoFAEnableRequest;
use App\Http\Requests\User\TwoFA\TwoFAConfirmRequest;

class TwoFAController extends Controller
{
    public function request(Request $request)
    {
        $user = $request->user();

        $TwoFA = new Google2FA;
        $key = $TwoFA->generateSecretKey(32);
        $writer = new Writer(new GDLibRenderer(300));

        return [
            'key' => $key,
            'image' => 'data:image/png;base64,' . base64_encode(
                $writer->writeString(
                    $TwoFA->getQRCodeUrl(
                        env('APP_NAME'),
                        $user->email,
                        $key
                    )
                )
            )
        ];
    }

    public function enable(TwoFAEnableRequest $request)
    {
        $TwoFA = new Google2FA;

        if (!$TwoFA->verifyKey($request->key, $request->code, 8)) {
            return response()->json([
                'message' => 'Invalid Code',
                'errors' => [
                    'code' => ['Invalid Code']
                ]
            ], 422);
        }

        $request->user()->update([
            '2FA' => $request->key
        ]);

        return [
            'message' => '2FA has been enabled successfully.'
        ];
    }

    public function disable(Request $request)
    {
        $user = $request->user();

        if (!$user->{'2FA'}) {
            return response()->json([
                'message' => 'User does not have 2FA.',
                'errors' => []
            ], 422);
        }

        $user->update(['2FA' => null]);

        return [
            'message' => '2FA has been disabled successfully.'
        ];
    }

    public function confirm(TwoFAConfirmRequest $request)
    {
        $user = $request->user();
        $TwoFA = new Google2FA;

        if (!$TwoFA->verifyKey($user->{'2FA'}, $request->code, 8)) {
            return response()->json([
                'message' => 'Invalid Code',
                'errors' => [
                    'code' => ['Invalid Code']
                ]
            ], 422);
        }

        return [
            'message' => 'Confirmed!'
        ];
    }
}
