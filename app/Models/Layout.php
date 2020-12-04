<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Layout
 * @package App\Models
 */
class Layout extends Model
{
    /**
     * @var string
     */
    const LAYOUT_PATH =  DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR ;

    /**
     * @var string
     */
    const TYPE_HEADER = 'header';

    /**
     * @var string
     */
    const TYPE_FOOTER = 'footer';
    /**
     * @var string
     */
    const TYPE_CONTENT = 'content';
    /**
     * @var string
     */
    const TYPE_SIDEBAR = 'sidebar';


    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'type', 'name',
    ];

    /**
     * @return array
     */
    public function validationRules(): array
    {
        return [
            'layout.name' => 'string|max:255|required',
            'layout.type' => 'string|max:255|required',
        ];
    }

    /**
     * @return array
     */
    public function getType()
    {
        return [
            self::TYPE_HEADER => self::TYPE_HEADER,
            self::TYPE_FOOTER => self::TYPE_FOOTER,
            self::TYPE_CONTENT => self::TYPE_CONTENT,
            self::TYPE_SIDEBAR => self::TYPE_SIDEBAR,
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function siteTemplates()
    {
        return $this->belongsToMany(
            Layout::class,
            'site_template_to_layout',
            'layout_id',
            'site_template_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function layoutFiles()
    {
        return $this->hasMany(LayoutFile::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sites()
    {
        return $this->belongsToMany(Site::class);
    }
}
