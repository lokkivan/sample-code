<?php

/** @var $siteCustomValues \App\Models\SiteCustomValues  */
/** @var $errors array */

?>

    {!! Form::open([
        'url' =>  route('update_custom_values_site', ['siteCustomValues' => $siteCustomValues]),
        'enctype' => 'multipart/form-data',
        'method' => 'put',
    ]) !!}



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
    {!! Form::label(null, __('custom_value.name')) !!}
    {!! Form::text('castom[name]', $siteCustomValues->name, ['class' => 'form-control', 'required' => true,]) !!}
</div>
<div class="form-group">
    {!! Form::label(null, __('custom_value.value')) !!}
    {!! Form::textarea('castom[value]', $siteCustomValues->value, ['class' => 'form-control', 'required' => true,]) !!}
</div>


<div class="form-group">
    {!! Form::submit(__('utils.update'), ['class' => 'btn btn-primary'])  !!}
</div>


{!! Form::close() !!}