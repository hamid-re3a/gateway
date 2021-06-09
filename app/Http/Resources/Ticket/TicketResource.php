<?php

namespace App\Http\Resources\Ticket;

use App\Http\Resources\Auth\ProfileResource;
use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Helpers\ResponseData;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => ProfileResource::make($this->user),
            'title' => $this->title,
            'priority' => $this->priority,
            'status' => $this->status,
            'read_status' => $this->read_status,
            'created_at' => $this->created_at,
            'category' => $this->category,
            'comments' => CommentResource::collection($this->comments),
        ];
    }

    public function with($request)
    {
        return ResponseData::status();
    }
}
