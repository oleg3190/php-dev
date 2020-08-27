<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'role',
        'login',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

     const ROLE_USER = 'user';
     const ROLE_ADMIN = 'admin';

    /**
     * @return array ROLE:list
     */
    public static function rolesList()
    {
        return [
            self::ROLE_USER => 'User',
            self::ROLE_ADMIN => 'Admin',
        ];
    }

    /**
     * Проверяет права на админа
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }


    /**
     * Функция создает запись в базе данных
     * @param string $name - имя пользователя
     * @param string $password - пароль пользователя
     * @return mixed $user - объект пользователя
     */
    public static function register( $name, $password)
    {
        return static::create([
            'login' => $name,
            'role'=> User::ROLE_ADMIN,
            'password' => bcrypt($password),
        ]);
    }

    /**
     * Получает сообщения связанные с пользователем
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public  function messages(){
        return $this->belongsToMany(Message::class);
    }
}
