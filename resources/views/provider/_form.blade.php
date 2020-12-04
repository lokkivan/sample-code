<?php
/** @var $provider \App\Models\Provider */
/** @var $errors array */

?>

@if ($provider->exists)

    {!! Form::open([
        'url' => isset($action) ? $action : route('update_provider', ['provider' => $provider]),
        'enctype' => 'multipart/form-data',
        'method' => 'put',
    ]) !!}
@else
    {!! Form::open([
        'url' => isset($action) ? $action : route('store_provider', ['provider' => $provider]),
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
    {!! Form::label(null, __('provider.name')) !!}
    {!! Form::text('provider[name]', $provider->name, ['class' => 'form-control', 'required' => true,]) !!}
</div>

<div class="form-group">
    {!! Form::submit($provider->exists ? 'Изменить' : 'Создать', ['class' => 'btn btn-primary'])  !!}
</div>


{!! Form::close() !!}