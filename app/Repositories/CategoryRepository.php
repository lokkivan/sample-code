<?php

namespace App\Repositories;

use App\Factories\CategoryFactory;
use App\Models\Category;

/**
 * Class CategoryRepository
 * @package App\Repositories
 */
class CategoryRepository
{
    /**
     * @param false $asList
     * @return mixed
     */
    public function findAll($asList = false)
    {
        return $asList ? Category::pluck('name', 'id')->toArray() : Category::all();
    }

    /**
     * @param $id
     * @return Category|null
     */
    public function findById($id): ?Category
    {
        return Category::whereId($id)->first();
    }

    /**
     * @param $name
     * @return Category|null
     */
    public function findByName($name): ?Category
    {
        return Category::where('name', $name)->get();
    }

    /**
     * @param $name
     * @return Category|null
     */
    public function findByNameAndProviderId($name): ?Category
    {
        return Category::where('name', 'like', '%' .$name. '%')->first();
    }
}
