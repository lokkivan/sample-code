<?php

/** @var \App\Models\Provider $provider */
/** @var $title string */
/** @var $menu array */
/** @var $breadcrumbs string */

$title = 'Снять валидацию со всех не удаленных видео от : ' . $provider->name;
$menu = [
    [
        'title' => __('provider.list'),
        'link' => route('provider'),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
    [
        'title' => 'Настройки провайдера: ' . $provider->name,
        'link' => route('show_provider', ['provider' => $provider]),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') => route('home'),
    __('provider.list') => route('provider'),
    'Настройки провайдера: ' . $provider->name => route('show_provider', ['provider' => $provider]),
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
        {!! Form::open(['url' => route('delete_validation_provider', ['provider' => $provider]), 'method' => 'delete']) !!}
        <div class="form-group">
            {!! Form::label('', 'Вы действительно хотите снять валидацию со всех не удаленных видео от этого провайдера?') !!}
            <div>
                {!! Form::submit('Снять влидацию', ['class' => 'btn btn-primary'])  !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
