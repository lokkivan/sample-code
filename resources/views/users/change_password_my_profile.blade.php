<?php
/** @var $model \App\Models\User */
/** @var @errors array */
/** @var $title string */
/** @var $breadcrumbs string */

$title = 'Изменить пароль';
$breadcrumbs = [
    __('utils.home') => route('home'),
    'Мой профиль' => route('my_profile'),
    $title,
];

?>
@extends('layouts.app')
@section('title', $title)

@section('content')
    <div class="container">
        <h1 class="text-center">{{ $title }}</h1>
        {!! Form::open(['url' => route('my_profile_store_password'), 'method' => 'put']) !!}
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
                {!! Form::label('password', 'Пароль') !!}
                {!! Form::password('password', ['class' => 'form-control', 'required' => true,]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('repeat_password', 'Повторите пароль') !!}
                {!! Form::password('repeat_password', ['class' => 'form-control', 'required' => true,]) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Сохранить', ['class' => 'btn btn-primary'])  !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection
