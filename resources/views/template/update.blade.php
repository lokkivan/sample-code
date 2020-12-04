<?php
/** @var $template \App\Models\Template */
/** @var $errors array */
/** @var $menu array */
/** @var $title string */
/** @var $breadcrumbs string */

$title = __('template.update') . ': ' . $template->name;
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
