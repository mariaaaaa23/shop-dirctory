<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariationRequest extends FormRequest
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
            'color_name' => ['required','string'],
            'color_code' => ['nullable','string'],
            'price' => ['required','numeric'],
            'image' => ['nullable','image','mimes:png,jpg,jpeg'],
            'stock' => ['required','integer']
        ];
    }
}
