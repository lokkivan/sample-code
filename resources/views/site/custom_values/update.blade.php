<?php

/** @var $siteCustomValues \App\Models\SiteCustomValues */
/** @var $errors array */
/** @var $menu array */
/** @var $title string */
/** @var $breadcrumbs string */

$title = __('custom_value.update') . ': ' . $siteCustomValues->name;
$menu = [
    [
        'title' => __('site.custom'),
        'link' => route('custom_values_site', ['site' => $siteCustomValues->site]),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') => route('home'),
    __('site.list') => route('site'),
    __('site.show') . ": ". $siteCustomValues->site->domain_name => route('show_site', ['site' => $siteCustomValues->site]),
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
        @include('site.custom_values._form', [
           'siteCustomValues' => $siteCustomValues,
        ])
    </div>
@endsection
