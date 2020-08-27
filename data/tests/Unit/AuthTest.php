<?php

namespace Tests\Unit;

use App\Interfaces\AuthInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    private $user;
    private $service;
    private $password = '1234John';

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->service = resolve(AuthInterface::class);
        $this->user = create(User::class,[
            'role'=> 'user',
            'password'=> bcrypt($this->password)
        ]);
    }

    public function testRegister(){
        $user = User::register(
            $login = 'login',
            $password = 'password'
        );
        self::assertNotEmpty($user);
        self::assertEquals($login, $user->login);
        self::assertNotEmpty($user->password);
        self::assertNotEquals($password, $user->password);
    }

}
