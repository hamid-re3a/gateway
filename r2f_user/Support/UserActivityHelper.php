<?php

namespace R2FUser\Support;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use R2FUser\Jobs\EmailJob;
use R2FUser\Mail\User\EmailVerifyOtp;
use R2FUser\Mail\User\ForgetPasswordOtpEmail;
use R2FUser\Mail\User\WelcomeEmail;
use R2FUser\Models\Agent as AgentModel;
use R2FUser\Models\Ip;
use R2FUser\Models\Otp;
use R2FUser\Models\User;

class UserActivityHelper
{
    /**
     * @param Request $request
     * @return array
     */
    public static function getInfo(Request $request): array
    {
        $ip_db = null;
        if (!is_null($request->ip())) {
            $ip = null;
            try {
                $ip = GeoIp::getInfo($request->ip());
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
            if (!is_null($ip))
                $ip_db = Ip::query()->firstOrCreate($ip->toArray());
            else
                $ip_db = Ip::query()->firstOrCreate(['ip' => $request->ip()]);
            if (!is_null($request)) {
                $ip_db->hit = $ip_db->hit + 1;
                $ip_db->save();
            }
        }
        $agent_db = null;
        if (!is_null($request->userAgent())) {
            $agentJess = new Agent();
            $agentJess->setUserAgent($request->userAgent());
            $agentJess->setHttpHeaders($request->headers);
            $agent_db = AgentModel::query()->firstOrCreate([
                "language" => is_null($agentJess->languages()) || !isset($agentJess->languages()[0]) ? null : $agentJess->languages()[0],
                "device_type" => $agentJess->device(),
                "platform" => $agentJess->platform(),
                "browser" => $agentJess->browser(),
                "is_desktop" => $agentJess->isDesktop(),
                "is_phone" => $agentJess->isPhone(),
                "robot" => $agentJess->robot(),
                "is_robot" => $agentJess->isRobot(),
                "platform_version" => $agentJess->version($agentJess->platform()),
                "browser_version" => $agentJess->version($agentJess->browser()),
                "user_agent" => $request->userAgent(),
            ]);
            if (!is_null($request)) {
                $agent_db->hit = $agent_db->hit + 1;
                $agent_db->save();
            }
        }
        return array($ip_db, $agent_db);
    }


    /**
     * @throws \Exception
     */
    public static function makeForgetPasswordOtp(User $user, Request $request): array
    {
        $data = [];
        $data['try_in'] = null;
        $data['try_in_timestamp'] = null;
        $error = null;

        $tries = getSetting('USER_FORGOT_PASSWORD_OTP_TRIES');
        $duration = getSetting('USER_FORGOT_PASSWORD_OTP_DURATION');

        if (Otp::query()
                ->where('user_id', $user->id)
                ->type(OTP_TYPE_EMAIL_FORGOT_PASSWORD)
                ->whereBetween('created_at', [now()->subSeconds($duration)->format('Y-m-d H:i:s'), now()->format('Y-m-d H:i:s')])
                ->count() < $tries) {
            $token = self::getRandomOtp();

            list($ip_db, $agent_db) = UserActivityHelper::getInfo($request);
            Otp::query()->create([
                "user_id" => $user->id,
                "ip_id" => is_null($ip_db) ? null : $ip_db->id,
                "agent_id" => is_null($agent_db) ? null : $agent_db->id,
                "otp" => $token,
                "type" => OTP_TYPE_EMAIL_FORGOT_PASSWORD
            ]);
            EmailJob::dispatch(new ForgetPasswordOtpEmail($user, $token), $user->email)->onQueue(QUEUES_EMAIL);
            return [$token, $error];

        }

        $data = self::firstAttemptOtp($user, OTP_TYPE_EMAIL_FORGOT_PASSWORD, $duration, $data);
        $error = true;
        return [$data, $error];


    }


    /**
     * @throws \Exception
     */
    public static function makeEmailVerificationOtp(User $user, Request $request, $is_welcome = true): array
    {
        $data = [];
        $data['try_in'] = null;
        $data['try_in_timestamp'] = null;
        $error = null;

        $tries = getSetting('USER_EMAIL_VERIFICATION_OTP_TRIES');
        $duration = getSetting('USER_EMAIL_VERIFICATION_OTP_DURATION');

        if (Otp::query()
                ->type(OTP_TYPE_EMAIL_VERIFICATION)
                ->where('user_id', $user->id)
                ->whereBetween('created_at', [now()->subSeconds($duration)->format('Y-m-d H:i:s'), now()->format('Y-m-d H:i:s')])
                ->count() < $tries) {
            $token = self::getRandomOtp();

            list($ip_db, $agent_db) = UserActivityHelper::getInfo($request);
            Otp::query()->create([
                "user_id" => $user->id,
                "ip_id" => is_null($ip_db) ? null : $ip_db->id,
                "agent_id" => is_null($agent_db) ? null : $agent_db->id,
                "otp" => $token,
                "type" => OTP_TYPE_EMAIL_VERIFICATION
            ]);

            if ($is_welcome)
                EmailJob::dispatch(new WelcomeEmail($user, $token), $user->email)->onQueue(QUEUES_EMAIL);
            else
                EmailJob::dispatch(new EmailVerifyOtp($user, $token), $user->email)->onQueue(QUEUES_EMAIL);
            return [$data, $error];

        }

        $data = self::firstAttemptOtp($user, OTP_TYPE_EMAIL_VERIFICATION, $duration, $data);
        $error = true;
        return [$data, $error];


    }


    /**
     * @throws \Exception
     */
    public static function getRandomOtp()
    {
        $length = getSetting("OTP_LENGTH");
        if (getSetting("OTP_CONTAIN_ALPHABET") && getSetting("OTP_CONTAIN_ALPHABET_LOWER_CASE"))
            return strtolower(Str::random($length));
        else if (getSetting("OTP_CONTAIN_ALPHABET") && !getSetting("OTP_CONTAIN_ALPHABET_LOWER_CASE"))
            return Str::random($length);
        else
            return random_int(pow(10, $length - 1), pow(10, $length) - 1);
    }

    /**
     * @param User $user
     * @param string|null $duration
     * @param array $data
     * @return array
     */
    private static function firstAttemptOtp(User $user, $type, ?string $duration, array $data): array
    {
        $first_attempt = Otp::query()
            ->type($type)
            ->where('user_id', $user->id)
            ->whereBetween('created_at', [now()->subSeconds($duration)->format('Y-m-d H:i:s'), now()->format('Y-m-d H:i:s')])
            ->get()->first();
        $try_in = Carbon::make($first_attempt->created_at)->addSeconds($duration)->diffForHumans();
        $try_in_sec = Carbon::make($first_attempt->created_at)->addSeconds($duration)->timestamp;
        $data['try_in'] = $try_in;
        $data['try_in_timestamp'] = $try_in_sec;
        return $data;
    }
}