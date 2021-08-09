<?php

namespace User\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
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
            'crypto' => $this->cryptoCurrency->name,
            'address' => $this->address,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];
    }
}
