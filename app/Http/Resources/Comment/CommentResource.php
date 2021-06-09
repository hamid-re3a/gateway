<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\Auth\ProfileResource;
use App\Http\Resources\Image\ImageResource;
use App\Http\Resources\Product\ProductCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  [
            'id' => $this->id,
            'comment' => $this->comment,
            'is_admin' => $this->user->hasRole('admin'),
            'user' => ProfileResource::make($this->user)->hide(array('referral_unit_id', 'wallet')),
            'created_at' => $this->created_at,
        ];
    }
}
