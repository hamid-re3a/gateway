<?php

namespace User\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserActivityResource extends JsonResource
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
            'user_id' => $this->user_id ,
            'user_full_name' => $this->user->full_name ,
            'when' => $this->created_at->diffForHumans(),
            'country'=> !empty($this->ip_id) ? $this->ip->country : 'Unknown',
            'state'=> !empty($this->ip_id) ? $this->ip->state : 'Unknown',
            'ip' => !empty($this->ip_id) ? $this->ip->ip : 'Unknown',
            'device' => !empty($this->agent_id) ? $this->agent->device_type : 'Unknown',
            'platform' => !empty($this->agent_id) ? $this->agent->platform . '(' . $this->agent->platform_version .')' : 'Unknown',
            'browser'=> !empty($this->agent_id) ? $this->agent->browser . ' ' . $this->agent->browser_version : 'Unknown',
            'action' => getDbTranslate($this->route, $this->route)
        ];
    }
}
