<?php

namespace App\services;


use App\Interfaces\ChatInterface;
use App\Models\Message;
use App\Events\Message as Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Broadcasting\Channel;

class ChatService implements  ChatInterface
{
    public function getAll($request = null){

        $messages = Message::orderBy('id','desc')->paginate(5);
        if($messages->count()){
            $messages->map(function($val){
                if(is_object($val->user)){
                    $val->author = $val->user->login;
                    unset($val->user);
                }
            });
        }
        return $messages;
    }

    /**
     * Создает запись в БД и на стене сообщений
     * @param $data
     */
    public function create($data){
        $message = Message::create($data);
        if($message){
            Chat::dispatch([
                'id'    => $message->id,
                'text'  => $message->text,
                'author'=> $message->user->login,
                'action'=>'create'
            ]);
        }
    }

    public function remove($owner,$message,$index){

        if($this->checkSuccess($owner,$message)){
            $this->destroy($message,$index);
        }else{
            Chat::dispatch([
                'action'=>'error',
                'error'=> 'недостаточно прав'
            ]);
            return false;
        }
        return 200;
    }

    /**
     * Удаляет запись сообщения в БД и на стене сообщений
     * @var $message - модель
     * @param $index - индекс массива на стене сообщений
     */
    public function destroy($message,$index){
        $message->delete();
        Chat::dispatch([
            'action'=>'remove',
            'index'=> $index
        ]);
    }

    /**
     * Проверяет соответствие прав автора
     * @param $owner
     * @param $message
     * @return bool
     */
    private function isAuthor($owner,$message){
        return $message->user_from == $owner;
    }

    private function checkSuccess($owner,$message){
        return $this->isAuthor($owner,$message) || $this->isAdmin();
    }

    /**
     * Проверяет соответствие прав админа
     * @return mixed
     */
    private function isAdmin(){
        return Auth::user()->isAdmin();
    }
}
