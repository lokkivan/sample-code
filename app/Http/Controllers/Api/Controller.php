<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use Session;

class Controller extends BaseController
{
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
}
