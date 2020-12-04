<?php
/** @var $feedback \App\Models\Feedback */
/** @var $errors array */

?>

{!! Form::open([
    'url' => route('update_feedback', ['feedback' => $feedback]),
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
    {!! Form::label(null, __('feedback.message')) !!}
    {!! Form::textarea('feedback[message]', $feedback->message, ['class' => 'form-control', 'required' => true,]) !!}
</div>

<div class="form-group">
    {!! Form::label(null, __('feedback.reply_email')) !!}
    {!! Form::email('feedback[reply_email]', $feedback->reply_email, ['class' => 'form-control', 'required' => true,]) !!}
</div>

<div class="form-group">
    {!! Form::label(null, __('feedback.answered'), ['class' => 'checkbox-label']) !!}
    {!! Form::checkbox('feedback[answered]', 1, $feedback->answered) !!}
</div>

<div class="form-group">
    {!! Form::submit('Изменить' , ['class' => 'btn btn-primary'])  !!}
</div>


{!! Form::close() !!}