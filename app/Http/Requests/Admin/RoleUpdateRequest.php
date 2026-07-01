<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
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
        // گرفتن ایدی نقشی که در آدرس url قرار دارد
        $roleId = $this->route('role')->id;

        return [
            'name' => ['required','unique:roles,name,'. $roleId],
            // nullable  برای اینکه ادمین ممکنه دسترسی نقش ها رو هیچ کدوم تیک نزده باشه بهش میگیم اشکال نداره قبول کن
            'permissions' => ['nullable','array']
        ];
    }
}
