<?php

namespace App\Http\Middleware;

use App\Repositories\ApiTokenRepository;
use Closure;

class AuthKey
{
    /**
     * @var ApiTokenRepository|null
     */
    private $apiTokenRepository = null;

    /**
     * AuthKey constructor.
     * @param ApiTokenRepository $apiTokenRepository
     */
    public function __construct(ApiTokenRepository $apiTokenRepository)
    {
        $this->apiTokenRepository = $apiTokenRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
//        if ($request->path() === "api/login") {
//            return $next($request);
//        }
//
//        $apiToken = $request->only('api_token');
//
//        if ($this->apiTokenRepository->isValid($apiToken)) {
//
//            return $next($request);
//
//        } else {
//
//            return response()->json(['message' => 'No valid Api token'], 401);
//
//        }
    }
}
