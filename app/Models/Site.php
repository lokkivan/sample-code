<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Site
 * @package App\Models
 */
class Site extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'domain_name'
    ];

    /**
     * @return array
     */
    public function validationRules(): array
    {
        return [
            'site.domain_name' => 'string|max:255|required',
            'site.logo' => 'file|image|nullable',
        ];
    }

    /**
     * @return array
     */
    public function getKeyDefaultCustomValues():array
    {
        $keyDefaultCustomValues = [];

        foreach ($this->getDefaultCustomValues() as $key=>$value) {
            $keyDefaultCustomValues[$key] = $key;
        }

        return $keyDefaultCustomValues;
    }

    /**
     * @return BelongsTo
     */
    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    /**
     * @return HasMany
     */
    public function siteCustomValues()
    {
        return $this->hasMany(SiteCustomValues::class);
    }

    /**
     * @return BelongsToMany
     */
    public function layouts()
    {
        return $this->belongsToMany(Layout::class);
    }
}
