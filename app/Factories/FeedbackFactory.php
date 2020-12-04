<?php

namespace App\Factories;

use App\Models\Feedback;

class FeedbackFactory
{
    /**
     * @return Feedback
     */
    public function createNew(): Feedback
    {
        return new Feedback();
    }
}