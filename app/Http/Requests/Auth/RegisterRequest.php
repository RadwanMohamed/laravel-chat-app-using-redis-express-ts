<?php

namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'phone' => ['required', 'regex:/^(02|01)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/', 'unique:users,phone'],
            'password' => ['required', 'min:8', 'confirmed', Rules\Password::defaults()]
        ];
    }

}
