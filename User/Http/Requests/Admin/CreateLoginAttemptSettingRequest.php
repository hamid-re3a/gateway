<?php

namespace User\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateLoginAttemptSettingRequest extends FormRequest
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
            'times' => 'required|unique:login_attempt_settings,times',
            'duration' => 'required|integer',
            'priority' => 'nullable|integer',
            'blocking_duration' => 'required|integer',
        ];
    }
}
