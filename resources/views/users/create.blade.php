<?php

/** @var $model \App\Models\User */
/** @var $errors array */
/** @var $title string */
/** @var $menu array */
/** @var $breadcrumbs string */

$title = 'Создать нового пользователя';
$menu = [
    [
        'title' => 'Список пользователей',
        'link' => route('users'),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') =>route('home'),
    'Список пользователей' => route('users'),
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
