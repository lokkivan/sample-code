<?php

namespace App\Repositories;

use App\Factories\CategoryFactory;
use App\Factories\TagFactory;
use App\Models\Tag;

/**
 * Class TagRepository
 * @package App\Repositories
 */
class TagRepository
{
    /**
     * @param false $asList
     * @return mixed
     */
    public function findAll($asList = false)
    {
        return $asList ? Tag::pluck('name', 'id')->toArray() : Tag::all();
    }

    /**
     * @param $id
     * @return Tag|null
     */
    public function findById($id): ?Tag
    {
        return Tag::whereId($id)->first();
    }

    /**
     * @param $name
     * @return Tag|null
     */
    public function findByName($name): ?Tag
    {
        return Tag::where('name', $name)->first();
    }
}
