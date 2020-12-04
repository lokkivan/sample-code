<?php

/** @var $site \App\Models\Site  */
/** @var $menu array */
/** @var $title string */
/** @var $breadcrumbs string */

$title = 'Кастомные значения: ' . $site->domain_name;
$menu = [
    [
        'title' =>  __('site.show') . ":" . $site->domain_name,
        'link' => route('show_site', ['site' => $site]),
        'visible' => \Auth::user()->can('index', \App\Models\User::class),
    ],
];
$breadcrumbs = [
    __('utils.home') =>route('home'),
    __('site.list') =>route('site'),
    __('site.show') . ":" . $site->domain_name =>route('show_site', ['site' => $site]),
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

            @if(count($site->siteCustomValues) > 0)
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>Имя</th>
                        <th>Значение</th>
                        <th>Операции</th>
                    </tr>
                    @foreach($site->siteCustomValues as $siteCustomValues)
                        <tr>
                            <td>{{ $siteCustomValues->name }}</td>
                            <td>{{ $siteCustomValues->value }}</td>
                            <td>
                                <a href="{{ route('edit_custom_values_site', ['siteCustomValues' => $siteCustomValues->id]) }}"
                                   class="glyphicon glyphicon-pencil"></a>
                                <a href="{{ route('remove_custom_values_site', ['siteCustomValues' => $siteCustomValues->id]) }}"
                                   class="glyphicon glyphicon-remove"></a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <p>Добавить значение:</p>
                <div class="">
                    {!! Form::open([
                       'url' => route('add_custom_values_site', ['site' =>$site->id]),
                       'method' => 'post',
                       'class' => 'form-horizontal col-md-6'
                    ]) !!}

                    <div class="form-group">
                        {!! Form::select('castom[name]', $site->getKeyDefaultCustomValues(), null, ['class' => 'form-control', 'placeholder' => 'Выберите кастомное значение']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::textarea('castom[value]', null, ['class' => 'form-control', 'placeholder' => 'Значение']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Добавить', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>

        </div>
    </div>
@endsection