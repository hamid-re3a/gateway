<?php

namespace User\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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

    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'min:1', 'max:255', 'regex:/^[a-zA-Z ]*$/'],
            'last_name' => ['required', 'string', 'min:1', 'max:255', 'regex:/^[a-zA-Z ]*$/'],
            'email' => 'required|string|email|max:255|unique:users',
            /** username can contain alphabet, underline and digits */
            'username' => ['required', 'unique:users', 'regex:/^[a-z][a-z0-9_]{2,}$/'],
            'password' => ['required', 'regex:/'.getSetting('USER_REGISTRATION_PASSWORD_CRITERIA').'/'],
            'password_confirmation' => 'required|string|same:password',
        ];
    }

}
