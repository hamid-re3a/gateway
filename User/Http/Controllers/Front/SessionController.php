<?php

namespace User\Http\Controllers\Front;


use User\Http\Requests\User\Session\TerminateSessionRequest;
use User\Http\Resources\User\ActiveSessionsResource;
use User\Models\Agent;
use Illuminate\Routing\Controller;

class SessionController extends Controller
{
    /**
     * Get All Sessions
     * @group
     * Session
     */
    public function index()
    {
        $agents = request()->user()->agents()->with('ips')->whereHas('ips')->whereNotNull('token_id')->simplePaginate();
        return api()->success(trans('user.responses.ok'), ActiveSessionsResource::collection($agents));
    }

    /**
     * Logout a session
     * @group
     * Session
     * @param TerminateSessionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signout(TerminateSessionRequest $request)
    {
        $session = $request->user()->agents()->whereId($request->get('session_id'))->first();
        $token = $request->user()->tokens()->whereId($session->token_id);
        $session->update([
            'token_id' => null
        ]);
        $token->delete();
        return api()->success(trans('user.responses.ok'));

    }

    /**
     * Logout a session
     * @group
     * Session
     * @return \Illuminate\Http\JsonResponse
     */
    public function signOutAllOtherSessions()
    {
        $currentToken = request()->user()->currentAccessToken();
        $otherTokens = request()->user()->tokens()->where('id','<>', $currentToken->id)->pluck('id');
        if(count($otherTokens) == 0)
            return api()->error('You have only one active session');

        request()->user()->agents()->whereIn('token_id', $otherTokens)->update([
            'token_id' => null
        ]);
        request()->user()->tokens()->whereIn('id', $otherTokens)->delete();
        return api()->success(trans('user.responses.ok'));

    }
}
