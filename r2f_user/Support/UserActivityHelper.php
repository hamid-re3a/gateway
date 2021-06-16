<?php

namespace R2FUser\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;
use R2FUser\Models\Agent as AgentModel;
use R2FUser\Models\Ip;

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
                "language" => is_null($agentJess->languages()) ? null : $agentJess->languages()[0],
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
}
