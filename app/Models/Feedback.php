<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Feedback
 * @package App\Models
 */
class Feedback extends Model
{
    /**
     * @var string
     */
    protected $table = 'feedback';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'message','reply_email', 'answered',
    ];

    /**
     * @return array
     */
    public function validationRules(): array
    {
        return [
            'feedback.message' => 'required|string|min:4',
            'feedback.reply_email' => 'sometimes|required|email',
            'feedback.answered' => 'nullable',
        ];
    }
}
