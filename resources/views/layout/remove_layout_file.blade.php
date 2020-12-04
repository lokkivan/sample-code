<?php
/** @var \App\Models\LayoutFile $layoutFile */
/** @var $title string */
/** @var $menu array */
/** @var $breadcrumbs string */

$title = 'Удаление файл';
$menu = [
    [
        'title' => __('layout.list'),
        'link' => route('layout'),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
    [
        'title' => 'Параметры: ' . $layoutFile->layout->name,
        'link' => route('show_layout', ['layout' => $layoutFile->layout->id]),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') => route('home'),
    __('layout.list') => route('layout'),
    'Параметры: ' . $layoutFile->layout->name => route('show_layout', ['layout' => $layoutFile->layout->id]),
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
        {!! Form::open(['url' => route('destroy_layout_faile', ['layoutFile' => $layoutFile->id]), 'method' => 'delete']) !!}
        <div class="form-group">
            {!! Form::label('', __('layout.remove_file_confirm')) !!}
            <div>
                {!! Form::submit(__('utils.delete'), ['class' => 'btn btn-primary'])  !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
