<?php
/** @var $template \App\Models\Template */
/** @var $errors array */

?>

@if ($template->exists)

    {!! Form::open([
        'url' => isset($action) ? $action : route('update_template', ['template' => $template->id]),
        'enctype' => 'multipart/form-data',
        'method' => 'put',
    ]) !!}
@else
    {!! Form::open([
        'url' => isset($action) ? $action : route('store_template', ['template' => $template->id]),
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
    {!! Form::label(null, __('template.name')) !!}
    {!! Form::text('template[name]', $template->name, ['class' => 'form-control', 'required' => true,]) !!}
</div>

@if(count($template->templateFiles) > 0)
    <h5>Загруженные файлы</h5>
    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th>Путь</th>
            <th>Тип</th>
            <th>Удалить?</th>
        </tr>
        @foreach($template->templateFiles as $file)
            <tbody>
            <tr class='cart-item-1'>

                <td>
                    <strong>{{ $file->file_name }}</strong>
                </td>

                <td>
                    <strong>{{ \App\Helpers\TemplateFileHelper::getFileType($file->file_name) }}</strong>
                </td>

                <td>
                    <a href="{{ route('remove_template_file', ['templateFile' => $file->id]) }}"
                       class="glyphicon glyphicon-remove"></a>
                </td>
            </tr>

        @endforeach
    </table>
@endif

<div class="form-group">
    {!! Form::label('Загрузить файл: CSS, JS , .blade.php - 1шт') !!}
    {!! Form::file("template_file[]", ['multiple' => true]) !!}
</div>

<div class="form-group">
    {!! Form::submit($template->exists ? 'Изменить' : 'Создать', ['class' => 'btn btn-primary'])  !!}
</div>


{!! Form::close() !!}