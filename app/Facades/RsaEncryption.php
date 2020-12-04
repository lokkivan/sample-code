<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class RsaEncryption
 * @package App\Facades
 */
class RsaEncryption extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'rsaEncryption';
    }
}
