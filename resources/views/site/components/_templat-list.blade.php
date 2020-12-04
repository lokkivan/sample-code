<?php
/** @var $layouts \App\Models\Layout[] */
?>

<table class="table table-bordered table-striped table-hovered">
    <p>Шаблон</p>
    <tbody>
        <tr>
            <td>Название шаблона</td>
            <td>Настройки</td>
        </tr>

        <td>{{ $template->name }}</td>
        <td>
            <a href="{{ route('site_remove_template', ['sitee' => $site]) }}">
                <button>Изменить шаблон</button>
            </a>

            <a href="{{ route('show_template', ['template' => $template->id]) }}"
               target="_blank">
                <button> Настройки шаблона</button>
            </a>
        </td>

    </tbody>
</table>
