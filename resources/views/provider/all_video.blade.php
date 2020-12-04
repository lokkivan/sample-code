<?php

/** @var \App\Models\Provider $provider */
/** @var $title string */
/** @var $menu array */
/** @var $breadcrumbs string */

$title ="Видео от провайдера:" . $provider->name;
$menu = [
    [
        'title' => 'Настройки провайдера: ' . $provider->name,
        'link' => route('show_provider', ['provider' => $provider]),
        'visible' => \Auth::user()->can('index', \App\Models\Provider::class),
    ],
    [
        'title' => 'Валидация контента',
        'link' => route('validate', ['provider' => $provider]),
        'visible' => \Auth::user()->can('index', \App\Models\Provider::class),
    ],
];

$breadcrumbs = [
    __('utils.home') =>route('home'),
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
        <?= $grid->render() ?>
    </div>


@endsection
