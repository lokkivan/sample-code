<?php

/** @var $feedback \App\Models\Feedback  */
/** @var $menu array */
/** @var $title string */
/** @var $breadcrumbs string */

$title = "Сообщение от: $feedback->reply_email";
$menu = [
    [
        'title' => __('feedback.list'),
        'link' => route('feedback'),
        'visible' => \Auth::user()->can('index', \App\Models\Feedback::class),
    ],
    [
        'title' => __('feedback.update'),
        'link' => route('edit_feedback', ['feedback' => $feedback]),
        'visible' => \Auth::user()->can('index', \App\Models\Feedback::class),
    ],
];
$breadcrumbs = [
    __('utils.home') =>route('home'),
    __('feedback.list') =>route('feedback'),
    $title,
];
$siteRepository = new \App\Repositories\SiteRepository();
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

            <table class="table table-striped table-bordered table-hover">
                <tr>
                    <th>Аттрибут</th>
                    <th>Значение</th>
                </tr>
                <tr>
                    <td>@lang('feedback.id')</td>
                    <td>{{ $feedback->id }}</td>
                </tr>

                <tr>
                    <td>@lang('feedback.message')</td>
                    <td>{{ $feedback->message }}</td>
                </tr>

                <tr>
                    <td>@lang('feedback.reply_email')</td>
                    <td>{{ $feedback->reply_email }}</td>
                </tr>

                <tr>
                    <td>@lang('feedback.site_id')</td>
                    <td>{{ $siteRepository->findById($feedback->site_id)->domain_name }}</td>
                </tr>

                <tr>
                    <td>@lang('feedback.answered')</td>

                    @if ($feedback->answered)
                        <td>Да</td>
                    @else
                        <td>Нет</td>
                    @endif
                </tr>
                <tr>
                    <td>@lang('feedback.created_at')</td>
                    <td>{{ $feedback->created_at }}</td>
                </tr>
            </table>

        </div>
    </div>
@endsection