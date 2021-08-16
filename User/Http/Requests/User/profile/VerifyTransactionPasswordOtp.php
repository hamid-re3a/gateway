<?php

namespace User\Http\Requests\User\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use User\Models\User;

class VerifyTransactionPasswordOtp extends FormRequest
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
            'password' => 'required|different:current_password|regex:/' . getSetting('USER_REGISTRATION_PASSWORD_CRITERIA') . '/',
            'password_confirmation' => 'required|same:password',
            'otp' => 'required|string|exists:otps,otp',
        ];
    }

    public function messages()
    {
        return [
            'otp.exists' => trans('user.responses.transaction-password-otp-code-is-incorrect'),
            'password.required' => 'Enter new password.',
            'password_confirmation.required' => 'Confirm new password.',
            'password_confirmation.same' => 'Password does not match.',
        ];
    }

}
