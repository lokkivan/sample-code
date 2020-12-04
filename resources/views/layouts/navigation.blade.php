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

                @can ('index', \App\Models\User::class)
                    <li>
                        <a href="{{ route('users') }}">Пользователи</a>
                    </li>
                @endcan

                @can ('index', \App\Models\Site::class)
                    <li>
                        <a href="{{ route('site') }}">Сайты</a>
                    </li>
                @endcan

                @can ('index', \App\Models\Site::class)
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Компонетны сайтов<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('template') }}">Шаблоны</a>
                            </li>
                            <li>
                                <a href="{{ route('layout') }}">Блоки</a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can ('index', \App\Models\Provider::class)
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Провайдеры<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('provider') }}">Все провайдеры</a>
                        </li>

                        <li>
                            <a href="{{ route('categories') }}">Категории</a>
                        </li>

                        <li>
                            <a href="{{ route('tags') }}">Теги</a>
                        </li>
                        </ul>
                    </li>
                @endcan
                @can ('index', \App\Models\Feedback::class)
                    <li>
                        <a href="{{ route('feedback') }}">Обратная связь</a>
                    </li>
                @endcan

                <li>
                    <a href="{{ url('logout') }}">Выйти</a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>