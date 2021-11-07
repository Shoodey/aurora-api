<?php

namespace App\Http\Resources\API;

use App\Http\Resources\ChannelResource\API;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
    * The "data" wrapper that should be applied.
    *
    * @var string
    */
    public static $wrap = 'user';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'email'            => $this->email,
            'channels'          => ChannelResource::collection($this->whenLoaded('channels')),
            'email_verified_at' => $this->email_verified_at,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }
}
