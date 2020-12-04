<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LayoutFile
 * @package App\Models
 */
class LayoutFile extends Model
{
    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'file_name'
    ];

    /**
     * @return array
     */
    public function validationRules(): array
    {
        return [
            'file_name' => 'string|max:255|required',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function layout()
    {
        return $this->belongsTo(Layout::class);
    }
}
