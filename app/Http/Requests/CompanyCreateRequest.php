<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return empty($this->user()->company);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'street_address' => 'required|string',
            'postal_code' => 'required|string|size:5',
            'city' => 'required|string',
            'country_code' => 'required|exists:App\Models\Country,code',
        ];
    }
}
