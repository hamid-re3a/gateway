<?php

namespace User\Http\Requests\User\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Merkeleon\PhpCryptocurrencyAddressValidation\Validation;
use Propaganistas\LaravelPhone\PhoneNumber;
use User\Models\Country;
use User\Models\CryptoCurrency;
use User\Models\User;

class UpdateContactDetails extends FormRequest
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
            'country_id' => 'bail|required|integer|exists:countries,id',
            'state_id' => 'nullable|integer|exists:cities,id,country_id,' . $this->get('country_id'),
            'city_id' => 'nullable|integer|exists:cities,id,country_id,' . $this->get('country_id') . ',parent_id,' . $this->get('state_id'),
            'mobile_number' => 'required|string|phone:' . $this->getCountryIso(),
            'landline_number' => 'required|string|phone:' . $this->getCountryIso(),
            'address_line1' => "nullable|string",
            'address_line2' => "nullable|string",

        ];
    }

    private function getCountryIso()
    {
        if($this->has('country_id')) {
            $country = Country::find($this->get('country_id'));
            if($country)
                return $country->iso2;
        }

        return null;
    }

}
