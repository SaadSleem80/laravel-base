<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="RegisterRequest",
 *     required={"name", "email" , "password" , "password_confirmation"},
 *     @OA\Property(property="name", type="string", maxLength=255),
 *     @OA\Property(property="email", type="string", maxLength=255, format="email"),
 *     @OA\Property(property="password", type="string", minLength=8),
 *     @OA\Property(property="password_confirmation", type="string", minLength=8),
 * )
 */

class RegisterRequest extends FormRequest
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
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
