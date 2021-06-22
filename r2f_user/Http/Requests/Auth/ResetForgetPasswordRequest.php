<?php

namespace R2FUser\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetForgetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws \Exception
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string',
            'password' => ['required', 'confirmed','regex:/'.getSetting('USER_REGISTRATION_PASSWORD_CRITERIA').'/'],
            'password_confirmation' => 'required|string',
        ];
    }
}
