<?php

namespace App\Http\Controllers;
use App\Http\Requests\Message\RequestBoard;
use App\Interfaces\ChatInterface;

class HomeController extends Controller
{

    public $service;
    public function __construct(ChatInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Выводит страницу c формой отправки сообщения
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
       return view('welcome');
    }

    /**
     * * При прокрутке стены отдает сообщения
     * @param RequestBoard $request ?page - id страницы
     * @return \Illuminate\Http\JsonResponse
     */
    public function index_infinite(RequestBoard $request)
    {
        $messages = $this->service->getAll($request);
        return response()->json($messages,200);
    }
}
