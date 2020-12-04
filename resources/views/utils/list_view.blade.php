<?php
/** @var $models \Illuminate\Database\Eloquent\Collection */
/** @var $fields array */
/** @var $model_name string */
?>
<div class="list-view">
    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th>№</th>
            @foreach($fields as $field)
                <th>@lang($model_name . '.' . $field)</th>
            @endforeach
            <th>Операции</th>
        </tr>
        @foreach($models as $index => $model)
            <tr>
                <td>{{ $index + 1 }}</td>
                @foreach($fields as $field)
                    <td>{{ $model->getAttribute($field) }}</td>
                @endforeach
                <td class="nounderline">
                    <a href="{{ route('show_user', ['id' => $model->getAttribute('id')]) }}"
                       class="glyphicon glyphicon-search"
                       title="Просмотр пользователя">
                    </a>
                    {!! Form::open(['url' => url('users/', $model->id)]) !!}
                        {!! Form::hidden('_method', 'DELETED') !!}
                    <a href="?" class="glyphicon glyphicon-remove"></a>
                        {!! Form::submit('', ['class' => 'glyphicon glyphicon-remove']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </table>
</div>