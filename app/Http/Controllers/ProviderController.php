<?php

namespace App\Http\Controllers;

use App\Factories\ProviderFactory;

use App\Models\Layout;
use App\Models\Provider;
use App\Models\User;
use App\Models\Video;
use App\Repositories\CategoryRepository;
use App\Repositories\ProviderRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use Auth;

/**
 * Class ProviderController
 * @package App\Http\Controllers
 */
class ProviderController extends Controller
{
    /**
     * @var ProviderRepository
     */
    private $providerRepository;

    /**
     * @var ProviderFactory
     */
    private $providerFactory;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * ProviderController constructor.
     * @param ProviderRepository $providerRepository
     */
    public function __construct(
        ProviderRepository $providerRepository,
        ProviderFactory $providerFactory,
        CategoryRepository $categoryRepository
    )
    {
        $this->providerRepository = $providerRepository;
        $this->providerFactory = $providerFactory;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function index()
    {
        return view('provider.index', [
            'grid' => $this->getIndexGrid(),
        ]);
    }

    /**
     * @return Grid
     */
    private function getIndexGrid(): Grid
    {
        $user = Auth::user();

        return new Grid(
            (new GridConfig())
                ->setDataProvider(new EloquentDataProvider(Provider::query()))
                ->setPageSize(25)
                ->setColumns([
                    (new FieldConfig)
                        ->setName('name')
                        ->setLabel(__('provider.name'))
                        ->setSortable(true)
                    ,
                    (new FieldConfig)
                        ->setName('id')
                        ->setLabel(__('utils.operations'))
                        ->setCallback(function ($id) use ($user) {
                            return $this->getLayoutsLinks($id, $user);
                        })
                    ,
                ])
        );
    }

    /**
     * @param $layoutId
     * @param User $currentUser
     * @return string
     */
    private function getLayoutsLinks($providerId, User $currentUser): string
    {
        $result = '';
        $provider = $this->providerRepository->findById($providerId);

        if ($currentUser->can('index', User::class)) {
            $result .= link_to_route(
                'show_provider',
                '',
                ['provider' => $provider],
                ['class' => 'glyphicon glyphicon-search']
            );
        }
        if ($currentUser->can('index', User::class)) {
            $result .= link_to_route(
                'edit_provider',
                '',
                ['provider' => $provider],
                ['class' => 'glyphicon glyphicon-pencil']
            );
        }

        if ($currentUser->can('index', User::class)) {
            $result .= link_to_route(
                'remove_provider',
                '',
                ['provider' => $provider],
                ['class' => 'glyphicon glyphicon-remove']
            );
        }

        return $result;
    }

    /**
     * @param Provider $provider
     * @return View
     */
    public function show(Provider $provider): View
    {
        return view('provider.show', [
            'provider' => $provider,
        ]);
    }

    /**
     * @param Provider $provider
     * @return View
     */
    public function create(Provider $provider): View
    {
        return view('provider.create', [
            'provider' => $provider,
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $provider = $this->providerFactory->create();

        $validator = Validator::make(
            $request->all(),
            array_merge(
                $provider->validationRules()
            )
        );

        if (!$validator->fails()) {

            try {
                $validated = $validator->validate();
                $provider->fill($validated['provider']);
                $provider->save();

                return redirect()->route('provider');

            } catch (\Exception $e) {
                Log::error($e->getMessage(), [__CLASS__, __METHOD__]);
                $validator->getMessageBag()->add('', $e->getMessage());
            }
        }

        return redirect()
            ->route('create_provider')
            ->withErrors($validator)
            ->withInput()
            ;
    }

    /**
     * @param Provider $provider
     * @return View
     */
    public function edit(Provider $provider): View
    {
        return view('provider.update', [
            'provider' => $provider,
        ]);
    }

    /**
     * @param Request $request
     * @param Provider $provider
     * @return RedirectResponse
     */
    public function update(Request $request, Provider $provider): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            array_merge(
                $provider->validationRules()
            )
        );

        if (!$validator->fails()) {
            try {
                $validated = $validator->validate();
                $provider->fill($validated['provider']);
                $provider->save();

                return redirect()->route('provider');

            } catch (\Exception $e) {
                Log::error($e->getMessage(), [__METHOD__, __CLASS__]);
                $validator->getMessageBag()->add('name', $e->getMessage());
            }
        }

        return redirect()->route('edit_provider', ['provider' => $provider])
            ->withErrors($validator)
            ->withInput();
    }

    /**
     * @param Provider $provider
     * @return View
     */
    public function remove(Provider $provider): View
    {
        return view('provider.remove', [
            'provider' => $provider,
        ]);
    }

    /**
     * @param Provider $provider
     * @return RedirectResponse
     */
    public function destroy(Provider $provider): RedirectResponse
    {
        try {
            $provider->delete();
            $this->setFlashMessage(
                __('provider.deleted'),
                self::FLASH_MESSAGE_LEVEL_SUCCESS
            );
        } catch (\Exception $e) {
            $this->setFlashMessage($e->getMessage(), self::FLASH_MESSAGE_LEVEL_ERROR);
        }

        return redirect()->route('provider');
    }
}
