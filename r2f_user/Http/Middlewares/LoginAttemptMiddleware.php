<?php

namespace R2FUser\Http\Middlewares;

use App\Models\LoginAttemptSetting;
use R2FUser\Jobs\EmailJob;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use R2FUser\Mail\User\SuspiciousLoginAttemptEmail;
use R2FUser\Mail\User\TooManyLoginAttemptPermanentBlockedEmail;
use R2FUser\Mail\User\TooManyLoginAttemptTemporaryBlockedEmail;
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
            abort(422, trans('responses.invalid-input'));

        list($ip_db, $agent_db) = UserActivityHelper::getInfo($request);

        $login_attempt = LoginAttemptModel::query()->create([
            "user_id" => is_null($user) ? null : $user->id,
            "ip_id" => is_null($ip_db) ? null : $ip_db->id,
            "agent_id" => is_null($agent_db) ? null : $agent_db->id,
        ]);

        $this->blockTooManyLoginAttempts($user, $login_attempt, $request);

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
        return !is_null($ip_db) && LoginAttemptModel::query()->where('user_id', $user->id)->where("ip_id", $ip_db->id)->count() == 1;
    }

    /**
     * @param $agent_db
     * @param $user
     * @return bool
     */
    private function isLoginFromNewAgent($agent_db, $user): bool
    {
        return (!is_null($agent_db) && LoginAttemptModel::query()->where('user_id', $user->id)->where("agent_id", $agent_db->id)->count() == 1);
    }

    /**
     * @param $user
     * @return bool
     */
    private function userHasAlreadyAtLeastOneLoginAttempt($user): bool
    {
        return $user->loginAttempts->count() > 1;
    }

    /**
     * @param $user
     * @param $login_attempt
     * @param $request
     * @throws \Exception
     */
    private function blockTooManyLoginAttempts($user, $login_attempt, $request): void
    {
        list($intervals, $tries) = getLoginAttemptSetting();
        $reverse_intervals = array_reverse($intervals);

        $thresholds = [];
        foreach ($tries as $key => $count) {
            $thresholds[] = sumUp($tries, $key) - 1;
        }
        foreach ($reverse_intervals as $key => $interval) {
            $sum_up_key = (count($intervals) - 1 - $key);
            $since_beginning_intervals = sumUp($intervals, $sum_up_key) + $interval;
            $login_attempt_count = LoginAttemptModel::query()->whereIn('login_status', [LOGIN_ATTEMPT_STATUS_FAILED])
                ->where('user_id', $user->id)
                ->whereBetween('created_at', [now()->subSeconds($since_beginning_intervals)->format('Y-m-d H:i:s'), now()->format('Y-m-d H:i:s')])
                ->count();
            $first_attempt = LoginAttemptModel::query()->where('login_status', [LOGIN_ATTEMPT_STATUS_FAILED])
                ->where('user_id', $user->id)
                ->whereBetween('created_at', [now()->subSeconds($since_beginning_intervals)->format('Y-m-d H:i:s'), now()->format('Y-m-d H:i:s')])
                ->get()->first();
            if (!is_null($first_attempt)) {
                $try_in = Carbon::make($first_attempt->created_at)->addSeconds($since_beginning_intervals)->diffForHumans();
                $try_in_sec = Carbon::make($first_attempt->created_at)->addSeconds($since_beginning_intervals)->timestamp;
                $request->attributes->add(['try_in' => $try_in]);
                $request->attributes->add(['try_in_timestamp' => $try_in_sec]);
                $last_login = LoginAttemptModel::query()->where('user_id', $user->id)->latest()->take(2)->get()->last();

            }
            if ($login_attempt_count + 1 >= sumUp($tries, $sum_up_key + 1)) {

                if ($key == 0) {
                    $user->block_type = USER_BLOCK_TYPE_AUTOMATIC;
                    $user->block_reason = 'responses.max-login-attempt-blocked';
                    $user->save();
                    $login_attempt->login_status = LOGIN_ATTEMPT_STATUS_BLOCKED;
                    $login_attempt->save();
                    EmailJob::dispatch(new TooManyLoginAttemptPermanentBlockedEmail($user, $login_attempt), $user->email)->onQueue(QUEUES_EMAIL);
                    break;
                }
                $login_attempt->login_status = LOGIN_ATTEMPT_STATUS_BLOCKED;
                $login_attempt->save();
                if (in_array($login_attempt_count, $thresholds) && isset($last_login) && isset($try_in) && $last_login->login_status != LOGIN_ATTEMPT_STATUS_BLOCKED)
                    EmailJob::dispatch(new TooManyLoginAttemptTemporaryBlockedEmail($user, $login_attempt, $login_attempt_count, $try_in), $user->email)->onQueue(QUEUES_EMAIL);

                break;
            }

            $request->attributes->add(['left_attempts' => sumUp($tries, $sum_up_key + 1) - $login_attempt_count - 1]);

        }


    }

    /**
     * @param $user
     * @param $ip_db
     * @param $agent_db
     * @param $login_attempt
     */
    private function sendMailForSuspiciousNewIpOrDevice($user, $ip_db, $agent_db, LoginAttemptModel $login_attempt): void
    {
        if (
            $this->userHasAlreadyAtLeastOneLoginAttempt($user) &&
            (
                $this->isLoginFromNewIp($ip_db, $user) ||
                $this->isLoginFromNewAgent($agent_db, $user)
            )
        ) {
            $login_attempt->is_from_new_device = 1;
            $login_attempt->save();
            EmailJob::dispatch(new SuspiciousLoginAttemptEmail($user, $login_attempt), $user->email)->onQueue(QUEUES_EMAIL);
        }
    }


}
