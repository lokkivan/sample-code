<?php

/** @var $provider \App\Models\Provider  */
/** @var $menu array */
/** @var $title string */
/** @var $breadcrumbs string */

$title = $provider->name;
$menu = [
    [
        'title' => __('provider.list'),
        'link' => route('provider'),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') =>route('home'),
    __('provider.list') =>route('provider'),
    $title,
];

?>
@extends('layouts.app')
@section('title', $title)

@section('content')
    <div class="container">
        <h3 class="text-center">{{ $title }}</h3>
        @include('utils.content_menu', [
            'menu' => $menu,
        ])
        <div class="list-view">

            @include('provider.navigation', [
            'provider' => $provider,
             ])

            <table class="table table-striped table-bordered table-hover">
                <tr>
                    <th>Аттрибут</th>
                    <th>Значение</th>
                </tr>
                <tr>
                    <td>@lang('provider.id')</td>
                    <td>{{ $provider->id }}</td>
                </tr>


                <tr>
                    <td>@lang('provider.name')</td>
                    <td>{{ $provider->name }}</td>
                </tr>

                <tr>
                    <td>Количество контента</td>
                    <td>{{ count($allProviderVideo) }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection