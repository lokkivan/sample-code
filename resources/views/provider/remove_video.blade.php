<?php

/** @var \App\Models\Video $video */
/** @var $title string */
/** @var $menu array */
/** @var $breadcrumbs string */

$title = 'Удаление видео от провайдера: ' . $video->provider->name;
$menu = [
    [
        'title' => __('provider.list'),
        'link' => route('provider'),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
    [
        'title' => 'Настройки провайдера: ' . $video->provider->name,
        'link' => route('show_provider', ['provider' => $video->provider]),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
    [
        'title' => 'Все видео от: ' . $video->provider->name,
        'link' => route('all_video_provider', ['provider' => $video->provider]),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') => route('home'),
    __('provider.list') => route('provider'),
    'Настройки провайдера: ' .  $video->provider->name => route('show_provider', ['provider' =>  $video->provider]),
    'Все видео от: ' . $video->provider->name => route('all_video_provider', ['provider' => $video->provider]),
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
        {!! Form::open(['url' => route('delete_video', ['video' => $video]), 'method' => 'delete']) !!}
        <div class="form-group">
            {!! Form::label('', 'Вы действительно хотите удалить данное видео?') !!}
            <div>
                {!! Form::submit(__('utils.delete'), ['class' => 'btn btn-primary'])  !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
