<?php

namespace Tests\Feature;


use App\Events\Message;
use App\Http\Controllers\Cabinet\MessageController;
use App\Http\Controllers\HomeController;
use App\Http\Requests\Message\RequestBoard;
use App\Http\Requests\Message\RequestRemove;
use App\Http\Requests\Message\RequestStore;
use App\Interfaces\ChatInterface;

use App\Models\User;
use App\services\ChatService;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Redis;
use Mockery;
use Predis\Client;
use Tests\TestCase;

class MessageTest extends TestCase
{
    private $user;
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);


        $this->user = create(\App\Models\User::class,[
            'role'=> 'user',
            'password'=> RandomPassword()
        ]);
    }

    public function test_instance()
    {
        $instance = App::make(ChatInterface::class);
        $this->assertInstanceOf(ChatService::class, $instance);
    }

    public function test_get_messages(){
        $service = Mockery::mock(ChatService::class);
        app()->instance(ChatInterface::class, $service);

        $service->shouldReceive('getAll')->once();
        $response = $this->post('/messages?page=0');
        $response->assertStatus(200);
    }

    public function testMessageCreate()
    {
       Event::fakeFor(function () {
           $response = $this->actingAs($this->user)
                ->post('/cabinet/message/store',[
                    'user_from'=>$this->user->id,
                    'text'=> 'Hello world!'
                ]);
           $response->assertStatus(200);

           $this->assertDatabaseHas('messages', [
               'text'=>'Hello world!',
               'user_from'=> $this->user->id,
               "id"=> 1,
           ]);
           $e = Event::assertDispatched(Message::class);

           return $e;
        });
    }

    public function testMessageRemoveNotOwner(){

        $message = create(\App\Models\Message::class,[
            'user_from'=>999
        ]);
        $remove = $this->actingAs($this->user)
            ->post('/cabinet/message/destroy/'.$message->id,[
                'index'=>1,
                'owner'=>$this->user->id,
            ]);
        $remove->assertStatus(500);
    }

    public function testMessageRemoveAdmin(){

        $admin = create(User::class,['role'=>'admin']);
        $message = create(\App\Models\Message::class,[
            'user_from'=>$this->user->id
        ]);
        $remove = $this->actingAs($admin)
            ->post('/cabinet/message/destroy/'.$message->id,[
                'index'=>1,
                'owner'=>$this->user->id,
            ]);
        $remove->assertStatus(200);
    }

    public function testMessageRemoveOwner(){
        $this->actingAs($this->user)
            ->post('/cabinet/message/destroy/1',[
                'index'=>1,
                'owner'=>1,
            ]);
        $this->assertDatabaseMissing('messages',['text'=>'Hello word!','user_from'=> $this->user->id]);
    }

}

