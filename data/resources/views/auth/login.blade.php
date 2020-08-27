@extends('layouts.app')

@section('main_content')
<div class="container">
    <div class="form-signin">
        @if($errors->count()>0)
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                @foreach($errors->all() as $error)
                <strong>Ошибка!</strong> {{$error}} <br>
                @endforeach
            </div>
        @endif
    <form  method="POST" action="{{ route('login') }}">
        @csrf
        <h2 class="form-signin-heading">Авторизация</h2>

        <label for="user_login" class="sr-only">Логин</label>
        <input type="text" id="user_login" name="login" class="form-control" placeholder="Логин" required autofocus>

        <label for="user_password" class="sr-only">Пароль</label>
        <input name="password" type="password" id="user_password" class="form-control" placeholder="Пароль" required>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember" id="remember" value="remember-me" > Запомнить меня
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
    </form>
    </div>
</div>
@endsection
