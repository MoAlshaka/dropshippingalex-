<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AffiliateProductCreate extends FormRequest
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
            'sku' => 'required|max:100',
            'title' => 'required|max:100',
            'brand' => 'required|max:100',
            'description' => 'required',
            'stock' => 'required|integer',
            'weight' => 'required|numeric',
            'minimum_selling_price' => 'required|numeric',
            'comission' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'country' => 'required|array',
            'country.*' => 'exists:countries,id',
            'image' => 'required|mimes:png,jpg',
        ];
    }
}
