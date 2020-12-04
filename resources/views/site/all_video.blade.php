<?php

/** @var \App\Models\Site $site */
/** @var $grid \Nayjest\Grids\Grid */
/** @var $title string */
/** @var $menu array */
/** @var $breadcrumbs string */

$title ="Все видео:  " . $site->domain_name;
$menu = [
    [
        'title' => 'Параметры сайта',
        'link' => route('show_site', ['site' => $site]),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
    [
        'title' => 'Удалить все видео с сайта',
        'link' => route('remove_all_video_from_site', ['site' => $site]),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') =>route('home'),
    __('site.list') =>route('site'),
    __('site.show') . ":" . $site->domain_name =>route('show_site', ['site' => $site]),
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
