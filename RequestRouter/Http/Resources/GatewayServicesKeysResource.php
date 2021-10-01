<?php

namespace RequestRouter\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GatewayServicesKeysResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
           return $this->name;
    }
}
