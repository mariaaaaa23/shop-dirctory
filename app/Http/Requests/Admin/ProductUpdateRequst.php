<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequst extends FormRequest
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
            'category_id' => ['required','exists:categories,id'],
            'brand_id' => ['required','exists:brands,id'],
            'name' => ['required'],
            'slug' => ['required','alpha_dash'],
            'cost' => ['required','min:1000','integer'],
            'image' => ['nullable','mimes:png,jpg,jpeg,mpeg'],
            'description' => ['nullable'],
            'city_id' => ['required','exists:cities,id'],
            'status' => ['nullable','in:pending,approved,rejected'],

        ];
    }
}
