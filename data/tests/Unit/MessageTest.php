<?php

namespace Tests\Unit;


use App\Events\Message;
use App\Http\Controllers\Cabinet\MessageController;
use App\Http\Requests\Message\RequestBoard;
use App\Http\Requests\Message\RequestRemove;
use App\Interfaces\ChatInterface;
use App\Models\User;
use App\services\ChatService;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class MessageTest extends TestCase
{
    private $user;
    private $service;
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->service = resolve(ChatInterface::class);
        $this->user = create(User::class,[
            'role'=> 'user',
            'password'=> RandomPassword()
        ]);
    }

    public function test_get_messages(){
        $message = make(\App\Models\Message::class,[
            'user_from'=> $this->user->id
        ]);
        $messages = $this->service->getAll();
        $this->assertNotEmpty($messages);
    }

    public function testMessageCreate()
    {
        Event::fake();
        $request = RequestBoard::create('/cabinet/message/store', 'POST',[
            'user_from'=>$this->user->id,
            'text'=> 'Hello world!'
        ]);
        $this->service->create($request->except('_token'));
        Event::assertDispatched(Message::class, 1);
    }


    public function test_controller_message_destroy_user() {
        $message = make(\App\Models\Message::class,[
            'user_from'=>$this->user->id
        ]);
        $request = RequestRemove::create('/cabinet/message/destroy/'.$message->id, 'POST',[
            'owner'=>$this->user->id,
            'message'=>$message,
            'index'=>1
        ]);
        $chat = $this->getMockBuilder(ChatService::class)
            ->setMethods(['remove'])
            ->getMock();

        $chat->expects($this->once())
            ->method('remove')
            ->with($request->input('owner'),$message,$request->input('index'));

        $subject = new MessageController($chat);
        $subject->destroy($request,$message);
    }

    public function test_destroy_message() {
        Event::fake();
        $message = make(\App\Models\Message::class,[
            'user_from'=>$this->user->id
        ]);
        $this->service->remove($this->user->id,$message,1);
        Event::assertDispatched(Message::class, 1);
    }
}
