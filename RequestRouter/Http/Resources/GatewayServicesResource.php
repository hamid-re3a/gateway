<?php

namespace RequestRouter\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class GatewayServicesResource extends JsonResource
{
    public static $wrap = null;


    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
            $arra[$this->name] = [
                'doc_point' => $this->doc_point,
                'just_current_routes' => $this->just_current_routes,
                'domain' => $this->domain
            ];
        Arr::flatten($arra);

        return $arra;
    }
}
