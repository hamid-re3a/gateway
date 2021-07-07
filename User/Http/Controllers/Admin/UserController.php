<?php

namespace User\Http\Controllers\Admin;


use Illuminate\Routing\Controller;
use User\Http\Requests\Admin\ActivateOrDeactivateUserAccountRequest;
use User\Http\Requests\Admin\HistoryRequest;
use User\Http\Requests\Admin\VerifyUserEmailRequest;
use User\Http\Resources\OtpResource;
use User\Http\Resources\User\LoginHistoryResource;
use User\Http\Resources\User\PasswordHistoryResource;
use User\Http\Resources\User\UserBlockHistoryResource;
use User\Jobs\EmailJob;
use User\Mail\User\SuccessfulEmailVerificationEmail;
use User\Models\User;
use User\Support\UserActivityHelper;

;

class UserController extends Controller
{
    /**
     * Activate Or Deactivate User Account
     * @group
     * Admin > User
     */
    public function activateOrDeactivateUserAccount(ActivateOrDeactivateUserAccountRequest $request)
    {

        $user = User::whereEmail($request->email)->first();
        if ($request->deactivate) {
            $user->block_type = USER_BLOCK_TYPE_BY_ADMIN;
            $user->block_reason = 'responses.user-account-deactivated-by-admin';
        } else {
            $user->block_type = null;
            $user->block_reason = 'responses.user-account-activated-by-admin';

        }
        $user->save();

        return api()->success(trans('responses.ok'));
    }

    /**
     * Verify Email User Account
     * @group
     * Admin > User
     */
    public function verifyUserEmailAccount(VerifyUserEmailRequest $request)
    {

        $user = User::whereEmail($request->email)->first();
        if (!$user->isEmailVerified()) {
            $user->email_verified_at = now();
            $user->save();

            list($ip_db, $agent_db) = UserActivityHelper::getInfo($request);
            EmailJob::dispatch(new SuccessfulEmailVerificationEmail($user, $ip_db, $agent_db), $user->email);
        }
        return api()->success(trans('responses.ok'));
    }



    /**
     * User Password History
     * @group
     * Admin > User History
     */
    public function passwordHistory(HistoryRequest $request)
    {
        return api()->success(trans('responses.ok'), PasswordHistoryResource::collection(User::find($request->user_id)->passwordHistories));
    }

    /**
     * User Block History
     * @group
     * Admin > User History
     */
    public function blockHistory(HistoryRequest $request)
    {
        return api()->success(trans('responses.ok'), UserBlockHistoryResource::collection(User::find($request->user_id)->blockHistories));
    }
    /**
     * User Login History
     * @group
     * Admin > User History
     */
    public function loginHistory(HistoryRequest $request)
    {
        return api()->success(trans('responses.ok'), LoginHistoryResource::collection(User::find($request->user_id)->loginAttempts));
    }

    /**
     * User Email Verification History
     * @group
     * Admin > User History
     */
    public function emailVerificationHistory(HistoryRequest $request)
    {
        return api()->success(trans('responses.ok'), OtpResource::collection(User::find($request->user_id)->otps()->where('type',OTP_TYPE_EMAIL_VERIFICATION)->get()));
    }
}
