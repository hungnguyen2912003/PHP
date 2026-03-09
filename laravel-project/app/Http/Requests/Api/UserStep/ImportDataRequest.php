<?php

namespace App\Http\Requests\Api\UserStep;

use Illuminate\Foundation\Http\FormRequest;

class ImportDataRequest extends FormRequest
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
            'device_source'      => ['required', 'integer', 'in:1,2,3'],
            'logs'               => ['required', 'array', 'min:1'],
            'logs.*.steps'       => ['required', 'integer', 'min:0'],
            'logs.*.recorded_at' => ['required'],
        ];
    }
}
