<?php

namespace App\Http\Controllers\Api;

use App\Repositories\ProviderRepository;
use App\Http\Resources\Provider as ProviderResourse;

/**
 * Class ProviderController
 * @package App\Http\Controllers\Api
 */
class ProviderController extends Controller
{
    /**
     * @var ProviderRepository|null
     */
    private $providerRepository = null;

    /**
     * ProviderController constructor.
     * @param ProviderRepository $providerRepository
     */
    public function __construct(ProviderRepository $providerRepository)
    {
        $this->providerRepository = $providerRepository;
    }

    /**
     * @return mixed
     */
    public function getProviders()
    {
        $providers = $this->providerRepository->findAll();

        return ProviderResourse::collection($providers);
    }
}
