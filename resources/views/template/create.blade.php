<?php
/** @var $layout \App\Models\Layout */
/** @var $errors array */
/** @var $title string */
/** @var $menu array */
/** @var $breadcrumbs string */

$title = 'Создать шаблон';
$menu = [
    [
        'title' => __('template.list'),
        'link' => route('template'),
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
        @include('template._form', [
            'template' => $template,
        ])
    </div>
@endsection
