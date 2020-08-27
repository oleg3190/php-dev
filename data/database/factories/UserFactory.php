<?php

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/** @var EloquentFactory $factory */
$factory->define(User::class, function (Faker $faker) {
    return [
        'login' => $faker->unique()->firstName().$faker->randomNumber(),
        'password' => 'aA20182018ff45ttt', // secret
        'remember_token' => rand(10,11),
        'role'=> $faker->randomElement([User::ROLE_USER, User::ROLE_ADMIN])
    ];
});
/*
function generateRandomString($length = 3) {
    $numbers = '0123456789';
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';

    $numbersLength = strlen($numbers);
    $lowercaseLength = strlen($lowercase);
    $uppercaseLength = strlen($uppercase);

    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $numbers[rand(0, $numbersLength - 1)];
        $randomString .= $uppercase[rand(0, $uppercaseLength - 1)];
        $randomString .= $lowercase[rand(0, $lowercaseLength - 1)];
    }
    return bcrypt($randomString);
}
*/