<?php

namespace R2FUser\Http\Controllers;

use App\Http\Helpers\ResponseData;
use App\Models\User;
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
     */
    public function register(RegisterUserRequest $request)
    {
        $user = User::query()->create($request->validated());

        $token = $user->createToken(APP_NAME)->plainTextToken;

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

        if (!$user || Hash::check($credentials['password'], $user->password)) {
            return ResponseData::error(trans('responses.invalid-inputs-from-user'), null, 400);
        }
        $token = $user->createToken(APP_NAME)->plainTextToken;
        return $this->respondWithToken($token);
    }

    /**
     * Get Current User
     * @group
     * Auth
     */
    public function getAuthUser()
    {
        return ResponseData::success(ProfileResource::make(auth()->user()));
    }

    /**
     * Forget Password
     * @group
     * Auth
     */
    public function forgetPassword(ForgetPasswordRequest $request)
    {
        return ResponseData::success(ProfileResource::make(auth()->user()));
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
