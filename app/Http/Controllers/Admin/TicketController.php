<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseData;
use App\Http\Requests\Ticket\AdminIndexTicketRequest;
use App\Http\Requests\Ticket\AdminReplyTicketRequest;
use App\Http\Requests\Ticket\ChangeTicketStatusRequest;
use App\Http\Resources\Ticket\TicketResource;
use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{

    /**
     * All Tickets
     * @group
     * Admin > Tickets
     */
    public function index(AdminIndexTicketRequest $request)
    {
        $tickets = Ticket::query();
        if (!is_null($request->name))
            $tickets = $tickets->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->name}%");
            });
        if (!is_null($request->status)) {
            $tickets = $tickets->where('status', $request->status);
        }

        $tickets_result = $tickets->orderByDesc('id')->paginate(20);
        return TicketResource::collection($tickets_result);
    }

    /**
     * Reply Tickets
     * @group
     * Admin > Tickets
     */
    public function replyComment(AdminReplyTicketRequest $request)
    {
        $comment = Comment::create(array_merge($request->all(), array('user_id' => auth()->id())));
        try {
            $comment->ticket->user->sendCustomerAnsweredNotification($comment->ticket_id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        return ResponseData::success(trans('responses.comment-created'), $comment);
    }

    /**
     * Show Ticket
     * @group
     * Admin > Tickets
     */
    public function show($id)
    {
        $ticket = Ticket::with(['comments'])->where('id', $id)->first();
        return TicketResource::make($ticket);
    }


    /**
     * Change Ticket Status
     * @group
     * Admin > Tickets
     */
    public function changeTicketStatus(ChangeTicketStatusRequest $request)
    {
        $comment = Ticket::findOrFail($request->ticket_id);
        $comment->status = $request->status;
        $comment->update();

        return ResponseData::success(trans('responses.ticket-status-changed'), $comment);
    }
}
