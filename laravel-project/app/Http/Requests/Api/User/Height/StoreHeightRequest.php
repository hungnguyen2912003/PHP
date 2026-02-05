<?php

namespace App\Http\Requests\Api\User\Height;

use Illuminate\Foundation\Http\FormRequest;

class StoreHeightRequest extends FormRequest
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
            'height' => 'required|numeric|min:0|max:300',
            'recorded_at' => 'required|date',
            'attachment_url' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }
}
