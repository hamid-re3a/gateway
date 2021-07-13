<?php

namespace User\Http\Requests\Auth;

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
            'otp' => 'required|string|exists:otps,otp',
            'password' => ['required','regex:/'.getSetting('USER_REGISTRATION_PASSWORD_CRITERIA').'/'],
            'password_confirmation' => 'required|string|same:password',
        ];
    }

    public function messages()
    {
        return [

            'email.exists' => trans('user.validation.email-not-exists'),
            'password_confirmation.same' => trans('user.validation.password-same'),
            'email.required' => trans('user.validation.email-required'),
            'password.required' => trans('user.validation.first-name-required'),
            'email.email' => trans('user.validation.email-is-incorrect'),
            'otp.exists' => trans('user.responses.password-reset-code-is-invalid'),
        ];
    }
}
