<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 * @package App\Models
 */
class Tag extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @return array
     */
    public function validationRules(): array
    {
        return [
            'name' => 'string|max:255|required',
        ];
    }
}
