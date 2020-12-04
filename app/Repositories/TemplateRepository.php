<?php

namespace App\Repositories;

use App\Models\Template;

/**
 * Class TemplateRepository
 * @package App\Repositories
 */
class TemplateRepository
{
    /**
     * @param false $asList
     * @return mixed
     */
    public function findAll($asList = false)
    {
        return $asList ? Template::pluck('name', 'id')->toArray() : Template::all();
    }

    /**
     * @param $id
     * @return Template|null
     */
    public function findById($id): ?Template
    {
        return Template::whereId($id)->first();
    }
}
