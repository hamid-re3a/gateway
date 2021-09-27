<?php

namespace User\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use User\Models\City;
use User\Models\Country;

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
        $countries = new Country();
        $cities = new City();

        return [
            'id' => $this->id,
            'member_id' => $this->member_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'username' => $this->username,
            'mobile_number' => $this->mobile_number,
            'landline_number' => $this->landline_number,
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'sponsor' => $this->sponsor()->exists() ? $this->sponsor->full_name : null,
            'placement' => null,
            'rank' => null,
            'status' => null,
            'genealogy' => null,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'gender' => $this->gender,
            'birthday' => $this->birthday ? $this->birthday->format('Y/m/d') : null,
            'avatar' => route('customer.general.avatar-image', [
                'member_id' => $this->member_id
            ]),
            'state' => $this->state_id ? $cities->where(['id'=> $this->state_id,'parent_id' => null] )->first()->name : null,
            'city' => $this->city_id ? $cities->where(['id' => $this->city_id])->first()->name  : null,
            'country' => $this->country_id ? $countries->where('id',$this->country_id)->first()->name  : null,
            'zip_code' => $this->zip_code ? $this->zip_code  : null,
            'roles' => $role_name = implode(",",auth()->user()->getRoleNames()->toArray())
        ];
    }
}
