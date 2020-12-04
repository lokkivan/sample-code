<?php

/** @var $site \App\Models\Site */
/** @var $errors array */
/** @var $menu array */
/** @var $title string */

$title = __('site.update') . ': ' . $site->domain_name;
$menu = [
    [
        'title' => __('site.list'),
        'link' => route('site'),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') => route('home'),
    __('site.list') =>  route('site'),
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
        @include('site._form', [
           'site' => $site,
        ])
    </div>
@endsection
