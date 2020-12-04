<?php
/** @var $site \App\Models\Site */
/** @var $errors array */

?>

@if ($site->exists)

    {!! Form::open([
        'url' => isset($action) ? $action : route('update_site', ['site' => $site->id]),
        'enctype' => 'multipart/form-data',
        'method' => 'put',
    ]) !!}
@else
    {!! Form::open([
        'url' => isset($action) ? $action : route('store_site', ['site' => $site->id]),
        'enctype' => 'multipart/form-data',
        'method' => 'post',
    ]) !!}
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

<div class="form-group">
    {!! Form::label(null, __('site.domain_name')) !!}
    {!! Form::text('site[domain_name]', $site->domain_name, ['class' => 'form-control', 'required' => true,]) !!}
</div>

@if ($site->logo)
    <div class="form-group">
        <div class="logo">
            {!! Html::image(\App\Helpers\SiteHelper::getLogoPath($site->logo)) !!}
        </div>
    </div>
@endif
<div class="form-group">
    {!! Form::label(null, __('site.logo')) !!}
    {!! Form::file('site[logo]', ['class' => 'form-control']) !!}
</div>

@if ($site->icon)
    <div class="form-group">
        <div class="logo">
            {!! Html::image(\App\Helpers\SiteHelper::getIconPath($site->icon)) !!}
        </div>
    </div>
@endif
<div class="form-group">
    {!! Form::label(null, __('site.icon')) !!}
    {!! Form::file('site[icon]', ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::submit(__('utils.create'), ['class' => 'btn btn-primary'])  !!}
</div>


{!! Form::close() !!}