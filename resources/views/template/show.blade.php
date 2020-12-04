<?php

/** @var $template \App\Models\Template  */
/** @var $menu array */
/** @var $title string */
/** @var $breadcrumbs string */

$title = $template->name;
$menu = [
    [
        'title' => __('template.list'),
        'link' => route('template'),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
    [
        'title' => __('template.update'),
        'link' => route('edit_template', ['template' => $template]),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') =>route('home'),
    __('template.list') =>route('template'),
    $title,
];

?>
@extends('layouts.app')
@section('title', $title)

@section('content')
    <div class="container">
        <h3 class="text-center">{{ $title }}</h3>
        @include('utils.content_menu', [
            'menu' => $menu,
        ])
        <div class="list-view">

            @include('template.navigation', [
            'template' => $template,
             ])

            <table class="table table-striped table-bordered table-hover">
                <tr>
                    <th>Аттрибут</th>
                    <th>Значение</th>
                </tr>
                <tr>
                    <td>@lang('template.id')</td>
                    <td>{{ $template->id }}</td>
                </tr>
                <tr>
                    <td>@lang('template.name')</td>
                    <td>{{ $template->name }}</td>
                </tr>
            </table>

            @if(count($template->templateFiles) > 0)
                <h5>Загруженные файлы</h5>
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>Путь</th>
                        <th>Тип</th>
                        <th>Скачать</th>
                        <th>Удалить?</th>

                    </tr>
                    @foreach($template->templateFiles as $file)
                        <tbody>
                        <tr class='cart-item-1'>
                            <td>
                                <strong>{{ $file->file_name }}</strong>
                            </td>
                            <td>
                                <strong>{{ \App\Helpers\TemplateFileHelper::getFileType($file->file_name) }}</strong>
                            </td>
                            <td>
                                <a href="{{ route('download_template_file', ['templateFiles' => $file->id]) }}"
                                   class="glyphicon glyphicon-download-alt"></a>
                            </td>
                            <td>
                                <a href="{{ route('remove_template_file', ['templateFiles' => $file->id]) }}"
                                   class="glyphicon glyphicon-remove"></a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>
@endsection
