<?php
/** @var \App\Models\Layout $layout */
/** @var $title string */
/** @var $menu array */
/** @var $breadcrumbs string */

$title = 'Удаление layout';
$menu = [
    [
        'title' => __('layout.list'),
        'link' => route('layout'),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') => route('home'),
    __('layout.list') =>route('layout'),
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
        {!! Form::open(['url' => route('destroy_layout', ['layout' => $layout->id]), 'method' => 'delete']) !!}
        <div class="form-group">
            {!! Form::label('', __('layout.remove_confirm')) !!}
            <div>
                {!! Form::submit(__('utils.delete'), ['class' => 'btn btn-primary'])  !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
