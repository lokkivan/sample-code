<?php

namespace App\Repositories;

use App\Models\Provider;

/**
 * Class ProviderRepository
 * @package App\Repositories
 */
class ProviderRepository
{
    /**
     * @param bool $asList
     * @return Provider[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findAll($asList = false)
    {
        return $asList ? Provider::pluck('name', 'id')->toArray() : Provider::all();
    }

    /**
     * @param $id
     * @return Provider|null
     */
    public function findById($id): ?Provider
    {
        return Provider::whereId($id)->first();
    }

    /**
     * @param $name
     * @return Provider|null
     */
    public function findByName($name): ?Provider
    {
        return Provider::where('name', $name)->first();
    }
}
