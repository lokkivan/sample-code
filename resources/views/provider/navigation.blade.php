<ul class="nav nav-tabs">
    <li role="presentation" class="{{ \Request::is('*/info') ? 'active' : '' }}">
        <a href="{{ route('all_video_provider', ['provider'=> $provider]) }}">Весь контент</a>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Управдение контентом<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li role="presentation" class="{{ \Request::is('*/info') ? 'active' : '' }}">
                <a href="{{ route('validate', ['provider' => $provider]) }}">Валидация контента</a>
            </li>
            <li role="presentation" class="{{ \Request::is('*/info') ? 'active' : '' }}">
                <a href="{{ route('remove_validation_provider', ['provider'=> $provider]) }}">Снять валидацию со всех видео</a>
            </li>
            <li role="presentation" class="{{ \Request::is('*/info') ? 'active' : '' }}">
                <a href="{{ route('remove_all_video_provider', ['provider'=> $provider]) }}">Удалить все видео от провайдера</a>
            </li>
        </ul>
    </li>
</ul>


