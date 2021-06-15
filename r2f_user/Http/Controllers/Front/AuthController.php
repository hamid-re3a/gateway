<?php

namespace R2FUser\Http\Controllers\Front;

use R2FUser\Http\Requests\Auth\EmailVerificationOtpRequest;
use R2FUser\Http\Requests\Auth\ResetForgetPasswordRequest;
use R2FUser\Http\Requests\Auth\VerifyEmailOtpRequest;
use R2FUser\Jobs\EmailJob;
use Illuminate\Support\Facades\Mail;
use R2FUser\Mail\User\ForgetPasswordOtpEmail;
use R2FUser\Mail\User\SuspiciousLoginAttemptEmail;
use R2FUser\Models\Otp;
use R2FUser\Models\LoginAttempt;
use R2FUser\Models\User;;
use R2FUser\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Helpers\ResponseData;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use R2FUser\Http\Requests\Auth\LoginRequest;
use R2FUser\Http\Requests\Auth\RegisterUserRequest;
use R2FUser\Http\Resources\Auth\ProfileResource;

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

        $user->makeEmailVerificationOtp();

        $token = $user->createToken(getSetting("APP_NAME"))->plainTextToken;

        return $this->respondWithToken($token);
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

        $login_attempt  = LoginAttempt::find($request->attributes->get('login_attempt'));
        if (!Hash::check($credentials['password'], $user->password)) {
                $login_attempt->is_success = 2;
                $login_attempt->save();
                EmailJob::dispatch(new SuspiciousLoginAttemptEmail($user, $login_attempt),$user->email)->onQueue(QUEUES_EMAIL);

            return ResponseData::error(trans('responses.invalid-inputs-from-user'), null, 400);
        }
        $token = $user->createToken(getSetting("APP_NAME"))->plainTextToken;

        $login_attempt->is_success = 1;
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
        list($token,$err) = $user->makeEmailVerificationOtp();
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
        $duration = getSetting('USER_EMAIL_VERIFICATION_OTP_DURATION');
        $otp_db = $user->otps()
            ->where('type',OTP_EMAIL_VERIFICATION)
            ->whereBetween('created_at', [now()->subSeconds($duration)->format('Y-m-d H:i:s'), now()->format('Y-m-d H:i:s')])
            ->get()
            ->last();
        if(is_null($otp_db))
            return ResponseData::error('responses.otp-is-not-valid-any-more');


        if($otp_db->otp == $request->otp){
            $user->is_email_verified = true;
            $user->email_verified_at = now();
            $user->save();

            $token = $user->createToken(getSetting("APP_NAME"))->plainTextToken;

            return $this->respondWithToken($token);
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
    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $user = User::whereEmail($request->email)->first();
        list($token,$err) = $user->makeForgetPasswordOtp();
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
        $duration = getSetting('USER_FORGET_PASSWORD_OTP_DURATION');
        $fp_db = $user->otps()
            ->where('type',OTP_EMAIL_FORGET_PASSWORD)
            ->whereBetween('created_at', [now()->subSeconds($duration)->format('Y-m-d H:i:s'), now()->format('Y-m-d H:i:s')])
            ->get()
            ->last();
        if(is_null($fp_db))
            return ResponseData::error('responses.otp-is-not-valid-any-more');


        if($fp_db->otp == $request->otp){
            $user->password = $request->password;
            $user->save();
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


    protected function respondWithToken($token)
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
        ];
        return ResponseData::success(trans('responses.login-successful'), $data);
    }


}
