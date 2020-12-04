<?php

namespace App\Http\Controllers\Api;

use App\Facades\RsaEncryption;
use App\Helpers\SecretKeyHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Class LoginController
 * @package App\Http\Controllers\Api
 */
class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getPublicKey(Request $request): JsonResponse
    {
        $publicKey = SecretKeyHelper::getPublicKey();

        if ($publicKey) {
            return response()->json(['public_key' => $publicKey], 200);
        }

        return response()->json(['message' => 'Keys not generated'], 401);
    }
}
