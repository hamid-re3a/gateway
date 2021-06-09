<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseData;
use App\Http\Requests\Ticket\SendCommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Send Comment
     * @group
     * Public User > Comments
     */
    public function sendCommentTicket(SendCommentRequest $request)
    {
        $ticket = Ticket::where('id',$request->ticket_id)->first();
        $ticket->status = TICKET_IN_PROGRESS;
        if (!auth()->user()->hasRole(array('admin')))
            $ticket->read_status = 'read';
        $ticket->save();

        $comment = Comment::create(array_merge($request->validated(), array('user_id' => auth()->id())));
        return ResponseData::success(trans('responses.comment-created'), CommentResource::make($comment));
    }

}
