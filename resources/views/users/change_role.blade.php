<?php
/** @var $model \App\Models\User */
/** @var $roles array */
/** @var $errors array */
/** @var $title string */
/** @var $menu array */
/** @var $breadcrumbs string */

$title = 'Изменить роль пользователя ' . $model->email;
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
    'Пользователь: ' . $model->email => route('show_user', ['user' => $model->id]),
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
        {!! Form::open(['url' => route('store_role_user', ['user' => $model->id]), 'method' => 'put']) !!}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-group">
                {!! Form::label('role', 'Роль') !!}
                {!! Form::select('role', $roles, $model->role, ['class' => 'form-control', 'required' => true]) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Сохранить', ['class' => 'btn btn-primary'])  !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection
