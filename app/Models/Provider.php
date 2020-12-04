<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Provider
 * @package App\Models
 */
class Provider extends Model
{
    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

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
            'provider.name' => 'string|max:255|required',
        ];
    }

    /**
     * @return mixed
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
