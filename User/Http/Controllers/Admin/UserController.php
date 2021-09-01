<?php

namespace User\Http\Controllers\Admin;


use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use User\Http\Requests\Admin\ActivateOrDeactivateUserAccount;
use User\Http\Requests\Admin\BlockOrUnblockUser;
use User\Http\Requests\Admin\CreateAdminRequest;
use User\Http\Requests\Admin\FreezeOrUnfreezeUserAccountRequest;
use User\Http\Requests\Admin\HistoryRequest;
use User\Http\Requests\Admin\VerifyUserEmailRequest;
use User\Http\Resources\OtpResource;
use User\Http\Resources\User\LoginHistoryResource;
use User\Http\Resources\User\PasswordHistoryResource;
use User\Http\Resources\User\ProfileDetailsResource;
use User\Http\Resources\User\UserBlockHistoryResource;
use User\Jobs\UrgentEmailJob;
use User\Mail\User\UserAccountHasBeenActivatedEmail;
use User\Mail\User\UserAccountHasBeenDeactivatedEmail;
use User\Mail\User\SuccessfulEmailVerificationEmail;
use User\Mail\User\UserAccountHasBeenFrozenEmail;
use User\Mail\User\UserAccountHasBeenUnfrozenEmail;
use User\Models\User;
use User\Services\UserAdminService;
use User\Support\UserActivityHelper;


class UserController extends Controller
{
    private $user_admin_service;

    public function __construct(UserAdminService $user_admin_service){
        $this->user_admin_service = $user_admin_service;
    }

    /**
     * Get user's list
     * @group
     * Admin > User
     */
    public function index()
    {
        $users = User::query()->simplePaginate();
        return api()->success(null,ProfileDetailsResource::collection($users)->response()->getData());
    }

    /**
     * Block Or Unblock User Account
     * @group
     * Admin > User
     * @param BlockOrUnblockUser $request
     * @return JsonResponse
     */
    public function blockOrUnblockUser(BlockOrUnblockUser $request)
    {

        $user = User::whereEmail($request->get('email'))->first();
        if($user->id == auth()->user()->id)
            return api()->error(trans('user.responses.you-cant-block-unblock-your-account'));
        if ($request->get('deactivate')) {
            $user->block_type = USER_BLOCK_TYPE_BY_ADMIN;
            $user->block_reason = $request->has('block_reason') ? $request->get('block_reason') : trans('user.responses.user-account-deactivated-by-admin');
        } else {
            $user->block_type = null;
            $user->block_reason = trans('user.responses.user-account-activated-by-admin');

        }
        $user->save();
        $user->signOut();

        return api()->success(trans('user.responses.ok'));
    }

    /**
     * Activate or Deactivate user account
     * @group
     * Admin > User
     * @param ActivateOrDeactivateUserAccount $request
     * @return JsonResponse
     */
    public function activateOrDeactivateUserAccount(ActivateOrDeactivateUserAccount $request)
    {
        $user = User::find($request->get('user_id'));
        if($user->id == auth()->user()->id)
            return api()->error(trans('user.responses.you-cant-deactivate-active-your-account'));
        if($request->get('status') == 'activate') {
            $user->update([
                'is_deactivate' => false
            ]);
            UrgentEmailJob::dispatch(new UserAccountHasBeenDeactivatedEmail($user), $user->email);
            return api()->success(trans('user.responses.user-account-activate-successfully'));
        } else if($request->get('status') == 'deactivate') {

            $user->update([
                'is_deactivate' => true
            ]);

            $user->signOut();
            UrgentEmailJob::dispatch(new UserAccountHasBeenActivatedEmail($user), $user->email);
            return api()->success(trans('user.responses.user-account-deativate-successfully'));
        }

        return api()->error(trans('user.responses.global-error'),null,400);
    }

    /**
     * Freeze or Unfreeze user account
     * @group
     * Admin > User
     * @param FreezeOrUnfreezeUserAccountRequest $request
     * @return JsonResponse
     */
    public function freezeOrUnfreezeUserAccount(FreezeOrUnfreezeUserAccountRequest $request)
    {
        $user = User::find($request->get('user_id'));
        if($user->id == auth()->user()->id)
            return api()->error(trans('user.responses.you-cant-freeze-unfreeze-your-account'));
        if($request->get('status') == 'freeze'){
            $user->update([
                'is_freeze' => true
            ]);
            UrgentEmailJob::dispatch(new UserAccountHasBeenFrozenEmail($user), $user->email);
            return api()->success(trans('user.responses.user-account-frozen-successfully'));
        }
        if($request->get('status') == 'unfreeze') {
            $user->update([
                'is_freeze' => false,
            ]);
            UrgentEmailJob::dispatch(new UserAccountHasBeenUnfrozenEmail($user), $user->email);
            return api()->success(trans('user.responses.user-account-unfreeze-successfully'));
        }

        return api()->error(trans('user.responses.global-error'),null,400);
    }

    /**
     * Verify Email User Account
     * @group
     * Admin > User
     * @param VerifyUserEmailRequest $request
     * @return JsonResponse
     */
    public function verifyUserEmailAccount(VerifyUserEmailRequest $request)
    {

        $user = User::whereEmail($request->get('email'))->first();
        if (!$user->isEmailVerified()) {
            $user->email_verified_at = now();
            $user->save();

            list($ip_db, $agent_db) = UserActivityHelper::getInfo($request);
            UrgentEmailJob::dispatch(new SuccessfulEmailVerificationEmail($user, $ip_db, $agent_db), $user->email);
        }
        return api()->success(trans('user.responses.ok'));
    }



    /**
     * User Password History
     * @group
     * Admin > User History
     */
    public function passwordHistory(HistoryRequest $request)
    {
        return api()->success(trans('user.responses.ok'), PasswordHistoryResource::collection(User::find($request->get('user_id'))->userHistories('password')->get()));
    }

    /**
     * User Block History
     * @group
     * Admin > User History
     */
    public function blockHistory(HistoryRequest $request)
    {
        return api()->success(trans('user.responses.ok'), UserBlockHistoryResource::collection(User::find($request->get('user_id'))->userHistories('block_type')->get()));
    }
    /**
     * User Login History
     * @group
     * Admin > User History
     */
    public function loginHistory(HistoryRequest $request)
    {
        return api()->success(trans('user.responses.ok'), LoginHistoryResource::collection(User::find($request->get('user_id'))->loginAttempts));
    }

    /**
     * User Email Verification History
     * @group
     * Admin > User History
     */
    public function emailVerificationHistory(HistoryRequest $request)
    {
        return api()->success(trans('user.responses.ok'), OtpResource::collection(User::find($request->get('user_id'))->otps()->where('type',OTP_TYPE_EMAIL_VERIFICATION)->get()));
    }

    /**
     * create user admin by super admin
     * @group
     * Admin > User
     * @param CreateAdminRequest $request
     * @return JsonResponse
     */
    public function createUserByAdmin(CreateAdminRequest $request)
    {
        $this->user_admin_service->createAdmin($request);
        return api()->success(trans('user.responses.ok'),null);

    }
}
