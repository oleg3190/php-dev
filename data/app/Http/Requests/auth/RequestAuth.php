<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class RequestAuth extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $preg = preg_match('/[\\\~^°!\"§$%\/()=?`\';,\.:_{\[\]}\|<>№&@+#а|б|в|г|д|е|ё|ж|з|и|ё|к|л|м|н|о|п|р|с|т|у|ф|х|ц|ч|ш|щ|ъ|ы|ь|э|ю|я]/',$this->login);
        if($preg){
            $validator = validator([], []);
            $validator->errors()->add('login', 'Логин содержит запрещенные символы');
            throw new ValidationException($validator);
        }
        $this->validate([
            'password' =>
                array(
                    'required',
                    'regex:/([a-z]+[A-Z]+[0-9]+|[a-z]+[0-9]+[A-Z]+|[A-Z]+[a-z]+[0-9]+|[A-Z]+[0-9]+[a-z]+|[0-9]+[a-z]+[A-Z]+|[0-9]+[A-Z]+[a-z]+)/'
                )
            ,
            'login' =>
                array(
                    'required',
                    'regex:/^(?=^.{1,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/',
                ),
        ],[
            'password.regex' => 'Пароль должен состоять из символов (верхнего и нижнего регистра) и цифр',
            'login.regex' => 'Логин должен состоять из латинских символов (одной буквы верхнего и нижнего регистра) и цифр по желанию',

        ]);
        return [
            'login' => 'required|string|max:255|min:8|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'password.confirmed' => 'Пароли должны совпадать',
            'login.max' => 'Логин должен быть не больше 256 символов',
            'password.min' => 'Пароль должен быть не меньше 6 символов',
            'login.min' => 'Логин должен быть не меньше 8 символов',
            'login.unique' => 'Такой логин уже существует',
        ];
    }
}
