<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\auth\RequestAuth;
use App\Http\Controllers\Controller;
use App\Interfaces\AuthInterface;

class RegisterController extends Controller
{
    private $service;

    /**
     * RegisterController constructor.
     * @param AuthInterface $service - сервис выполняющий регистрацию пользователей
     */
    public function __construct(AuthInterface $service)
    {
        $this->middleware('guest');
        $this->service = $service;
    }

    /**
     * Отображает форму регистрации
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * @param RequestAuth $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected  function register(RequestAuth $request)
    {
        $this->service->register($request);
        return view('auth.success');
    }

}
