<?php

/** @var $layout \App\Models\Layout  */
/** @var $menu array */
/** @var $title string */
/** @var $breadcrumbs string */

$title = $layout->name;
$menu = [
    [
        'title' => __('layout.list'),
        'link' => route('layout'),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
    [
        'title' => __('layout.update'),
        'link' => route('edit_layout', ['layout' => $layout]),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') =>route('home'),
    __('layout.list') =>route('layout'),
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

            @include('layout.navigation', [
            'layout' => $layout,
             ])

            <table class="table table-striped table-bordered table-hover">
                <tr>
                    <th>Аттрибут</th>
                    <th>Значение</th>
                </tr>
                <tr>
                    <td>@lang('layout.id')</td>
                    <td>{{ $layout->id }}</td>
                </tr>

                <tr>
                    <td>@lang('layout.type')</td>
                    <td>{{ $layout->type }}</td>
                </tr>

                <tr>
                    <td>@lang('layout.name')</td>
                    <td>{{ $layout->name }}</td>
                </tr>
            </table>

            @if(count($layout->layoutFiles) > 0)
                <h5>Загруженные файлы</h5>
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>Путь</th>
                        <th>Тип</th>
                        <th>Скачать</th>
                        <th>Удалить?</th>
                    </tr>
                    @foreach($layout->layoutFiles as $file)
                        <tbody>
                        <tr class='cart-item-1'>

                            <td>
                                <strong>{{ $file->file_name }}</strong>
                            </td>

                            <td>
                                <strong>{{ \App\Helpers\LayoutFileHelper::getFileType($file->file_name) }}</strong>
                            </td>

                            <td>
                                <a href="{{ route('download_layout_file', ['layoutFile' => $file->id]) }}"
                                   class="glyphicon glyphicon-download-alt"></a>
                            </td>

                            <td>
                                <a href="{{ route('remove_layout_faile', ['layoutFile' => $file->id]) }}"
                                   class="glyphicon glyphicon-remove"></a>
                            </td>
                        </tr>

                    @endforeach
                </table>
            @endif
        </div>
    </div>
@endsection