<?php

namespace App\Helpers;

use App\Models\Site;

/**
 * Class SecretKeyHelper
 * @package App\Helpers
 */
class SecretKeyHelper
{
    const PUBLIC_KEY_NAME = 'public.txt';

    const PRIVATE_KEY_NAME = 'private.txt';

    /**
     * @return string
     */
    public static function getPublicKeyPath(): ?string
    {
        return storage_path('key' . DIRECTORY_SEPARATOR . static::PUBLIC_KEY_NAME);
    }

    /**
     * @return string|null
     */
    public static function getPrivateKeyPath(): ?string
    {
        return storage_path('key' . DIRECTORY_SEPARATOR . static::PRIVATE_KEY_NAME);
    }

    /**
     * @return string|null
     */
    public static function getPublicKey(): ?string
    {
        if (file_exists(static::getPublicKeyPath())) {
            return file_get_contents(static::getPublicKeyPath());
        }

        return null;
    }

    /**
     * @return string|null
     */
    public static function getPrivateKey(): ?string
    {
        if (file_exists(static::getPrivateKey())) {
            return file_get_contents(static::getPrivateKey());
        }

        return null;
    }

    /**
     * @param Site $site
     * @return string
     */
    public static function getSitePublicKeyPath(Site $site): string
    {
        return storage_path('key' . DIRECTORY_SEPARATOR . $site->domain_name . '.txt');
    }

    /**
     * @return string|null
     */
    public static function getSitePublicKey(Site $site): ?string
    {
        if (file_exists(static::getSitePublicKeyPath($site))) {
            return file_get_contents(static::getSitePublicKeyPath($site));
        }

        return null;
    }

    /**
     * @return array
     */
    public static function secretKeyGenerator(): array
    {
        $pkGenerate = openssl_pkey_new(array(
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA
        ));

        openssl_pkey_export($pkGenerate,$privateKey);


        $pkGenerateDetails = openssl_pkey_get_details($pkGenerate);
        $publicKey = $pkGenerateDetails['key'];

        return [
            'privateKey' => $privateKey,
            'publicKey' => $publicKey,
        ];
    }
}
