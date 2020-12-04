<?php

/** @var $provider \App\Models\Provider */
/** @var $errors array */
/** @var $menu array */
/** @var $title string */
/** @var $breadcrumbs string */

$title = __('provider.update') . ': ' . $provider->name;
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
        @include('provider._form', [
           'provider' => $provider,
        ])
    </div>
@endsection
