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
            'logs' => 'required|array|min:1',
            'logs.*.steps' => 'required|integer|min:0',
            'logs.*.source' => 'required|integer|in:1,2,3',
            'logs.*.recorded_at' => 'required|date_format:Y-m-d H:i',
        ];
    }
}