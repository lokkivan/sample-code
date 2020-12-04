<?php

/** @var \App\Models\User $model */
/** @var $menu array */
/** @var $title string */
/** @var $breadcrumbs string */

$title = 'Пользователь' . ': ' . $model->email;
$menu = [
    [
        'title' => 'Список пользователей',
        'link' => route('users'),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
    [
        'title' => __('user.update_user'),
        'link' => route('edit_user', ['user' => $model->id]),
        'visible' => \Auth::user()->can('update', $model),
    ],
    [
        'title' => __('user.change_password'),
        'link' => route('change_password_user', ['user' => $model->id]),
        'visible' => \Auth::user()->can('changePassword', $model),
    ],
    [
        'title' => 'Изменить роль пользователя',
        'link' => route('change_role_user', ['user' => $model->id]),
        'visible' => \Auth::user()->can('changeRole', $model),
    ],
    [
        'title' => __('user.remove_user'),
        'link' => route('remove_user', ['user' => $model->id]),
        'visible' => \Auth::user()->can('delete', $model),
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
        @include('utils.model_view', [
            'model' => $model,
            'fields' => ['id', 'email', 'name', 'role'],
            'intl_file' => 'user',
        ])
    </div>
@endsection