<?php

/** @var $grid \Nayjest\Grids\Grid */
/** @var $menu array */
/** @var $title string */
/** @var $breadcrumbs string */

$title = 'Не валидные';
$menu = [

];

$breadcrumbs = [
    __('utils.home') => route('home'),
    'Все валидные теги' => route('tags'),
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
        <?= $grid->render() ?>
    </div>
@endsection

