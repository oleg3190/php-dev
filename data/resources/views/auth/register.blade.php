@extends('layouts.app')

@section('main_content')
    <div class="container">
        <div class="form-signup">
            @if($errors->has('password') or $errors->has('login'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>{{ $errors->first('login')?:'' }}</strong><br>
                    <strong>{{ $errors->first('password')?:'' }}</strong><br>
                </div>
            @endif
            <form  method="POST" action="{{ route('register') }}">
                @csrf
                    <h2 class="form-signin-heading">Регистрация</h2>

                    <label for="user_login" class="sr-only">Логин</label>
                    <input type="text" id="user_login" name="login" class="form-control" placeholder="Логин" required autofocus>

                    <label for="user_password" class="sr-only">Пароль</label>
                    <input name="password" type="password" id="user_password" class="form-control" placeholder="Пароль" required>

                    <label for="user_password_repeat" class="sr-only">Повторите пароль</label>
                    <input name="password_confirmation" type="password" id="user_password_repeat" class="form-control" placeholder="Пароль (ещё раз)" required>

                    <button class="btn btn-lg btn-primary btn-block" type="submit">Зарегистрироваться</button>
            </form>
        </div>
    </div>
@endsection
