<?php
/** @var $layout \App\Models\Layout */
/** @var $errors array */
/** @var $menu array */
/** @var $title string */
/** @var $breadcrumbs string */

$title = __('layout.update') . ': ' . $layout->name;
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
        @include('layout._form', [
           'layout' => $layout,
        ])
    </div>
@endsection
