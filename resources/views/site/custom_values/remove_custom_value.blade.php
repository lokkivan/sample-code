<?php

/** @var \App\Models\SiteCustomValues $siteCustomValues */
/** @var $title string */
/** @var $menu array */
/** @var $breadcrumbs string */

$title = 'Удаление кастомного значения: ' . $siteCustomValues->name;
$menu = [
    [
        'title' => __('site.show'),
        'link' => route('show_site', ['site' => $siteCustomValues->site]),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
    [
        'title' => __('site.custom'),
        'link' => route('custom_values_site', ['site' => $siteCustomValues->site]),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') => route('home'),
    __('site.list') => route('site'),
    __('site.show') . ": " . $siteCustomValues->site->domain_name => route('show_site', ['site' => $siteCustomValues->site]),
    __('site.custom') => route('custom_values_site', ['site' => $siteCustomValues->site]),
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
        {!! Form::open(['url' => route('destroy_custom_values_site', ['siteCustomValues' => $siteCustomValues]), 'method' => 'delete']) !!}
        <div class="form-group">
            {!! Form::label('', __('site.remove_custom_value_confirm')) !!}
            <div>
                {!! Form::submit(__('utils.delete'), ['class' => 'btn btn-primary'])  !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
