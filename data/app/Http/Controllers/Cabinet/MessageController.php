<?php

namespace App\Http\Controllers\Cabinet;
use App\Http\Controllers\Controller;
use App\Http\Requests\Message\RequestRemove;
use App\Http\Requests\Message\RequestStore;
use App\Interfaces\ChatInterface;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public $service;
    public function __construct(ChatInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Создаёт запись сообщения в БД
     * @param RequestStore $request - user_from, text
     * @return \Illuminate\Http\JsonResponse $message - созданное сообщение
     */
    public function store(RequestStore $request){
        $this->service->create($request->except('_token'));
        return response()->json([],200);
    }

    /**
     * Вызывает в сервисе метод удаления сообщения
     * @param RequestRemove $request - owner id
     * @param Message $message - модель сообщения
     * @return \Illuminate\Http\JsonResponse status - 200
     */
    public function destroy(RequestRemove $request,Message $message){
       $success = $this->service->remove($request->owner,$message,$request->index);
       return response()->json([],$success ?? 500);
    }
}
