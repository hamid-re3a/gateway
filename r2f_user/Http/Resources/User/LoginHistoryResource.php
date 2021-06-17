<?php

namespace R2FUser\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use R2FUser\Http\Resources\AgentResource;
use R2FUser\Http\Resources\Auth\ProfileResource;
use R2FUser\Http\Resources\IpResource;
use R2FUser\Models\Agent;
use R2FUser\Models\Ip;
use R2FUser\Models\User;

class LoginHistoryResource extends JsonResource
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
            'ip'=>(!is_null($this->ip_id))?IpResource::make(Ip::find($this->ip_id)):null,
            'agent'=>(!is_null($this->agent_id))?AgentResource::make(Agent::find($this->agent_id)):null,
            'login_status'=>$this->login_status_string,
            'is_from_new_device'=>$this->is_from_new_device,
            'created_at'=>$this->created_at,
        ];
    }
}
