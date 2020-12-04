<?php

/** @var $site \App\Models\Site  */
/** @var $menu array */
/** @var $title string */
/** @var $breadcrumbs string */

$title = $site->domain_name;
$menu = [
    [
        'title' => __('site.list'),
        'link' => route('site'),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
    [
        'title' => __('site.update'),
        'link' => route('edit_site', ['site' => $site->id]),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') =>route('home'),
    __('site.list') =>route('site'),
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

            @include('site.navigation', [
            'site' => $site,
             ])

            <table class="table table-striped table-bordered table-hover">
                <tr>
                    <th>Аттрибут</th>
                    <th>Значение</th>
                </tr>
                <tr>
                    <td>@lang('site.id')</td>
                    <td>{{ $site->id }}</td>
                </tr>
                <tr>
                    <td>@lang('site.domain_name')</td>
                    <td>{{ $site->domain_name }}</td>
                </tr>

                <tr>
                    <td>Количестко контента</td>
                    <td>{{ $site->videos->count() }}</td>
                </tr>

                <tr>
                    <td>@lang('site.logo')</td>
                    @if ($site->logo)
                        <td>{!! Html::image(App\Helpers\SiteHelper::getLogoPath($site->logo), $site->domain_name, []) !!}</td>
                    @else
                        <td>@lang('utils.no_image')</td>
                    @endif
                </tr>
                <tr>
                    <td>@lang('site.icon')</td>
                    @if ($site->logo)
                        <td>{!! Html::image(App\Helpers\SiteHelper::getIconPath($site->icon), $site->domain_name, []) !!}</td>
                    @else
                        <td>@lang('utils.no_image')</td>
                    @endif
                </tr>

                <tr>
                    <td>Публисный ключ</td>
                    @if(\App\Helpers\SecretKeyHelper::getSitePublicKey($site))
                        <td>Публичный ключ установлен</td>
                    @else
                        <td>Внимание: "Публичный ключ не задан!"</td>
                    @endif
                </tr>
            </table>
        </div>
    </div>
@endsection