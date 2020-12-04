<?php

namespace App\Repositories;

use App\Models\Site;

/**
 * Class SiteRepository
 * @package App\Repositories
 */
class SiteRepository
{
    /**
     * @param bool $asList
     * @return Site[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findAll($asList = false)
    {
        return $asList ? Site::pluck('name', 'id')->toArray() : Site::all();
    }

    /**
     * @param $id
     * @return Site|null
     */
    public function findById($id): ?Site
    {
        return Site::whereId($id)->first();
    }

    /**
     * @param $domainName
     * @return Site|null
     */
    public function findByDomainName($domainName): ?Site
    {
        return Site::where('domain_name', $domainName)->first();
    }
}
