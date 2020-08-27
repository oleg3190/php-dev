<?php

namespace Tests\Feature;

use App\Models\User;
use App\services\ChatService;
use Mockery;
use PHPUnit\Exception;
use Tests\TestCase;

class AuthTest extends TestCase
{
    private $password;
    private $user;
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->password = '012345Hello';
        $this->user = create(User::class,[
            'password'=> bcrypt($this->password)
        ]);
    }

    public function test_user_login()
    {
        $response = $this->call('post','login', [
            'password' => $this->password,
            'login' => $this->user->login,
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated($guard = null);
    }

    public function test_user_is_authenticated(){
        $this->actingAs($this->user)
            ->get('/');
        $this->assertAuthenticated($guard = null);
    }

    public function test_user_logOut(){
        $this->actingAs($this->user)
            ->post('/logout');
        $this->assertGuest($guard = null);
    }

    public function test_user_bad_login_less_8(){
        $password = RandomPassword();
        $credentials = [
            'login'=>'Jo2',
            'password'=>$password,
            'password_confirmation'=>$password
        ];
        $this->call('POST', 'register',$credentials);
        $this->assertInvalidCredentials($credentials);
    }

    public function test_user_bad_login_not_upper_case(){
        $password = RandomPassword();
        $credentials = [
            'login'=>'john2019',
            'password'=>$password,
            'password_confirmation'=>$password
        ];
        $this->call('POST', 'register',$credentials);
        $this->assertInvalidCredentials($credentials);
    }

    public function test_user_bad_login_not_lower_case(){
        $password = RandomPassword();
        $credentials = [
            'login'=>'JOHN2019',
            'password'=>$password,
            'password_confirmation'=>$password
        ];
        $this->call('POST', 'register',$credentials);
        $this->assertInvalidCredentials($credentials);
    }

    public function test_user_bad_login_characters(){
        $password = RandomPassword();
        $credentials = [
            'login'=>'JOHNf2019@',
            'password'=>$password,
            'password_confirmation'=>$password
        ];
        $this->call('POST', 'register',$credentials);
        $this->assertInvalidCredentials($credentials);
    }

    public function test_user_cannot_login_with_incorrect_login()
    {
        $response = $this->from('/login')->post('/login', [
            'password' => $this->user->password,
            'login' => 'user1234',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('error');
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function test_user_cannot_login_with_incorrect_password()
    {
        $response = $this->from('/login')->post('/login', [
            'login' => $this->user->login,
            'password' => 'invalid',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('error');
        $this->assertTrue(session()->hasOldInput('login'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
}
