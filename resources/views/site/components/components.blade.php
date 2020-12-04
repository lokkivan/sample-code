<?php

/** @var $site \App\Models\Site  */
/** @var $menu array */
/** @var $title string */
/** @var $breadcrumbs string */
/** @var $layoutsByType array */

$title = 'Настройка компонентов сайта: ' . $site->name;
$menu = [
    [
        'title' => 'Параметры сайта'. $site->name,
        'link' => route('show_site', ['site' => $site]),
        'visible' => \Auth::user()->can('index', \App\Models\Site::class),
    ],
];
$breadcrumbs = [
    __('utils.home') => route('home'),
    __('site.list') =>route('site'),
    'Параметры сайта'. $site->name => route('show_site', ['site' => $site]),
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
            <table class="table table-striped table-bordered table-hover">
                <tr>

                @if (!empty($site->template))
                        @include('site.components._templat-list', ['template' => $site->template, 'site' => $site])
                @else
                    {!! Form::open(['url' => route('site_add_template', ['site' => $site]), 'class' => 'form-horizontal col-md-6']) !!}
                        <p>Шаблон не задан!</p>
                        <div class="form-group">

                            {!! Form::select('template', $templates, null, ['class' => 'form-control', 'placeholder' => 'Выберите шаблон']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Задать шаблон', ['class' => 'btn btn-primary']) !!}
                        </div>
                    {!! Form::close() !!}
                @endif

                </tr>
            </table>
        </div>

        <p>Блоки</p>
        @if (count($site->layouts) > 0)
            @include('site.components._layouts-list', ['layouts' => $site->layouts, 'site' => $site])
        @endif


        @if (!empty($layoutsByType))
            <div class="">
                {!! Form::open(['url' => route('site_add_layouts', ['site' => $site]), 'class' => 'form-horizontal col-md-6']) !!}
                @foreach ($layoutsByType as $type => $layouts)
                    <div class="form-group">
                        <p>Тип: {{ $type }}</p>
                        {!! Form::select('layouts[]', $layouts, null, ['class' => 'form-control', 'placeholder' => 'Выберите блок']) !!}
                    </div>
                @endforeach
                <div class="form-group">
                    {!! Form::submit('Добавить', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        @endif
    </div>
@endsection