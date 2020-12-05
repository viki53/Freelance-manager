<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceItemCreateRequest extends FormRequest
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
            'label' => 'required|string',
            'description' => '',
            'quantity' => 'numeric',
            'item_type_id' => 'integer|exists:App\Models\ItemType,id',
            'unit_price' => 'numeric',
            'tax_rate_id' => 'integer|exists:App\Models\TaxRate,id',
        ];
    }
}
