<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "LoginRequest",
    required: ["login", "password"],
    properties: [
        new OA\Property(property: "login", type: "string", example: "test1", description: "Username or Email"),
        new OA\Property(property: "password", type: "string", format: "password", example: "12345678")
    ]
)]
class LoginRequest extends FormRequest
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
            'login' => 'required|string',
            'password' => 'required|string',
        ];
    }
}
