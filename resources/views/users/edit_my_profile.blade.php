<?php

/** @var $model \App\Models\User */
/** @var $errors array */
/** @var $title string */
/** @var $breadcrumbs string */

$title = 'Изменить мой профиль';
$breadcrumbs = [
    __('utils.home') =>route('home'),
    'Мой профиль' => route('my_profile'),
    'Изменить мой профиль',
];

?>
@extends('layouts.app')
@section('title', $title)

@section('content')
    <div class="container">
        <h1 class="text-center">{{ $title }}</h1>
        @include('users._form', [
            'action' => route('my_profile_update'),
            'model' => $model,
            'errors' => $errors,
            'my_profile' => true,
        ])
    </div>
@endsection
