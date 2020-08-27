<?php

namespace App\services;

use App\Http\Requests\auth\RequestAuth;
use App\Interfaces\AuthInterface;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthInterface
{
    private $dispatcher;

    /**
     * RegisterService constructor.
     * @param Dispatcher $dispatcher - сообщает системе о регистрации нового пользователя
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Функция вызывает метод модели пользователя для создания записи в БД
     * @param RequestAuth $request - экземпляр http запроса от пользователя
     * @return mixed $user - объект пользователя
     */
    public function register($request)
    {
        $user = User::register(
            $request['login'],
            $request['password']
        );
        $this->dispatcher->dispatch(new Registered($user));
    }

    /**
     * Проверяет соответствие данных введенных пользователем
     * @param $request
     * @return bool
     */
    public function login($request)
    {
        $authenticate = Auth::attempt(
            $request->only(['login', 'password']),
            $request->filled('remember')
        );

        if ($authenticate) {
            $request->session()->regenerate();
            $user = Auth::user();
        }
        return $authenticate;
    }

    /**
     * Деавторизация пользователя
     * @param $request
     */
    public function logout($request)
    {
        Auth::guard()->logout();
        $request->session()->invalidate();
    }
}
