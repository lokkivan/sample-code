<?php
/** @var $model \App\Models\User */
/** @var $my_profile bool */
/** @var $errors array */

$showCommentField = !($my_profile ?? false);

?>
@if ($model->exists)
    {!! Form::open([
        'url' => isset($action) ? $action : route('update_user', ['user' => $model->id]),
        'method' => 'put',
    ]) !!}
@else
    {!! Form::open([
        'url' => isset($action) ? $action : route('store_user'),
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
        {!! Form::label('email', __('user.email')) !!}
        {!! Form::email('email', $model->email, ['class' => 'form-control', 'required' => true,]) !!}
    </div>

    @if (!$model->exists)
        <div class="form-group">
            {!! Form::label('password', __('user.password')) !!}
            {!! Form::password('password', ['class' => 'form-control', 'required' => true,]) !!}
        </div>
    @endif

    <div class="form-group">
        {!! Form::label('name', __('user.name')) !!}
        {!! Form::text('name', $model->name, ['class' => 'form-control']) !!}
    </div>


    <div class="form-group">
        {!! Form::submit(__('utils.save'), ['class' => 'btn btn-primary'])  !!}
    </div>

{!! Form::close() !!}