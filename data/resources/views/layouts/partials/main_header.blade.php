{{-- Main header --}}
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">Стена сообщений</a>
        </div>
        <ul class="nav navbar-nav">
            <li  class="{{(Request::path() == '/')? 'active':''}}">
                <a href="/">Главная</a></li>
            @guest
            <li  class="{{(Request::path() == 'login')? 'active':''}}">
                <a href="{{ route('login') }}">Авторизация</a></li>
            <li  class="{{(Request::path() == 'register')? 'active':''}}">
                <a href="{{ route('register') }}">Регистрация</a></li>
            @endguest
        </ul>

        @auth
        <ul class="nav navbar-nav navbar-right">
            <li class="navbar-text"><span class="glyphicon glyphicon-user"></span>{{Auth()->user()->login}}</li>
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                ><span class="glyphicon glyphicon-log-out"></span> Выход</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
        @endauth
    </div>
</nav>
