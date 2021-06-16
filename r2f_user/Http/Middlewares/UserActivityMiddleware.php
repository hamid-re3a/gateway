<?php

namespace R2FUser\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use R2FUser\Models\UserActivity as UserActivityModel;
use R2FUser\Support\UserActivityHelper;

class UserActivityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
//        $request->server->add(['REMOTE_ADDR' => '89.41.7.95']);
        $user = null;
        if (auth()->check()) {
            $user = auth()->user();
        }
        list($ip_db, $agent_db) = UserActivityHelper::getInfo($request);

        UserActivityModel::query()->create([
            "user_id" => is_null($user) ? null : $user->id,
            "ip_id" => is_null($ip_db) ? null : $ip_db->id,
            "agent_id" => is_null($agent_db) ? null : $agent_db->id,
            "route" => $request->path()
        ]);
        return $next($request);
    }


}
