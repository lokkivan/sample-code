<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SiteCustomValues
 * @package App\Models
 */
class SiteCustomValues extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = ['name', 'value'];

    /**
     * @return array
     */
    public function validationRules()
    {
        return [
            'castom.name' => 'string|max:255|required',
            'castom.value' => 'string|required',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
