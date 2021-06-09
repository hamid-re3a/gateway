<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseData;
use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Resources\Ticket\TicketResource;
use App\Models\Ticket;

class TicketController extends Controller
{
    /**
     * Get All Tickets
     * @group
     * Public User > Tickets
     */
    public function index()
    {
        return TicketResource::collection(auth()->user()->tickets()->notSpam()->orderByDesc('updated_at')->paginate(5));
    }
    /**
     * Store a New Ticket
     * @group
     * Public User > Tickets
     */

    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create(array_merge($request->validated(), ['user_id' => auth()->id()]));
        return ResponseData::success(trans('responses.ticket-created'), TicketResource::make($ticket));
    }

    /**
     * Show One Ticket
     * @group
     * Public User > Tickets
     */
    public function show($id)
    {
        $ticket = Ticket::with(['comments'])->whereId($id)->whereUserId(auth()->id())->first();
        return TicketResource::make($ticket);
    }
}
