<?php

/** @var $breadcrumbs array */

?>
<div class="container">
    <ol class="breadcrumb">
        @foreach ($breadcrumbs as $name => $route)
            @if ($name)
                <li>
                    <a href="{{ $route }}">{{ $name }}</a>
                </li>
            @else
                <li class="active">
                    {{ $route }}
                </li>
            @endif
        @endforeach
    </ol>
</div>
