<?php

/** @var \App\Models\Provider $provider */
/** @var $title string */
/** @var $menu array */
/** @var $breadcrumbs string */

$title = 'Удаление провайдера: ' . $provider->name;
$menu = [
    [
        'title' => __('provider.list'),
        'link' => route('provider'),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') => route('home'),
    __('provider.list') => route('provider'),
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
        {!! Form::open(['url' => route('destroy_provider', ['provider' => $provider]), 'method' => 'delete']) !!}
        <div class="form-group">
            {!! Form::label('', __('provider.remove_confirm')) !!}
            <div>
                {!! Form::submit(__('utils.delete'), ['class' => 'btn btn-primary'])  !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
