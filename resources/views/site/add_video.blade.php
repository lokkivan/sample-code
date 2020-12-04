<?php

/** @var $site \App\Models\Site */
/** @var $errors array */
/** @var $menu array */
/** @var $title string */
/** @var $breadcrumbs string */

$title = __('site.add_video') . ': ' . $site->domain_name;
$menu = [
    [
        'title' => __('site.show') . ': ' . $site->domain_name,
        'link' => route('show_site', ['site' => $site]),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') => route('home'),
    __('site.list') =>  route('site'),
    __('site.show') => route('show_site', ['site' => $site]),
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


        {!! Form::open([
            'url' => isset($action) ? $action : route('pick_video_site', ['site' => $site]),
            'enctype' => 'multipart/form-data',
            'method' => 'post',
            'class' => 'form-horizontal col-md-6',
        ]) !!}

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
            {!! Form::label(null,'Укажите категорию') !!}
            {!! Form::text('category', null, ['class' => 'form-control', 'required' => true,]) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Добавить', ['class' => 'btn btn-primary'])  !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection
