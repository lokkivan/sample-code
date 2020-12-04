<?php

/** @var $model \App\Models\User */
/** @var $errors array */
/** @var $menu array */
/** @var $title string */
/** @var $breadcrumbs string */

$title = 'Изменить пользователя: ' . $model->email;
$menu = [
    [
        'title' => 'Список пользователей',
        'link' => route('users'),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
    [
        'title' => 'Просмотр пользователя',
        'link' => route('show_user', ['user' => $model->id]),
        'visible' => \Auth::user()->can('view', $model),
    ],
];
$breadcrumbs = [
    __('utils.home') =>route('home'),
    'Список пользователей' => route('users'),
    'Пользователь' . ': ' . $model->email => route('show_user', ['user' => $model->id]),
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
        @include('users._form', [
            'model' => $model,
            'errors' => $errors,
        ])
    </div>
@endsection
