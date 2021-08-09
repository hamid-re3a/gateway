<?php

namespace User\Http\Controllers\Front;


use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;
use User\Http\Requests\User\Profile\UpdateAvatarRequest;
use User\Http\Requests\User\Profile\UpdatePersonalDetails;
use User\Http\Requests\User\Profile\ChangePasswordRequest;
use User\Http\Requests\User\Profile\ChangeTransactionPasswordRequest;
use User\Jobs\EmailJob;
use User\Mail\User\PasswordChangedEmail;
use User\Mail\User\ProfileManagement\TransactionPasswordChangedEmail;
use User\Support\UserActivityHelper;

class UserController extends Controller
{

    /**
     * Change password
     * @group
     * Profile Management
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {

        try {
            DB::beginTransaction();
            $request->user()->update([
                'password' => $request->get('password') //bcrypt in User model (Mutator)
            ]);

            list($ip_db, $agent_db) = UserActivityHelper::getInfo($request);
            if(getSetting('IS_LOGIN_PASSWORD_CHANGE_EMAIL_ENABLE'))
                EmailJob::dispatch(new PasswordChangedEmail($request->user(), $ip_db, $agent_db), $request->user()->email);

            DB::commit();
            return api()->success(trans('user.responses.password-successfully-changed'));
        } catch (\Throwable $exception) {
            DB::rollBack();
            return api()->error(trans('user.responses.global-error'));
        }
    }

    /**
     * Change Transaction password
     * @group
     * Profile Management
     * @param ChangeTransactionPasswordRequest $request
     * @return JsonResponse
     */
    public function changeTransactionPassword(ChangeTransactionPasswordRequest $request)
    {
        try {
            DB::beginTransaction();
            $request->user()->update([
                'transaction_password' => $request->get('password') //bcrypt in User model (Mutator)
            ]);

            list($ip_db, $agent_db) = UserActivityHelper::getInfo($request);
            if(getSetting('IS_TRANSACTION_PASSWORD_CHANGE_EMAIL_ENABLE'))
                EmailJob::dispatch(new TransactionPasswordChangedEmail($request->user(), $ip_db, $agent_db), $request->user()->email);

            DB::commit();
            return api()->success(trans('user.responses.transaction-password-successfully-changed'));
        } catch (\Throwable $exception) {
            DB::rollBack();
            return api()->error(trans('user.responses.global-error'));
        }
    }


    /**
     * Change personal details
     * @group
     * Profile Management
     * @param UpdatePersonalDetails $request
     * @return JsonResponse
     */
    public function updatePersonalDetails(UpdatePersonalDetails $request)
    {
        try {
            DB::beginTransaction();
            $request->user()->update($request->validated());
            DB::commit();
        }  catch (\Throwable $exception) {
            DB::rollBack();
            return api()->error(trans('user.responses.global-error'),null,500,null);
        }

        return api()->success(trans('user.responses.profile-details-updated'));
    }

    /**
     * Update avatar
     * @group
     * Profile Management
     * @param UpdateAvatarRequest $request
     * @return JsonResponse
     */
    public function updateAvatar(UpdateAvatarRequest $request)
    {
        $fileName = auth()->user()->id . '-' . Uuid::uuid4() . time() . '.' . $request->file('avatar')->getClientOriginalExtension();
        $mimeType = $request->file('avatar')->getMimeType();
        $request->file('avatar')->storeAs('/avatars/', $fileName);
        auth()->user()->update([
            'avatar' => [
                'file_name' => $fileName,
                'mime' => $mimeType
            ]
        ]);

        return api()->success(trans('user.responses.avatar-updated'));
    }

    /**
     * Get avatar
     * @group
     * Profile Management
     * @return JsonResponse
     */
    public function getAvatar()
    {
        $avatar = auth()->user()->avatar;
        return Storage::disk('local')->response('/avatars/' . auth()->user()->avatar['file_name']);
    }
}
