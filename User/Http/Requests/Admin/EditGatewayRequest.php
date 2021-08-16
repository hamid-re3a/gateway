<?php

namespace User\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EditGatewayRequest extends FormRequest
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
            'service_id' => 'required|exists:gateway_services,id',
            'name' => 'required|string|min:2',
            'doc_point' => 'required|string',
            'just_current_routes' => 'required|boolean',
            'domain' => 'required|string',
        ];
    }
}
