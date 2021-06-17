<?php

namespace R2FUser\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use R2FUser\Http\Resources\Auth\ProfileResource;
use R2FUser\Models\Agent;
use R2FUser\Models\Ip;
use R2FUser\Models\User;

class IpResource extends JsonResource
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
            'login_status'=>$this->login_status_string,
            'ip'=>$this->ip,
            'iso_code'=>$this->iso_code,
            'country'=>$this->country,
            'city'=>$this->city,
            'state'=>$this->state,
            'state_name'=>$this->state_name,
            'postal_code'=>$this->postal_code,
            'lat'=>$this->lat,
            'lon'=>$this->lon,
            'timezone'=>$this->timezone,
            'continent'=>$this->continent,
            'hit'=>$this->hit,
            'created_at'=>$this->created_at,
        ];
    }
}
