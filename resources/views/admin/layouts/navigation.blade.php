<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">Hub-Admin</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                @if (!\Auth::check())
                    <li class="{{ \Request::is('login') ? 'active' : '' }}">
                        <a href="{{ url('login') }}">Вход</a>
                    </li>
                @else
                <li class="{{ \Request::is('my-profile') ? 'active' : '' }}">
                    {{ link_to_route('my_profile', 'Мой профиль') }}
                </li>
                <li>
                    <a href="{{ url('logout') }}">Выйти</a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
