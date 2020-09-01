<?php

function create($class, $attributes = [], $times = null)
{
    return factory($class, $times)->create($attributes);
}

function make($class, $attributes = [], $times = null)
{
    return factory($class, $times)->make($attributes);
}

function RandomPassword($length = 3) {
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
