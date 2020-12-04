<?php
/** @var \App\Models\Feedback $feelback */
/** @var $title string */
/** @var $menu array */
/** @var $breadcrumbs string */

$title = 'Удаление сообщение';
$menu = [
    [
        'title' => __('feedback.list'),
        'link' => route('feedback'),
        'visible' => \Auth::user()->can('index', \App\Models\Feedback::class),
    ],
];
$breadcrumbs = [
    __('utils.home') => route('home'),
    __('feedback.list') =>route('feedback'),
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
        {!! Form::open(['url' => route('destroy_feedback', ['feedback' => $feedback]), 'method' => 'delete']) !!}
        <div class="form-group">
            {!! Form::label('', __('feedback.remove_confirm')) !!}
            <div>
                {!! Form::submit(__('utils.delete'), ['class' => 'btn btn-primary'])  !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
