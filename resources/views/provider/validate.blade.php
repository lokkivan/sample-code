<?php

/** @var $provider \App\Models\Provider  */
/** @var $menu array */
/** @var $title string */
/** @var $breadcrumbs string */

$title = 'Валидация контента: ' .  $provider->name;
$menu = [
    [
        'title' => __('provider.list'),
        'link' => route('provider'),
        'visible' => \Auth::user()->can('index', \App\Models\Provider::class),
    ],
    [
        'title' => 'Все видео' ,
        'link' =>route('all_video_provider', ['provider'=> $provider]),
        'visible' => \Auth::user()->can('index', \App\Models\Provider::class),
    ],
];
$breadcrumbs = [
    __('utils.home') =>route('home'),
    __('provider.list') => route('provider'),
    'Настройки провайдера: ' . $provider->name => route('show_provider', ['provider' => $provider]),
    'Все видео' => route('all_video_provider', ['provider'=> $provider]),
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
        {!! Form::open([
           'url' => route('set_validated', ['provider' => $provider]),
           'enctype' => 'multipart/form-data',
           'method' => 'post',
         ]) !!}
        @if (count($videos) == 3)
            <div class="content-list">
                <div class="container">
                    <div class="row">

                            <div class="col-lg-4">
                                <div class="thumb custom-thumb">
                                    <img src="{{ \App\Helpers\VideoHelper::getDefaultThumb($videos[0]) }}" style="width:240px;height:180px;" >
                                </div>
                                <p class="title">{{ $videos[0]->title }}</p>
                                <div class="form-group">
                                    <p>Удалить<input type="checkbox" name="video_id[]" id="check1" value="{{ $videos[0]->id }}" style="padding-left: 10px; width:30px;height:30px;"></p>

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="thumb custom-thumb">
                                    <img src="{{ \App\Helpers\VideoHelper::getDefaultThumb($videos[1]) }}"  style="width:240px;height:180px;">
                                </div>
                                <p class="title">{{ $videos[1]->title }}</p>
                                <div class="form-group">
                                    <p>Удалить<input type="checkbox" name="video_id[]" id="check2" value="{{ $videos[1]->id }}" style="padding-left: 10px; width:30px;height:30px;"></p>

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="thumb custom-thumb">
                                    <img src="{{ \App\Helpers\VideoHelper::getDefaultThumb($videos[2]) }}"  style="width:240px;height:180px;">
                                </div>
                                <p class="title">{{ $videos[2]->title }}</p>
                                <div class="form-group">
                                    <p>Удалить<input type="checkbox" name="video_id[]" id="check3" value="{{ $videos[2]->id }}" style="padding-left: 10px; width:30px;height:30px;"></p>

                                </div>
                            </div>

                    </div>
                </div>
            </div>
        @endif
        <div class="form-group">
            {!! Form::submit('Следующий', ['class' => 'btn btn-primary', 'id' => 'buttonID'])  !!}
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function(){
            $(document).keyup(function(event){

                if (event.which == 81) {
                    $('#check1').attr('checked', true);
                }
                if (event.which == 87) {
                    $('#check2').attr('checked', true);
                }
                if (event.which == 69) {
                    $('#check3').attr('checked', true);
                }
                if (event.which == 32) {
                    $("#buttonID").click();
                }
            });
        })
    </script>
@endsection
