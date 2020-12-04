<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use Session;

class Controller extends BaseController
{
    /**
     * @var string
     */
    const FLASH_MESSAGE_LEVEL_INFO = 'info';

    /**
     * @var string
     */
    const FLASH_MESSAGE_LEVEL_SUCCESS = 'success';

    /**
     * @var string
     */
    const FLASH_MESSAGE_LEVEL_WARNING = 'warning';

    /**
     * @var string
     */
    const FLASH_MESSAGE_LEVEL_ERROR = 'danger';

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param MessageBag $messageBag
     *
     * @return array
     */
    protected function formatErrorMessageFromMessageBag(MessageBag $messageBag)
    {
        $errorArray = $messageBag->toArray();
        $result = [];

        foreach ($errorArray as $fieldName => $errorMessageArray) {
            $result[] = __($errorMessageArray[0]);
        }

        return $result;
    }

    /**
     * @param string $message
     * @param string $level
     */
    protected function setFlashMessage($message, $level = self::FLASH_MESSAGE_LEVEL_INFO)
    {
        Session::flash('message.level', $level);
        Session::flash('message.content', $message);
    }
}
