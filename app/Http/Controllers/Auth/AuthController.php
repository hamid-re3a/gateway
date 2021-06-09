<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseData;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\ProfileResource;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Register New User
     * @group
     * Auth
     * @unauthenticated
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);

        $user = User::create($data);
        $user->assignRole(USER_ROLE_CLIENT);

        $token = auth()->login($user);

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

        if (!$token = auth()->attempt($credentials)) {
            return ResponseData::error(trans('responses.invalid-inputs-from-user'), null, 400);
        }

        return $this->respondWithToken($token);
    }
    /**
     * Get Current User
     * @group
     * Auth
     */
    public function getAuthUser()
    {
        return response()->json(ProfileResource::make(auth()->user()));
    }

    /**
     * Log out
     * @group
     * Auth
     */
    public function logout()
    {
        auth()->logout();
        return ResponseData::success(trans('responses.logout-successful'));
    }


    protected function respondWithToken($token)
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
        return ResponseData::success(trans('responses.login-successful'), $data);
    }


}
