<?php

namespace User\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLoginAttemptSettingRequest extends FormRequest
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
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:login_attempt_settings,id',
            'times' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1',
            'priority' => 'required|integer|min:1|unique:login_attempts,priority',
            'blocking_duration' => 'required|integer|min:1',
        ];
    }
}
