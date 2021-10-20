<?php

namespace User\Http\Controllers\Front;


use Illuminate\Routing\Controller;
use User\Http\Resources\User\ActivityResource;
use User\Models\User;

class ActivityController extends Controller
{

    /**
     * Get user activities list
     * @group Public User > Activities
     */
    public function index()
    {
        /**@var $user User*/
        $user = auth()->user();
        $list = $user->activities()->orderByDesc('id')->with([
            'ip',
            'agent'
        ])->paginate();

        return api()->success(null,[
            'list' => ActivityResource::collection($list),
            'pagination' => [
                'total' => $list->total(),
                'per_page' => $list->per_page()
            ]
        ]);
    }

}
