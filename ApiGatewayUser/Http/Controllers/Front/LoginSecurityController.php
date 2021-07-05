<?php

namespace ApiGatewayUser\Http\Controllers\Front;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ApiGatewayUser\Http\Requests\Auth\OtpRequest;

class LoginSecurityController extends Controller
{

    /**
     * Generate 2FA secret key
     * @group
     * Auth
     */
    public function generate2faSecret()
    {
        $user = auth()->user();

        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

        if(is_null($user->google2fa_secret)){
            $user->google2fa_enable = false;
            $user->google2fa_secret = $google2fa->generateSecretKey();
            $user->save();
        }

        $google2fa_url = $google2fa->getQRCodeInline(
            getSetting("APP_NAME"),
            $user->email,
            $user->google2fa_secret
        );
        $secret_key = $user->google2fa_secret;

        $data = array(
            'secret' => $secret_key,
            'google2fa_url' => $google2fa_url
        );

        return api()->success(trans('responses.success'), $data);

    }

    /**
     * Enable 2FA
     * @group
     * Auth
     */
    public function enable2fa(OtpRequest $request)
    {
        $user = auth()->user();
        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

        $secret = $request->input('one_time_password');
        $valid = $google2fa->verifyKey($user->google2fa_secret, $secret);

        if ($valid) {
            $user->google2fa_enable = true;
            $user->save();
            return api()->success(trans('responses.2FA-is-enabled-successfully'));
        } else {
            return api()->error(trans('responses.Invalid-verification-Code-Please-try-again'));
        }
    }

    /**
     * Disable 2FA
     * @group
     * Auth
     */
    public function disable2fa(OtpRequest $request)
    {
        $user = auth()->user();
        $user->google2fa_enable = false;
        $user->save();
        return api()->success(trans('responses.2FA-is-now-disabled'));
    }
}
