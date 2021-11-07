<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = [
            'email'    => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('token')->accessToken;

            return response()->json([
                'message' => 'You have successfully logged in.',
                'token'   => $token
            ], 200);
        } else {
            return response()->json(['error' => 'These credentials do not match any records.'], 401);
        }
    }

    public function logout(Request $request)
    {
        $user  = $request->user();
        $token = $user->token();

        $token->revoke();

        return response()->json([
            'message' => 'Successfully logged out from this device.'
        ], 200);
    }

    public function logoutFromAllDevices(Request $request)
    {
        $user = $request->user();

        DB::table('oauth_access_tokens')
            ->where('user_id', $user->id)
            ->update([
                'revoked' => true
            ]);

        return response()->json([
            'message' => 'Successfully logged out from all devices.'
        ], 200);
    }
}
