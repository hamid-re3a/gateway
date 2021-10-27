<?php

namespace User\Http\Controllers\Front;


use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Orders\Services\Grpc\Order;
use User\Http\Requests\User\profile\ChangePasswordRequest;
use User\Http\Requests\User\profile\ChangeTransactionPasswordRequest;
use User\Http\Requests\User\profile\UpdateAvatarRequest;
use User\Http\Requests\User\profile\UpdateContactDetails;
use User\Http\Requests\User\profile\UpdatePersonalDetails;
use User\Http\Requests\User\profile\VerifyTransactionPasswordOtp;
use User\Http\Requests\User\SponsorUserRequest;
use User\Http\Resources\Auth\ProfileResource;
use User\Http\Resources\User\ProfileDetailsResource;
use User\Jobs\UrgentEmailJob;
use User\Mail\User\PasswordChangedEmail;
use User\Mail\User\ProfileManagement\TransactionPasswordChangedEmail;
use User\Mail\User\WelcomeWithPasswordEmail;
use User\Services\OrderClientFacade;
use User\Services\UserService;
use User\Support\UserActivityHelper;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $user_service;

    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    /**
     * Get user profile details
     * @group Public User > Profile Management
     */
    public function getDetails()
    {
        return api()->success(null, ProfileDetailsResource::make(auth()->user()));
    }

    /**
     * Change password
     * @group Public User > Profile Management
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
            if (getSetting('IS_LOGIN_PASSWORD_CHANGE_EMAIL_ENABLE'))
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
     * @group Public User > Profile Management
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
            if (getSetting('IS_TRANSACTION_PASSWORD_CHANGE_EMAIL_ENABLE'))
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
     * @group Public User > Profile Management
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
     * @group Public User > Profile Management
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


        if ($otp_db->otp == $request->get('otp')) {
            $otp_db->is_used = true;
            $otp_db->save();


            list($ip_db, $agent_db) = UserActivityHelper::getInfo($request);
            $request->user()->update([
                'transaction_password' => $request->get('password') //bcrypt in User model (Mutator)
            ]);
            UrgentEmailJob::dispatch(new TransactionPasswordChangedEmail(auth()->user(), $ip_db, $agent_db), auth()->user()->email);

            return api()->success(trans('user.responses.transaction-password-successfully-changed'));
        }
        return api()->error('user.responses.transaction-password-otp-code-is-incorrect');
    }

    /**
     * Change personal details
     * @group Public User > Profile Management
     * @param UpdatePersonalDetails $request
     * @return JsonResponse
     */
    public function updatePersonalDetails(UpdatePersonalDetails $request)
    {
        try {
            DB::beginTransaction();
            $request->user()->update($request->validated());
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            return api()->error(trans('user.responses.global-error'), null, 500, null);
        }

        return api()->success(trans('user.responses.profile-details-updated'), ProfileDetailsResource::make(auth()->user()));
    }

    /**
     * Update contact details
     * @group Public User > Profile Management
     * @param UpdateContactDetails $request
     * @return JsonResponse
     */
    public function updateContactDetails(UpdateContactDetails $request)
    {
        try {
            DB::beginTransaction();
            $request->user()->update($request->validated());
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            return api()->error(trans('user.responses.global-error'), null, 500, null);
        }

        return api()->success(trans('user.responses.profile-details-updated'), ProfileDetailsResource::make(auth()->user()));
    }

    /**
     * Update avatar
     * @group Public User > Profile Management
     * @param UpdateAvatarRequest $request
     * @return JsonResponse
     */
    public function updateAvatar(UpdateAvatarRequest $request)
    {
        $fileName = auth()->user()->id . '-' . auth()->user()->member_id . '-' . time() . '.' . $request->file('avatar')->getClientOriginalExtension();
        $mimeType = $request->file('avatar')->getMimeType();
        $request->file('avatar')->storeAs('/avatars/', $fileName);
        auth()->user()->update([
            'avatar' => [
                'file_name' => $fileName,
                'mime' => $mimeType
            ]
        ]);

        return api()->success(trans('user.responses.avatar-updated'), [
            'mime' => $mimeType,
            'link' => route('customer.get-avatar-image')
        ]);
    }

    /**
     * Get avatar details
     * @group Public User > Profile Management
     */
    public function getAvatarDetails()
    {

        if (empty(auth()->user()->avatar))
            return api()->error(trans('user.responses.user-has-no-avatar'), null, 404);

        $avatar = json_decode(auth()->user()->avatar, true);
        return api()->success(null, [
            'mime' => $avatar['mime'],
            'link' => route('customer.get-avatar-image')
        ]);
    }

    /**
     * Get avatar image
     * @group Public User > Profile Management
     */
    public function getAvatarImage()
    {

        if (empty(auth()->user()->avatar))
            return api()->error(trans('user.responses.user-has-no-avatar'), null, 404);

        $avatar = json_decode(auth()->user()->avatar, true);

        if (!$avatar OR !is_array($avatar) OR !array_key_exists('file_name', $avatar) OR !Storage::disk('local')->exists('/avatars/' . $avatar['file_name']))
            return api()->error('', null, 404);

        return base64_encode(Storage::disk('local')->get('/avatars/' . $avatar['file_name']));
    }


    /**
     * Sponsor New User
     * @group
     * Public User > Sponsor
     */
    public function sponsor(SponsorUserRequest $request)
    {


        list($user, $password) = $this->user_service->createAndSponsorUser($request);

//        $order = new Order();
//        $order->setFromUserId((int)auth()->user()->id);
//        $order->setUserId((int)$user->id);
//        $order->setPackageId((int)$request->package_id);
//        $acknowledge = OrderClientFacade::sponsorPackage($order);

//        if ($acknowledge->getStatus()) {
            try {
                UrgentEmailJob::dispatch(new WelcomeWithPasswordEmail($user, $password), $user->email);
            } catch (\Exception $exception) {
                Log::error("UserController@sponsor => sending email failed " . $exception->getMessage());
            }
            return api()->success(trans('user.responses.successfully-registered-go-activate-your-email'), ProfileResource::make($user));
//        } else {
//            $user->forceDelete();
//            return api()->error($acknowledge->getMessage());
//        }


    }


}
