<?php

namespace App\Repositories;

use App\Models\Feedback;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class FeedbackRepository
 * @package App\Repositories
 */
class FeedbackRepository
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAll()
    {
        return Feedback::all();
    }

    /**
     * @param $id
     * @return Feedback|null
     */
    public function findById($id): ?Feedback
    {
        return Feedback::whereId($id)->first();
    }
}
