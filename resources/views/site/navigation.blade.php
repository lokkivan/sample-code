<ul class="nav nav-tabs">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Управление контентом<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ route('all_video_site', ['site'=> $site]) }}">Все видео</a>
            </li>
            <li>
                <a href="{{ route('add_video_to_site', ['site'=> $site]) }}">Добавить видео</a>
            </li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Настройка внешнего вида<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ route('components_site', ['site'=> $site]) }}">Настройка компонентов сайта</a>
            </li>
            <li>
                <a href="{{ route('show_maket_site', ['site'=> $site]) }}">Макет сайта(пока не работает)</a>
            </li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Синхронизация<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ route('get_puclic_key_site', ['site'=> $site]) }}">Получить ключ</a>
            </li>
            <li>
                <a href="{{ route('get_feedback_site', ['site'=> $site]) }}">Получить сообщения</a>
            </li>
        </ul>
    </li>
    <li role="presentation" class="{{ \Request::is('*/info') ? 'active' : '' }}">
        <a href="{{ route('custom_values_site', ['site'=> $site]) }}">Кастомные значения</a>
    </li>
</ul>


