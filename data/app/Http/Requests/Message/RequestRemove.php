<?php

namespace App\Http\Requests\Message;

use Illuminate\Foundation\Http\FormRequest;

class RequestRemove extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'index' => 'required|integer',
        ];
    }
}
