<?php

namespace App\Http\Requests\Api\Contest;

use Illuminate\Foundation\Http\FormRequest;

class ImportDataRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'steps' => 'required|integer|min:0',
            'device_source' => 'required|integer|in:1,2,3',
            'recorded_at' => 'required|date_format:Y-m-d H:i',
        ];
    }
}