<?php

/** @var \App\Models\Video $video */
/** @var \App\Models\Site $site */
/** @var $title string */
/** @var $menu array */
/** @var $breadcrumbs string */

$title = 'Добавить эти видео на сайт?';
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
        {!! Form::open(['url' => route('create_video_site', ['site' => $site]), 'method' => 'post']) !!}


            <div class="content-list">
                <div class="container">
                    <div class="row">
                        @foreach($pickVideo as $video)

                        <div class="col-lg-4">
                            <div class="thumb custom-thumb">
                                <img src="{{ \App\Helpers\VideoHelper::getDefaultThumb($video) }}" style="width:320px;height:250px;">
                            </div>
                            <p class="title">{{ $video->title }}</p>
                            <div class="form-group">
                                <p>Добавить: <input type="checkbox" name="video_id[]"  value="{{ $video->id }}" style="padding-left: 10px; width:30px;height:30px;" checked></p>

                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        <div class="form-group">
         {!! Form::submit('Добавить', ['class' => 'btn btn-primary'])  !!}

        </div>
        {!! Form::close() !!}
    </div>
@endsection
