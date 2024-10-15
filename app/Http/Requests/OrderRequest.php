<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id'=> 'required|string',
            'name'=> 'required|string',
            'address'=> 'required|array',
            'address.street'=> 'required|string',
            'address.city'=> 'required|string',
            'address.district'=> 'required|string',
            'price' => 'required|numeric',
            'currency' => 'required|string|in:TWD,USD,JPY,RMB,MYR',

        ];
    }

    public function messages(): array
    {
        return [
            'id.required'=> 'ID is required',
            'name.required'=> 'Name is required',
            'address.required'=> 'Address is required',
            'address.street.required'=> 'Street is required',
            'address.city.required'=> 'City is required',
            'address.district.required'=> 'District is required',
            'price.required' => 'Price is required',
            'currency.required' => 'Currency is required',
            'currency.in' => 'Currency must be TWD, USD, JPY, RMB, MYR',
        ];
    }
}
