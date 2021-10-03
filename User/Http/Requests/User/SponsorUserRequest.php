<?php

namespace User\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SponsorUserRequest extends FormRequest
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
            'username' => ['required', 'unique:users,username', 'regex:/^[a-z][a-z0-9_]{2,}$/'],
            'birthday' => 'nullable|date|before:' . now() . '|date_format:Y/m/d',
        ];
    }

    public function messages()
    {
        return [
            'password_confirmation.same' => trans('user.validation.password-same'),
            'first_name.required' => trans('user.validation.first-name-required'),
            'last_name.required' => trans('user.validation.last-name-required'),
            'email.required' => trans('user.validation.email-required'),
            'email.unique:users' => trans('user.validation.email-unique'),
            'sponsor_username.regex' => trans('user.validation.sponsor-username-regex'),
            'sponsor_username.required' => trans('user.validation.sponsor-username-required'),
            'sponsor_username.exists' => trans('user.validation.sponsor-username-exists'),
            'sponsor_username.exists:users' => trans('user.validation.sponsor-username-exists'),
            'username.unique:users' => trans('user.validation.username-unique'),
            'username.required' => trans('user.validation.username-required'),
            'username.regex' => trans('user.validation.username-regex'),
            'password.required' => trans('user.validation.first-name-required'),
            'email.email' => trans('user.validation.email-is-incorrect'),
        ];
    }
}
