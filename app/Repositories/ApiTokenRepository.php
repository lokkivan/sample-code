<?php

namespace App\Repositories;

use App\Models\ApiToken;
use Illuminate\Support\Carbon;

/**
 * Class ApiTokenRepository
 * @package App\Repositories
 */
class ApiTokenRepository
{
    /**
     * @param false $asList
     * @return mixed
     */
    public function findAll($asList = false)
    {
        return $asList ? ApiToken::pluck('name', 'id')->toArray() : ApiToken::all();
    }

    /**
     * @param $id
     * @return ApiToken|null
     */
    public function findById($id): ?ApiToken
    {
        return ApiToken::whereId($id)->first();
    }

    /**
     * @param $apiToken
     * @return ApiToken|null
     */
    public function findByApiToken($apiToken): ?ApiToken
    {
        return ApiToken::where('api_token', $apiToken)->first();
    }
}
