<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use Illuminate\Http\Response;

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
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'error' => 'These credentials do not match any records.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function whoAmI(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'user' => $user
        ], Response::HTTP_OK);
    }

    public function logout(Request $request)
    {
        $user  = $request->user();
        $token = $user->token();

        $token->revoke();

        return response()->json([
            'message' => 'Successfully logged out from this device.'
        ], Response::HTTP_OK);
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
        ], Response::HTTP_OK);
    }
}
