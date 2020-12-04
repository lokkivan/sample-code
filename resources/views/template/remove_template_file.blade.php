<?php
/** @var \App\Models\TemplateFile $templateFile */
/** @var $title string */
/** @var $menu array */
/** @var $breadcrumbs string */

$title = 'Удаление файл';
$menu = [
    [
        'title' => __('template.list'),
        'link' => route('template'),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
    [
        'title' => 'Параметры: ' . $templateFile->template->name,
        'link' => route('show_template', ['template' => $templateFile->template->id]),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') => route('home'),
    __('template.list') => route('template'),
    'Параметры: ' . $templateFile->template->name => route('show_template', ['template' => $templateFile->template->id]),
    $title,
];

?>
@extends('layouts.app')
@section('title', $title)

@section('content')
    <div class="container">
        <h1 class="text-center">{{ $title }}</h1>
        @include('utils.content_menu', [
            'menu' => $menu,
        ])
        {!! Form::open(['url' => route('destroy_template_file', ['templateFile' => $templateFile->id]), 'method' => 'delete']) !!}
        <div class="form-group">
            {!! Form::label('', __('template.remove_file_confirm')) !!}
            <div>
                {!! Form::submit(__('utils.delete'), ['class' => 'btn btn-primary'])  !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
