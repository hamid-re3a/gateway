<?php

namespace R2FUser\Http\Controllers\Front;

use App\Http\Helpers\ResponseData;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use R2FUser\Http\Requests\Auth\EmailVerificationOtpRequest;
use R2FUser\Http\Requests\Auth\ForgetPasswordRequest;
use R2FUser\Http\Requests\Auth\LoginRequest;
use R2FUser\Http\Requests\Auth\RegisterUserRequest;
use R2FUser\Http\Requests\Auth\ResetForgetPasswordRequest;
use R2FUser\Http\Requests\Auth\VerifyEmailOtpRequest;
use R2FUser\Http\Resources\Auth\ProfileResource;
use R2FUser\Jobs\EmailJob;
use R2FUser\Mail\User\PasswordChangedEmail;
use R2FUser\Mail\User\SuccessfulEmailVerificationEmail;
use R2FUser\Models\LoginAttempt;
use R2FUser\Models\User;
use R2FUser\Support\UserActivityHelper;

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

        $user->makeEmailVerificationOtp($request);

        return ResponseData::success(trans('responses.successfully-registered-go-activate-your-email'));
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

        if(!$user->is_email_verified)
            return ResponseData::success(trans('responses.go-activate-your-email'));

        $login_attempt  = LoginAttempt::find($request->attributes->get('login_attempt'));

        $data = [];
        $data['left_attempts'] = $request->get('left_attempts');
        if($login_attempt && $login_attempt->login_status == LOGIN_ATTEMPT_STATUS_BLOCKED){
            $data['try_in'] = $request->get('try_in');
            $data['try_in_timestamp'] = $request->get('try_in_timestamp');
            return ResponseData::error(trans('responses.max-attempts-exceeded'), $data, 429);
        }
        if (!Hash::check($credentials['password'], $user->password)) {
                $login_attempt->login_status = LOGIN_ATTEMPT_STATUS_FAILED;
                $login_attempt->save();

            return ResponseData::error(trans('responses.invalid-inputs-from-user'), $data, 400);
        }
        $token = $this->getNewTokenAndDeleteOthers($user);

        $login_attempt->login_status = LOGIN_ATTEMPT_STATUS_SUCCESS;
        $login_attempt->save();
        return $this->respondWithToken($token);
    }

    /**
     * Get Current User
     * @group
     * Auth
     */
    public function getAuthUser()
    {
        return ResponseData::success(trans('responses.success'),ProfileResource::make(auth()->user()));
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
        if($user->is_email_verified)
            return ResponseData::success(trans('responses.email-is-already-verified'));

        list($token,$err) = $user->makeEmailVerificationOtp($request,false);
        if(!is_null($err)){
            return ResponseData::error(trans('responses.otp-exceeded-amount'));
        }
        return ResponseData::success(trans('responses.otp-successfully-sent'));
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
        if($user->is_email_verified)
            return ResponseData::success(trans('responses.email-is-already-verified'));

        $duration = getSetting('USER_EMAIL_VERIFICATION_OTP_DURATION');
        $otp_db = $user->otps()
            ->where('type',OTP_TYPE_EMAIL_VERIFICATION)
            ->whereBetween('created_at', [now()->subSeconds($duration)->format('Y-m-d H:i:s'), now()->format('Y-m-d H:i:s')])
            ->get()
            ->last();
        if(is_null($otp_db))
            return ResponseData::error('responses.otp-is-not-valid-any-more');


        if($otp_db->otp == $request->otp){
            $user->is_email_verified = true;
            $user->email_verified_at = now();
            $user->save();

            $token = $this->getNewTokenAndDeleteOthers($user);

            list($ip_db,$agent_db) = UserActivityHelper::getInfo($request);
            EmailJob::dispatch(new SuccessfulEmailVerificationEmail($user,$ip_db,$agent_db),$user->email);

            return $this->respondWithToken($token,'responses.email-verified-successfully');
        }
        return ResponseData::error('responses.otp-is-wrong');

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
        list($token,$err) = $user->makeForgetPasswordOtp($request);
        if(!is_null($err)){
            return ResponseData::error();
        }
        return ResponseData::success(trans('responses.otp-successfully-sent'));
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
            ->where('type',OTP_TYPE_EMAIL_FORGOT_PASSWORD)
            ->whereBetween('created_at', [now()->subSeconds($duration)->format('Y-m-d H:i:s'), now()->format('Y-m-d H:i:s')])
            ->get()
            ->last();
        if(is_null($fp_db))
            return ResponseData::error('responses.otp-is-not-valid-any-more');


        if($fp_db->otp == $request->otp){
            $user->password = $request->password;
            $user->save();
            list($ip_db,$agent_db)= UserActivityHelper::getInfo($request);
            EmailJob::dispatch(new PasswordChangedEmail($user,$ip_db,$agent_db),$user->email);



            return ResponseData::success(trans('responses.password-successfully-changed'));
        }
        return ResponseData::error('responses.otp-is-wrong');

    }

    /**
     * Log out
     * @group
     * Auth
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return ResponseData::success(trans('responses.logout-successful'));
    }

    /**
     * Ping
     * @group
     * Auth
     */
    public function ping()
    {
        return ResponseData::success(trans('responses.ok'));
    }


    protected function respondWithToken($token,$message = 'responses.login-successful' )
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
        ];
        return ResponseData::success(trans($message), $data);
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
