<?php

namespace R2FUser\Http\Middlewares;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use R2FUser\Mail\User\SuspiciousLoginAttemptEmail;
use R2FUser\Models\LoginAttempt as LoginAttemptModel;
use R2FUser\Models\User;
use R2FUser\Support\UserActivityHelper;

class LoginAttemptMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::whereEmail($request->email)->first();
        if (!$user)
            abort(401);

        list($ip_db, $agent_db) = UserActivityHelper::getInfo($request);

        $login_attempt = LoginAttemptModel::query()->create([
            "user_id" => is_null($user) ? null : $user->id,
            "ip_id" => is_null($ip_db) ? null : $ip_db->id,
            "agent_id" => is_null($agent_db) ? null : $agent_db->id,
        ]);

        $this->blockSuspiciousActivity($user, $login_attempt);

        $this->sendMailForSuspiciousNewIpOrDevice($user, $ip_db, $agent_db, $login_attempt);

        $request->attributes->add(['login_attempt' => $login_attempt->id]);

        return $next($request);

    }

    /**
     * @param $ip_db
     * @param $user
     * @return bool
     */
    private function isLoginFromNewIp($ip_db, $user)
    {
        return !is_null($ip_db) && LoginAttemptModel::query()->where('user_id',$user->id)->where("ip_id", $ip_db->id)->count() == 1;
    }

    /**
     * @param $agent_db
     * @param $user
     * @return bool
     */
    private function isLoginFromNewAgent($agent_db, $user): bool
    {
        return (!is_null($agent_db) && LoginAttemptModel::query()->where('user_id',$user->id)->where("agent_id", $agent_db->id)->count() == 1 );
    }

    /**
     * @param $user
     * @return bool
     */
    private function userHasAlreadyAtLeastOneLoginAttempt($user): bool
    {
        return $user->loginAttempts->count() > 0;
    }

    /**
     * @param $user
     * @param $login_attempt
     * @throws \Exception
     */
    private function blockSuspiciousActivity($user, $login_attempt): void
    {
        $intervals = explode(',', getSetting('MAX_LOGIN_ATTEMPTS_INTERVALS'));
        array_reverse($intervals);

        $tries = getSetting('MAX_LOGIN_ATTEMPTS_TRIES');

        foreach ($intervals as $key => $interval) {

            if (LoginAttemptModel::query()->where('is_success', false)
                    ->whereBetween('created_at', [now()->subSeconds($interval)->format('Y-m-d H:i:s'), Carbon::tomorrow()->format('Y-m-d H:i:s')])
                    ->count() >= ($key + 1) * $tries) {
                //if($key == 0 ){
                //TODO block user
                //}
                $login_attempt->is_success = 2;
                $login_attempt->save();
                Mail::to($user->email)->send(new SuspiciousLoginAttemptEmail($user, $login_attempt));
                abort(401, trans('responses.max-login-attempt-exceeded'));
            }
        }
    }

    /**
     * @param $user
     * @param $ip_db
     * @param $agent_db
     * @param $login_attempt
     */
    private function sendMailForSuspiciousNewIpOrDevice($user, $ip_db, $agent_db, $login_attempt): void
    {
        if (
            $this->userHasAlreadyAtLeastOneLoginAttempt($user) &&
            (
                $this->isLoginFromNewIp($ip_db, $user) ||
                $this->isLoginFromNewAgent($agent_db, $user)
            )
        ) {
            Mail::to($user->email)->send(new SuspiciousLoginAttemptEmail($user, $login_attempt));
        }
    }
}
