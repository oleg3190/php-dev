<?php

namespace App\Http\Requests\Message;

use Illuminate\Foundation\Http\FormRequest;

class RequestStore extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $this->text = htmlspecialchars($this->text);
        return [
            'text' => 'required|string|max:65535',
        ];
    }
}
