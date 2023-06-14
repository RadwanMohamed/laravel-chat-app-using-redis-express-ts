<?php

namespace App\Http\Requests\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator as ValidationValidator;

class LoginRequest extends FormRequest
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
            'phone' => ['required','regex:/^(02|01)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/'],
            'password' => ['required', 'min:8'],
        ];
    }

    /**
     * Throw exception for validation failed.
     *
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return \Illuminate\Validation\ValidationException
     */
    protected function validationFailed(ValidationValidator $validator): ValidationException
    {
        throw new ValidationException($validator, new JsonResponse([
            'message' => __('auth.invalid_credentials'),
            'errors' => $validator->errors()
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
