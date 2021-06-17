<?php

namespace R2FUser\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use R2FUser\Http\Resources\Auth\ProfileResource;
use R2FUser\Models\Agent;
use R2FUser\Models\Ip;
use R2FUser\Models\User;

class AgentResource extends JsonResource
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
            'language'=>$this->language,
            'device_type'=>$this->device_type,
            'platform'=>$this->platform,
            'browser'=>$this->browser,
            'is_desktop'=>$this->is_desktop,
            'is_phone'=>$this->is_phone,
            'robot'=>$this->robot,
            'is_robot'=>$this->is_robot,
            'platform_version'=>$this->platform_version,
            'browser_version'=>$this->browser_version,
            'hit'=>$this->hit,
            'created_at'=>$this->created_at,
        ];
    }
}
