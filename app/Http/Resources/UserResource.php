<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response =  parent::toArray($request);

        return array_merge($response, [
            'templates_ids' => $this->templates->pluck('id'),
            'avatar' => $this->when($this->avatar, $this->avatar)
        ]);
    }
}
