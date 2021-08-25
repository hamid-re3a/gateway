<?php

namespace User\Http\Controllers\Front;


use Illuminate\Routing\Controller;
use User\Http\Resources\User\ActivityResource;

class ActivityController extends Controller
{

    /**
     * Get user activities list
     * @group Public User > Activities
     */
    public function index()
    {
        return api()->success(null,ActivityResource::collection(
            auth()->user()->activities()->with([
                'agent',
                'ip'
            ])->simplePaginate()
        )->response()->getData());
    }

}
