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
            'country'=> ($this->ip->exists() AND !empty($this->ip->country)) ? $this->ip->country : 'Unknown',
            'state'=> ($this->ip->exists() AND !empty($this->ip->state)) ? $this->ip->state : 'Unknown',
            'ip' => $this->ip->ip,
            'device' => ($this->agent->exists() AND !empty($this->agent->device_type)) ? $this->agent->device_type : 'Unknown',
            'browser'=> ($this->agent->exists() AND !empty($this->agent->browser)) ? $this->agent->browser . ' ' . $this->agent->browser_version : 'Unknown',
            'action' => getDbTranslate($this->route, $this->route)
        ];
    }
}
