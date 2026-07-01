<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NewProductRequest extends FormRequest
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
            'slug' => ['required','unique:products,slug','alpha_dash'],
            'cost' => ['required','min:1000','integer'],
            'image' => ['required','mimes:png,jpg,jpeg,mpeg','min:5','max:2048'],
            'description' => ['required'],
            'city_id' => ['required','exists:cities,id'],
        ];
    }
}
