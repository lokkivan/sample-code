<?php

/** @var $layouts \App\Models\Layout[] */
/** @var $siteTemplate \App\Models\SiteTemplate */

?>

<table class="table table-bordered table-striped table-hovered">
    <tbody>
        <tr>
            <td>Шаблона сайта</td>
            <td>Обзор</td>
        </tr>
            <tr>
                <td>{{ $siteTemplate->name }}</td>
                <td>
                    <a href="{{ route('site_template_show', ['siteTemplate' => $siteTemplate->id]) }}"
                       target="_blank"
                       class="glyphicon glyphicon-search"></a>
                </td>
            </tr>

    </tbody>
</table>
