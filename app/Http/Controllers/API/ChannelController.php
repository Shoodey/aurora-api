<?php

namespace App\Http\Controllers\API;

use App\Models\Channel;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\ChannelResource;
use App\Http\Resources\API\ChannelCollection;
use App\Http\Requests\API\StoreChannelRequest;
use App\Http\Requests\API\UpdateChannelRequest;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $channels = Channel::with('user')->paginate();

        return (new ChannelCollection($channels))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChannelRequest $request)
    {
        $data = [
            'name'        => $request->name,
            'description' => $request->description,
            'user_id'     => $request->user_id,
            'password'    => bcrypt($request->password)
        ];

        $channel = Channel::create($data);

        return (new ChannelResource($channel))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel)
    {
        return (new ChannelResource($channel->load('user')))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChannelRequest $request, Channel $channel)
    {
        $channel->name        = $request->name;
        $channel->description = $request->description;
        $channel->user_id     = $request->user_id;

        if ($request->has('password') && $request->password) {
            $channel->password = bcrypt($request->password);
        }

        $channel->save();

        return (new ChannelResource($channel))->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Channel $channel)
    {
        $channel->delete();

        return response([
            'message' => 'Channel successfully deleted.'
        ])->setStatusCode(Response::HTTP_OK);
    }
}
