<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreUserRequest;
use App\Http\Requests\API\UpdateUserRequest;
use App\Http\Resources\API\UserResource;
use App\Http\Resources\API\UserCollection;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('channels')->paginate();

        return (new UserCollection($users))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password)
        ];

        $user = User::create($data);

        return (new UserResource($user))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response([
                'message' => 'Resource could not be found.'
            ])->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return (new UserResource($user->load('channels')))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();

        return (new UserResource($user))->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response([
            'message' => 'User successfully deleted.'
        ])->setStatusCode(Response::HTTP_OK);
    }
}
