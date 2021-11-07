<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\RegisterRequest;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password)
        ];

        $user = User::create($data);

        $token = $user->createToken('token')->accessToken;

        return response()->json([
            'message' => 'You are successfully signed in.',
            'user'    => $user,
            'token'   => $token
        ], Response::HTTP_OK);
    }
}
