<?php

namespace User\Http\Controllers\Front;


use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use User\Http\Requests\Auth\EmailExistenceRequest;
use User\Http\Requests\Auth\EmailVerificationOtpRequest;
use User\Http\Requests\Auth\ForgetPasswordRequest;
use User\Http\Requests\Auth\LoginRequest;
use User\Http\Requests\Auth\RegisterUserRequest;
use User\Http\Requests\Auth\ResetForgetPasswordRequest;
use User\Http\Requests\Auth\UsernameExistenceRequest;
use User\Http\Requests\Auth\VerifyEmailOtpRequest;
use User\Http\Resources\Auth\ProfileResource;
use User\Jobs\EmailJob;
use User\Mail\User\NormalLoginEmail;
use User\Mail\User\PasswordChangedEmail;
use User\Mail\User\SuccessfulEmailVerificationEmail;
use User\Models\LoginAttempt;
use User\Models\User;
use User\Support\UserActivityHelper;

;

class AuthController extends Controller
{
    /**
     * Register New User
     * @group
     * Auth
     * @unauthenticated
     * @throws \Exception
     */
    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();
        unset($data['password_confirmation']);
        $user = User::query()->create($data);

        UserActivityHelper::makeEmailVerificationOtp($user, $request);

        return api()->success(trans('responses.successfully-registered-go-activate-your-email'));
    }

    /**
     * Login
     * @group
     * Auth
     * @unauthenticated
     */
    public function login(LoginRequest $request)
    {

        $credentials = $request->only(['email', 'password']);

        $user = User::query()->where('email', $credentials['email'])->first();

        if (!$user->isEmailVerified())
            return api()->error(trans('responses.go-activate-your-email'), null, 403);

        $login_attempt = LoginAttempt::find($request->attributes->get('login_attempt'));

        $data = [];
        $data['left_attempts'] = $request->get('left_attempts');
        if ($login_attempt && $login_attempt->login_status == LOGIN_ATTEMPT_STATUS_BLOCKED) {
            $data['try_in'] = $request->get('try_in');
            $data['try_in_timestamp'] = $request->get('try_in_timestamp');
            return api()->error(trans('responses.max-attempts-exceeded'), $data, 429);
        }
        if (!Hash::check($credentials['password'], $user->password)) {
            $login_attempt->login_status = LOGIN_ATTEMPT_STATUS_FAILED;
            $login_attempt->save();

            return api()->error(trans('responses.invalid-inputs-from-user'), $data, 400);
        }
        $token = $this->getNewTokenAndDeleteOthers($user);

        $login_attempt->login_status = LOGIN_ATTEMPT_STATUS_SUCCESS;
        $login_attempt->save();

        EmailJob::dispatch(new NormalLoginEmail($user, $login_attempt), $user->email);
        return $this->respondWithToken($token);
    }

    /**
     * Get Current User
     * @group
     * Auth
     */
    public function getAuthUser()
    {
        return api()->success(trans('responses.success'), ProfileResource::make(auth()->user()));
    }

    /**
     * Check email existence
     * @group
     * Auth
     * @unauthenticated
     */
    public function isEmailExists(EmailExistenceRequest $request)
    {
        if (User::whereEmail($request->email)->exists())
            return api()->success(trans('responses.email-already-exists'), true);

        return api()->success(trans('responses.email-does-not-exist'), false);
    }

    /**
     * Username existence
     * @group
     * Auth
     * @unauthenticated
     */
    public function isUsernameExists(UsernameExistenceRequest $request)
    {
        if (User::whereUsername($request->username)->exists())
            return api()->success(trans('responses.username-already-exists'), true);

        return api()->success(trans('responses.username-does-not-exist'), false);
    }

    /**
     * Ask Email Verification Otp
     * @group
     * Auth
     * @unauthenticated
     * @throws \Exception
     */
    public function askForEmailVerificationOtp(EmailVerificationOtpRequest $request)
    {
        $user = User::whereEmail($request->email)->first();
        if ($user->isEmailVerified())
            return api()->success(trans('responses.email-is-already-verified'));

        list($data, $err) = UserActivityHelper::makeEmailVerificationOtp($user, $request, false);
        if ($err) {
            $errors = [
                'otp' => trans('responses.otp-exceeded-amount')
            ];
            return api()->error(trans('responses.otp-exceeded-amount'), $data, 429, $errors);
        }
        return api()->success(trans('responses.otp-successfully-sent'));
    }


    /**
     * Activate Email
     * @group
     * Auth
     * @unauthenticated
     * @throws \Exception
     */
    public function verifyEmailOtp(VerifyEmailOtpRequest $request)
    {
        $user = User::whereEmail($request->email)->first();
        if ($user->isEmailVerified())
            return api()->success(trans('responses.email-is-already-verified'));

        $duration = getSetting('USER_EMAIL_VERIFICATION_OTP_DURATION');
        $otp_db = $user->otps()
            ->where('type', OTP_TYPE_EMAIL_VERIFICATION)
            ->whereBetween('created_at', [now()->subSeconds($duration)->format('Y-m-d H:i:s'), now()->format('Y-m-d H:i:s')])
            ->get()
            ->last();
        if (is_null($otp_db)){
            $errors = [
                'otp' => trans('responses.otp-exceeded-amount')
            ];
            return api()->error('responses.otp-is-not-valid-any-more','',422,$errors);
        }


        if ($otp_db->otp == $request->otp) {
            $user->email_verified_at = now();
            $user->save();

            $token = $this->getNewTokenAndDeleteOthers($user);

            list($ip_db, $agent_db) = UserActivityHelper::getInfo($request);
            EmailJob::dispatch(new SuccessfulEmailVerificationEmail($user, $ip_db, $agent_db), $user->email);

            return $this->respondWithToken($token, 'responses.email-verified-successfully');
        }
        return api()->error('responses.otp-is-wrong');

    }

    /**
     * Forget Password
     * @group
     * Auth
     * @unauthenticated
     * @throws \Exception
     */
    public function forgotPassword(ForgetPasswordRequest $request)
    {
        $user = User::whereEmail($request->email)->first();
        list($data, $err) = UserActivityHelper::makeForgetPasswordOtp($user, $request);
        if ($err) {
            return api()->error(trans('responses.forgot-password-otp-exceeded-amount'), $data, 429);
        }
        return api()->success(trans('responses.otp-successfully-sent'));
    }


    /**
     * Reset Forget Password
     * @group
     * Auth
     * @unauthenticated
     * @throws \Exception
     */
    public function resetForgetPassword(ResetForgetPasswordRequest $request)
    {
        $user = User::whereEmail($request->email)->first();
        $duration = getSetting('USER_FORGOT_PASSWORD_OTP_DURATION');
        $fp_db = $user->otps()
            ->where('type', OTP_TYPE_EMAIL_FORGOT_PASSWORD)
            ->whereBetween('created_at', [now()->subSeconds($duration)->format('Y-m-d H:i:s'), now()->format('Y-m-d H:i:s')])
            ->get()
            ->last();
        if (is_null($fp_db)){
            $errors = [
                'otp' => trans('responses.otp-is-not-valid-any-more')
            ];
            return api()->error(trans('responses.otp-is-not-valid-any-more'),'',422,$errors);
        }


        if ($fp_db->otp == $request->otp) {
            $user->password = $request->password;
            $user->save();
            list($ip_db, $agent_db) = UserActivityHelper::getInfo($request);
            EmailJob::dispatch(new PasswordChangedEmail($user, $ip_db, $agent_db), $user->email);


            return api()->success(trans('responses.password-successfully-changed'));
        }

        $errors = [
            'otp' => trans('responses.otp-is-wrong')
        ];
        return api()->error('responses.otp-is-wrong','',422,$errors);

    }

    /**
     * Log out
     * @group
     * Auth
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return api()->success(trans('responses.logout-successful'));
    }

    /**
     * Ping
     * @group
     * Auth
     */
    public function ping()
    {
        return api()->success(trans('responses.ok'));
    }


    protected function respondWithToken($token, $message = 'responses.login-successful')
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
        ];
        return api()->success(trans($message), $data);
    }

    /**
     * @param $user
     * @return mixed
     * @throws \Exception
     */
    private function getNewTokenAndDeleteOthers($user)
    {
        $user->tokens()->delete();
        $token = $user->createToken(getSetting("APP_NAME"))->plainTextToken;
        return $token;
    }


}
