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
use User\Http\Requests\User\Profile\VerifyTransactionPasswordOtp;
use User\Jobs\TrivialEmailJob;
use User\Jobs\UrgentEmailJob;
use User\Mail\User\PasswordChangedEmail;
use User\Mail\User\ProfileManagement\FreezeAccountEmail;
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
                UrgentEmailJob::dispatch(new PasswordChangedEmail($request->user(), $ip_db, $agent_db), $request->user()->email);

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
                UrgentEmailJob::dispatch(new TransactionPasswordChangedEmail($request->user(), $ip_db, $agent_db), $request->user()->email);

            DB::commit();
            return api()->success(trans('user.responses.transaction-password-successfully-changed'));
        } catch (\Throwable $exception) {
            DB::rollBack();
            return api()->error(trans('user.responses.global-error'));
        }
    }

    /**
     * Ask Email transaction password OTP
     * @group
     * Profile Management
     */
    public function askTransactionPasswordOtp()
    {
        list($data, $err) = UserActivityHelper::makeEmailTransactionPasswordOtp(auth()->user(), request(), false);
        if ($err) {
            return api()->error(trans('user.responses.wait-limit'), $data, 429);
        }
        return api()->success(trans('user.responses.otp-successfully-sent'));
    }

    /**
     * Verify Transaction password OTP
     * @group
     * Profile Management
     * @param VerifyTransactionPasswordOtp $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function verifyTransactionPasswordOtp(VerifyTransactionPasswordOtp $request)
    {

        $duration = getSetting('USER_EMAIL_VERIFICATION_OTP_DURATION');
        $otp_db = auth()->user()->otps()
            ->where('type', OTP_TYPE_CHANGE_TRANSACTION_PASSWORD)
            ->whereBetween('created_at', [now()->subSeconds($duration)->format('Y-m-d H:i:s'), now()->format('Y-m-d H:i:s')])
            ->get()
            ->last();
        if (is_null($otp_db)) {
            $errors = [
                'otp' => trans('user.responses.transaction-password-otp-code-is-expired')
            ];
            return api()->error('user.responses.transaction-password-otp-code-is-expired', '', 422, $errors);
        }

        if ($otp_db->is_used) {
            $errors = [
                'otp' => trans('user.responses.transaction-password-code-code-is-used')
            ];
            return api()->error('user.responses.transaction-password-code-code-is-used', '', 422, $errors);
        }


        if ($otp_db->otp == $request->otp) {
            $otp_db->is_used = true;
            $otp_db->save();


            list($ip_db, $agent_db) = UserActivityHelper::getInfo($request);
            $request->user()->update([
                'password' => $request->get('password') //bcrypt in User model (Mutator)
            ]);
            TrivialEmailJob::dispatch(new TransactionPasswordChangedEmail(auth()->user(), $ip_db, $agent_db), auth()->user()->email);

            return api()->success(trans('user.responses.transaction-password-successfully-changed'));
        }
        return api()->error('user.responses.transaction-password-otp-code-is-incorrect');
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

        return api()->success(trans('user.responses.avatar-updated'),[
            'avatar' => route('get-avatar')
        ]);
    }

    /**
     * Get avatar
     * @group
     * Profile Management
     * @return JsonResponse
     */
    public function getAvatar()
    {
        $avatar = json_decode(auth()->user()->avatar,true);
        return Storage::disk('local')->response('/avatars/' . $avatar['file_name']);
    }

    /**
     * Freeze account
     * @group
     * Profile Management
     */
    public function freeze()
    {
        if(auth()->user()->is_freeze)
            return api()->error(trans('user.responses.your-account-already-frozen'));

        auth()->user()->update([
            'is_freeze' => true
        ]);

        list($ip_db, $agent_db) = UserActivityHelper::getInfo(request());
        TrivialEmailJob::dispatch(new FreezeAccountEmail(auth()->user(), $ip_db, $agent_db), auth()->user()->email);

        return api()->success(trans('user.responses.your-account-frozen-successfully'));
    }

    /**
     * UnFreeze account
     * @group
     * Profile Management
     */
    public function unfreeze()
    {
        if(!auth()->user()->is_freeze)
            return api()->error(trans('user.responses.your-account-already-unfreeze'));

        auth()->user()->update([
            'is_freeze' => false
        ]);

        list($ip_db, $agent_db) = UserActivityHelper::getInfo(request());
        TrivialEmailJob::dispatch(new FreezeAccountEmail(auth()->user(), $ip_db, $agent_db), auth()->user()->email);

        return api()->success(trans('user.responses.your-account-unfrozen-successfully'));
    }

    /**
     * Deactivate account
     * @group
     * Profile Management
     */
    public function deactivate()
    {
        auth()->user()->update([
            'is_deactivate' => TRUE
        ]);

        list($ip_db, $agent_db) = UserActivityHelper::getInfo(request());
        TrivialEmailJob::dispatch(new FreezeAccountEmail(auth()->user(), $ip_db, $agent_db), auth()->user()->email);

        auth()->user()->signOut();
        return api()->success(trans('user.responses.your-account-deactivate-successfully'));


    }
}
