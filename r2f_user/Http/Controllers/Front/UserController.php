<?php

namespace R2FUser\Http\Controllers\Front;

use App\Http\Helpers\ResponseData;
use Illuminate\Routing\Controller;
use R2FUser\Http\Resources\OtpResource;
use R2FUser\Http\Resources\User\LoginHistoryResource;
use R2FUser\Http\Resources\User\PasswordHistoryResource;
use R2FUser\Http\Resources\User\UserBlockHistoryResource;
use R2FUser\Models\User;

;

class UserController extends Controller
{
    /**
     * Passsword History
     * @group
     * Public User > History
     */
    public function passwordHistory()
    {
        return ResponseData::success(trans('responses.ok'), PasswordHistoryResource::collection(auth()->user()->passwordHistories));
    }

    /**
     * Block History
     * @group
     * Public User > History
     */
    public function blockHistory()
    {
        return ResponseData::success(trans('responses.ok'), UserBlockHistoryResource::collection(auth()->user()->blockHistories));
    }
    /**
     * Login History
     * @group
     * Public User > History
     */
    public function loginHistory()
    {
        return ResponseData::success(trans('responses.ok'), LoginHistoryResource::collection(auth()->user()->loginAttempts));
    }

    /**
     * Email Verification History
     * @group
     * Public User > History
     */
    public function emailVerificationHistory()
    {
        return ResponseData::success(trans('responses.ok'), OtpResource::collection(auth()->user()->otps()->where('type',OTP_TYPE_EMAIL_VERIFICATION)->get()));
    }
}
