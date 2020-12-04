<?php

/** @var \App\Models\Video $video */
/** @var \App\Models\Site $site */
/** @var $title string */
/** @var $menu array */
/** @var $breadcrumbs string */

$title = 'Удаление видео : ' . $video->title;
$menu = [
    [
        'title' => 'Параметры сайта:' . $site->domain_name,
        'link' => route('show_site', ['site' => $site]),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
    [
        'title' => 'Все видео сайта:' . $site->domain_name,
        'link' => route('all_video_site', ['site' => $site]),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') => route('home'),
    __('site.list') =>route('site'),
    'Параметры сайта:' . $site->domain_name => route('show_site', ['site' => $site]),
    'Все видео сайта:' . $site->domain_name => route('all_video_site', ['site' => $site]),

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
        {!! Form::open(['url' => route('delete_video_from_site', ['site' => $site, 'video' => $video]), 'method' => 'delete']) !!}
        <div class="form-group">
            {!! Form::label('', 'Вы действительно хотите удалить данное видео?') !!}
            <div>
                {!! Form::submit(__('utils.delete'), ['class' => 'btn btn-primary'])  !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
