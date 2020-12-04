<?php

namespace App\Services;

/**
 * Class RsaEncryption
 * @package App\Services
 */
class RsaEncryption
{

    /**
     * @param $data
     * @param $publicKey
     * @return mixed
     */
   public function encrypt($data, $publicKey)
   {
       openssl_public_encrypt($data, $edate, $publicKey);

       return base64_encode($edate);
   }

    /**
     * @param $eDate
     * @return mixed
     */
    public function decrypt($eDate)
    {
        $privateKey = file_get_contents(storage_path('key'. DIRECTORY_SEPARATOR .'private.txt'));
        openssl_private_decrypt($eDate, $dDate, $privateKey);

        return $dDate;
    }
}
