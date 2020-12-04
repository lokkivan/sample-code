<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Log;

/**
 * Class Notification
 * @package App\Services
 */
class Notification
{
    /**
     * @param $recievers array and string
     * @param $message
     * @param $title
     * @return bool
     */
    public function sendEmail($recievers, $message, $title): bool
    {
        try {
            Mail::raw($message, function ($m) use ($recievers, $title) {
                $m->to($recievers)->subject($title);
                $m->from(env('MAIL_USERNAME'), env('MAIL_USERNAME_TITLE'));
            });
            return true;

        } catch (\Exception $e) {
            Log::error($e->getMessage(), [__CLASS__, __METHOD__]);
            return false;
        }
    }
}