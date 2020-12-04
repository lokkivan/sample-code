<?php

/** @var \App\Models\User $model */
/** @var $title string */
/** @var $menu array */
/** @var $breadcrumbs string */

$title = __('user.remove_user') . ': ' . $model->email;
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
        {!! Form::open(['url' => route('destroy_user', ['user' => $model->id]), 'method' => 'delete']) !!}
            <div class="form-group">
                {!! Form::label('email', __('user.user_remove_confirm')) !!}
                <div>
                    {!! Form::submit(__('utils.delete'), ['class' => 'btn btn-primary'])  !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection
