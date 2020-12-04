<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * @package App\Models
 */
class Category extends Model
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

}
