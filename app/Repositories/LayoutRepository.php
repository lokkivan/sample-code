<?php

namespace App\Repositories;

use App\Models\Layout;
use Illuminate\Support\Collection;

/**
 * Class LayoutRepository
 * @package App\Repositories
 */
class LayoutRepository
{
    /**
     * @param false $asList
     * @return mixed
     */
    public function findAll($asList = false)
    {
        return $asList ? Layout::pluck('name', 'id')->toArray() : Layout::all();
    }

    /**
     * @param $id
     * @return Layout|null
     */
    public function findById($id): ?Layout
    {
        return Layout::whereId($id)->first();
    }

    /**
     * @param $type
     * @param bool $asList
     * @return array|\Illuminate\Support\Collection
     */
    public function findByType($type, $asList = false)
    {
        if ($asList) {
            return Layout::where('type', $type)->pluck('name', 'id')->toArray();
        }

        return Layout::where('type', $type)->get();
    }

    /**
     * @param array $except
     * @return Collection
     */
    public function findAllExcept(array $except): Collection
    {
        return Layout::query()
            ->whereNotIn('id', $except)
            ->get()
        ;
    }

    /**
     * @param array $ids
     * @return Collection
     */
    public function findByIds(array $ids): Collection
    {
        return Layout::query()->whereIn('id', $ids)->get();
    }
}
