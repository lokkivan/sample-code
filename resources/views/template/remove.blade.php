<?php
/** @var \App\Models\Template $template */
/** @var $title string */
/** @var $menu array */
/** @var $breadcrumbs string */

$title = 'Удаление шаблона';
$menu = [
    [
        'title' => __('template.list'),
        'link' => route('layout'),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') => route('home'),
    __('template.list') =>route('template'),
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
        {!! Form::open(['url' => route('destroy_template', ['template' => $template]), 'method' => 'delete']) !!}
        <div class="form-group">
            {!! Form::label('', __('template.remove_confirm')) !!}
            <div>
                {!! Form::submit(__('utils.delete'), ['class' => 'btn btn-primary'])  !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
