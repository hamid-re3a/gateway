<?php

namespace User\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileDetailsResource extends JsonResource
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
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'username' => $this->username,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'gender' => $this->gender,
            'birthday' => $this->birthday ? $this->birthday->format('Y/m/d') : null,
            'avatar' => route('get-avatar-image'),
        ];
    }
}
