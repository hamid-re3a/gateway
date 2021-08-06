<?php

namespace User\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

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
            'password' => 'required|regex:/' . getSetting('USER_REGISTRATION_PASSWORD_CRITERIA') . '/|confirmed',
        ];
    }

    public function messages()
    {
        return [

            'email.exists' => trans('user.validation.email-not-exists'),
            'email.required' => trans('user.validation.email-required'),
            'password.required' => trans('user.validation.first-name-required'),
            'email.email' => trans('user.validation.email-is-incorrect'),
            'otp.exists' => trans('user.responses.password-reset-code-is-invalid'),
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ( !Hash::check($this->password, $this->user()->password) ) {
                $validator->errors()->add('password', trans('user.responses.password-already-used-by-you-try-another-one'));
            }

            if(getSetting("USER_CHECK_PASSWORD_HISTORY_FOR_NEW_PASSWORD"))
                if(request()->user()->passwordHistoriesCheck($this->password))
                    $validator->errors()->add('password', trans('user.responses.password-already-used-by-you-try-another-one'));

        });
        return;
    }
}
