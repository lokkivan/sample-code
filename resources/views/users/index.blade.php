<?php

/** @var $grid \Nayjest\Grids\Grid */
/** @var $menu array */
/** @var $title string */
/** @var $breadcrumbs string */

$title = 'Список пользователей';
$menu = [
    [
        'title' => 'Создать нового пользователя',
        'link' => route('create_user'),
        'visible' => \Auth::user()->can('create', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') =>route('home'),
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
