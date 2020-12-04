<?php

/** @var $layouts \App\Models\Layout[] */

?>

<table class="table table-bordered table-striped table-hovered">
    <tbody>
        <tr>
            <td>ID</td>
            <td>Тип</td>
            <td>Название</td>
            <td>Удалить?</td>
        </tr>
        @foreach ($layouts as $layout)
            <tr>
                <td>{{ $layout->id }}</td>
                <td>{{ $layout->type }}</td>
                <td>{{ $layout->name }}</td>
                <td>

                    <a href="{{ route('site_remove_layout', ['sitee' => $site, 'layout' => $layout->id]) }}"
                        class="glyphicon glyphicon-remove"></a>

                        <a href="{{ route('show_layout', ['layout' => $layout->id]) }}" target="_blank">
                            <button> Настройки блока </button>
                        </a>

                </td>
            </tr>
        @endforeach
    </tbody>
</table>
