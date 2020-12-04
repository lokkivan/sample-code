<?php

/** @var $menu array */

$render = false;

foreach ($menu as $menuItem) {
    if ($menuItem['visible']) {
        $render = true;
    }
}
?>
@if ($render)
    <ul class="nav nav-tabs additional-menu">
        @foreach ($menu as $menuItem)
            @if ($menuItem['visible'])
                <li role="presentation">
                    <a href="{{ $menuItem['link'] }}">{{ $menuItem['title'] }}</a>
                </li>
            @endif
        @endforeach
    </ul>
@endif
