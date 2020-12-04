<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ApiToken
 *
 * @property int $id
 * @property int $site_id
 * @property string $api_token
 * @property string $creature_at
 * @property string|null $really_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken whereCreatureAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken whereReallyBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken whereSiteId($value)
 * @mixin \Eloquent
 * @property string $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken whereCreatedAt($value)
 */
class ApiToken extends Model
{
    /**
     * {@inheritdoc}
     */
    public $timestamps = false;
}
