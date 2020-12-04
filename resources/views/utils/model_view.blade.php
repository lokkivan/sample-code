<?php
/** @var $model \Illuminate\Database\Eloquent\Model */
/** @var $fields array */
/** @var $intl_file string */

$modelClass = get_class($model);
$intlFile = $intl_file ?? 'utils';
?>
<div class="list-view">
    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th>Аттрибут</th>
            <th>Значение</th>
        </tr>
        @foreach($fields as $fieldName)
            <tr>
                <td>@lang($intlFile . '.' . (is_array($fieldName) ? key($fieldName) : $fieldName))</td>
                @if (is_array($fieldName))
                    <td>{{ $model->getAttribute(key($fieldName))->getAttribute(current($fieldName)) }}</td>
                @else
                    @if ($modelClass === 'App\Models\User' && $fieldName === 'role')
                        <td>{{ \App\Helpers\UserHelper::getRoleName($model->role) }}</td>
                    @elseif ($modelClass === 'App\Models\Facility' && $fieldName === 'logo')
                        <td>{!! Html::image(App\Helpers\FacilityHelper::getLogoPath($model), $model->name, []) !!}</td>
                    @else
                        <td>{{ $model->getAttribute($fieldName) }}</td>
                    @endif
                @endif
            </tr>
        @endforeach
    </table>
</div>
