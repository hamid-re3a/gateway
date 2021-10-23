<?php

namespace User\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            'when' => $this->created_at->diffForHumans(),
            'country'=> !empty($this->ip_id) ? $this->ip->country : 'Unknown',
            'state'=> !empty($this->ip_id) ? $this->ip->state : 'Unknown',
            'ip' => !empty($this->ip_id) ? $this->ip->ip : 'Unknown',
            'device' => !empty($this->agent_id) ? $this->agent->device_type : 'Unknown',
            'browser'=> !empty($this->agent_id) ? $this->agent->browser . ' ' . $this->agent->browser_version : 'Unknown',
            'action' => getDbTranslate($this->route, $this->route)
        ];
    }
}
