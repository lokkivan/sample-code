<?php

/** @var $model \App\Models\User */
/** @var $title string */
/** @var $breadcrumbs array */

$title = __('profile.name');
$breadcrumbs = [
    __('utils.home') => route('home'),
    $title,
];

?>
@extends('layouts.app')
@section('title', $title)

@section('content')
    <div class="container">
        <h1 class="text-center">{{ $title }}</h1>
        <p>
            <a class="btn btn-primary" href="{{ route('my_profile_edit') }}">@lang('profile.update')</a>
            <a class="btn btn-primary" href="{{ route('my_profile_change_password') }}">@lang('profile.change_password')</a>
        </p>
        <table class="table table-bordered table-striped">
            <tr>
                <th>@lang('user.email')</th>
                <td>{{ $model->email }}</td>
            </tr>
            <tr>
                <th>@lang('user.name')</th>
                <td>{{ $model->name }}</td>
            </tr>
            <tr>
                <th>@lang('user.phone')</th>
                <td>{{ $model->phone }}</td>
            </tr>
        </table>

    </div>
@endsection