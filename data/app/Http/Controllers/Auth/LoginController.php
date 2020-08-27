<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\RequestLogin;
use App\Interfaces\AuthInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    protected $redirectTo = '/';
    private $service;

    public function __construct(AuthInterface $service)
    {
        $this->service = $service;
        $this->middleware('guest')->except('logout');
    }

    /**
     * Отображает форму авторизации
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
{
    return view('auth.login');
}

    /**
     * Вызывает метод авторизации
     * @param RequestLogin $request - login,password
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException - ловит ошибки авторизации
     */
    public function login(RequestLogin $request)
{
    $authenticate = $this->service->login($request);
    if($authenticate){
        return redirect()->intended(route('home'));
    }
    throw ValidationException::withMessages(['error' => 'Вход в систему с указанными данными невозможен']);
}

    /**
     * Вызывает метод деавторизации
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $this->service->logout($request);
        return redirect()->route('home');
    }
}
