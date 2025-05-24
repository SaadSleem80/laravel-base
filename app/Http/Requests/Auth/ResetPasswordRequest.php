<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *   schema="ResetPasswordRequest",
 *   required={"email" , "code", "password", "password_confirmation"},
 *   @OA\Property(property="email", type="string", maxLength=255, format="email"),
 *   @OA\Property(property="code", type="integer", minLength=6, maxLength=6),
 *   @OA\Property(property="password", type="string", minLength=8),
 *   @OA\Property(property="password_confirmation", type="string", minLength=8),
 * )
 */

class ResetPasswordRequest extends FormRequest
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
            'email'     => ['required', 'email', 'exists:users,email'],
            'code'      => ['required', 'integer', 'digits:6'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
