<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Template
 * @package App\Models
 */
class Template extends Model
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
            'template.name' => 'string|max:255|required',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function templateFiles()
    {
        return $this->hasMany(TemplateFile::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sites()
    {
        return $this->hasMany(Site::class);
    }
}
