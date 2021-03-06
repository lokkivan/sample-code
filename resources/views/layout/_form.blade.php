<?php
/** @var $layout \App\Models\Layout */
/** @var $errors array */

?>

@if ($layout->exists)

    {!! Form::open([
        'url' => isset($action) ? $action : route('update_layout', ['layout' => $layout->id]),
        'enctype' => 'multipart/form-data',
        'method' => 'put',
    ]) !!}
@else
    {!! Form::open([
        'url' => isset($action) ? $action : route('store_layout', ['layout' => $layout->id]),
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
    {!! Form::label(null, __('layout.name')) !!}
    {!! Form::text('layout[name]', $layout->name, ['class' => 'form-control', 'required' => true,]) !!}
</div>

<div class="form-group">
    {!! Form::label('Тип') !!}
    {!! Form::select('layout[type]', $layout->getType(), $layout->type, ['class' => 'form-control', 'required' => true]) !!}
</div>

@if(count($layout->layoutFiles) > 0)
    <h5>Загруженные файлы</h5>
    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th>Путь</th>
            <th>Тип</th>
            <th>Удалить?</th>
        </tr>
        @foreach($layout->layoutFiles as $file)
            <tbody>
            <tr class='cart-item-1'>
                <td>
                    <strong>{{ $file->file_name }}</strong>
                </td>
                <td>
                    <strong>{{ \App\Helpers\LayoutFileHelper::getFileType($file->file_name) }}</strong>
                </td>
                <td>
                    <a href="{{ route('remove_layout_faile', ['layoutFile' => $file->id]) }}"
                       class="glyphicon glyphicon-remove"></a>
                </td>
            </tr>

        @endforeach
    </table>
@endif

<div class="form-group">
    {!! Form::label('Загрузить файл: CSS, JS , .blade.php - 1шт') !!}
    {!! Form::file("layout_file[]", ['multiple' => true]) !!}
</div>

<div class="form-group">
    {!! Form::submit($layout->exists ? 'Изменить' : 'Создать', ['class' => 'btn btn-primary'])  !!}
</div>


{!! Form::close() !!}
