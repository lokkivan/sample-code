<?php
/** @var $feedback \App\Models\Feedback */
/** @var $errors array */
/** @var $menu array */
/** @var $title string */
/** @var $breadcrumbs string */

$title = __('feedback.update') . ': ' . $feedback->reply_email;
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
        @include('feedback._form', [
           'feedback' => $feedback,
        ])
    </div>
@endsection
