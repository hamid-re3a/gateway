<?php

namespace R2FUser\Http\Controllers\Front;

use App\Http\Helpers\ResponseData;
use Illuminate\Routing\Controller;
use R2FUser\Http\Resources\User\PasswordHistoryResource;
use R2FUser\Http\Resources\User\UserBlockHistoryResource;
use R2FUser\Models\User;

;

class UserController extends Controller
{
    /**
     * Passsword History
     * @group
     * User
     */
    public function passwordHistory()
    {
        return ResponseData::success(trans('responses.ok'), PasswordHistoryResource::collection(auth()->user()->passwordHistories));
    }

    /**
     * Block History
     * @group
     * User
     */
    public function blockHistory()
    {
        return ResponseData::success(trans('responses.ok'), UserBlockHistoryResource::collection(auth()->user()->blockHistories));
    }

}
