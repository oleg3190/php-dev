<?php

namespace App\Http\Requests\Message;

use Illuminate\Foundation\Http\FormRequest;

class RequestBoard extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'page' => 'required|integer',
        ];
    }
}
