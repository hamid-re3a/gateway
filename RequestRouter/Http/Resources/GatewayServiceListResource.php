<?php

namespace RequestRouter\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use User\Http\Resources\Auth\ProfileResource;
use User\Models\Agent;
use User\Models\Ip;
use User\Models\User;

class GatewayServiceListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'service_id' => $this->id,
            'name' => $this->name,
            'doc_point'  => $this->doc_point ,
            'just_current_routes'  => $this->just_current_routes,
            'domain'  => $this->domain
        ];
    }
}
