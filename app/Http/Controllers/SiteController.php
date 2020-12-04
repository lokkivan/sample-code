<?php

namespace App\Http\Controllers;

use App\Components\Site\SiteClient;
use App\Factories\SiteCustomValuesFactory;
use App\Factories\SiteFactory;
use App\Helpers\SiteHelper;
use App\Models\Layout;
use App\Models\Site;
use App\Models\SiteCustomValues;
use App\Models\User;
use App\Models\Video;
use App\Repositories\CategoryRepository;
use App\Repositories\LayoutRepository;
use App\Repositories\ProviderRepository;
use App\Repositories\SiteRepository;
use App\Repositories\TagRepository;
use App\Repositories\TemplateRepository;
use App\Repositories\VideoRepository;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use Auth;

/**
 * Class SiteController
 * @package App\Http\Controllers
 */
class SiteController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var VideoRepository
     */
    private $videoRepository;

    /**
     * @var SiteRepository
     */
    private $siteRepository;

    /**
     * @var ProviderRepository
     */
    private $providerRepository;

    /**
     * @var SiteCustomValuesFactory
     */
    private $siteCustomValuesFactory;

    /**
     * @var TagRepository
     */
    private $tagRepository;

    /**
     * @var LayoutRepository
     */
    private $layoutRepository;

    /**
     * @var TemplateRepository
     */
    private $templateRepository;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var mixed
     */
    private $host;

    /**
     * @var SiteClient
     */
    private $siteClient;

    /**
     * SiteController constructor.
     * @param CategoryRepository $categoryRepository
     * @param VideoRepository $videoRepository
     * @param SiteCustomValuesFactory $siteCustomValuesFactory
     * @param ProviderRepository $providerRepository
     * @param TagRepository $tagRepository
     * @param SiteRepository $siteRepository
     * @param LayoutRepository $layoutRepository
     * @param TemplateRepository $templateRepository
     * @param SiteClient $siteClient
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        VideoRepository $videoRepository,
        SiteCustomValuesFactory $siteCustomValuesFactory,
        ProviderRepository $providerRepository,
        TagRepository $tagRepository,
        SiteRepository $siteRepository,
        LayoutRepository $layoutRepository,
        TemplateRepository $templateRepository,
        SiteClient $siteClient

    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->videoRepository = $videoRepository;
        $this->siteCustomValuesFactory = $siteCustomValuesFactory;
        $this->providerRepository = $providerRepository;
        $this->tagRepository = $tagRepository;
        $this->siteRepository = $siteRepository;
        $this->layoutRepository = $layoutRepository;
        $this->templateRepository = $templateRepository;
        $this->siteClient = $siteClient;

        $this->client = new Client();
        $this->host = env('APP_HUB_ADMIN_HOST', false);
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('site.index', [
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
                ->setDataProvider(new EloquentDataProvider(Site::query()))
                ->setPageSize(25)
                ->setColumns([
                    (new FieldConfig)
                        ->setName('domain_name')
                        ->setLabel(__('site.domain_name'))
                        ->setSortable(true)
                        ->setSorting(Grid::SORT_ASC)
                        ->addFilter(
                            (new FilterConfig)
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )
                    ,
                    (new FieldConfig)
                        ->setName('id')
                        ->setLabel(__('utils.operations'))
                        ->setCallback(function ($id) use ($user) {
                            return $this->getSiteLinks($id, $user);
                        })
                    ,
                ])
        );
    }

    /**
     * @param $siteId
     * @param User $currentUser
     * @return string
     */
    private function getSiteLinks($siteId, User $currentUser): string
    {
        $result = '';
        $site = $this->siteRepository->findById($siteId);

        if ($currentUser->can('show', Site::class)) {
            $result .= link_to_route(
                'show_site',
                '',
                ['site' => $site],
                ['class' => 'glyphicon glyphicon-search']
            );
        }
        if ($currentUser->can('update', Site::class)) {
            $result .= link_to_route(
                'edit_site',
                '',
                ['site' => $site],
                ['class' => 'glyphicon glyphicon-pencil']
            );
        }

        if ($currentUser->can('delete', Site::class)) {
            $result .= link_to_route(
                'remove_site',
                '',
                ['site' => $site],
                ['class' => 'glyphicon glyphicon-remove']
            );
        }

        return $result;
    }

    /**
     * @param Site $site
     * @return View
     */
    public function show(Site $site): View
    {
        return view('site.show', [
            'site' => $site,
        ]);
    }

    /**
     * @param Site $site
     * @return View
     */
    public function create(Site $site): View
    {
        return view('site.create', [
            'site' => $site,
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $site = SiteFactory::create();

        $validator = Validator::make(
            $request->all(),
            array_merge(
                $site->validationRules()
            )
        );

        if (!$validator->fails()) {
            try {
                $validated = $validator->validate();
                $site->fill($validated['site']);
                $site->logo = $this->storeLogo($request, $site);
                $site->icon = $this->storeIcon($request, $site);
                $site->save();

                return redirect()->route('show_site', ['site' => $site->id]);
            } catch (\Exception $e) {
                Log::error($e->getMessage(), [__CLASS__, __METHOD__]);
                $validator->getMessageBag()->add('', $e->getMessage());
            }
        }

        return redirect()
            ->route('create_site')
            ->withErrors($validator)
            ->withInput()
        ;
    }

    /**
     * @param Request $request
     * @return null|string
     */
    private function storeLogo(Request $request, Site $site): ?string
    {
        $logo = $request->file('site.logo', false);

        if ($logo === false) {
            return $site->logo;
        }

        if (!empty($site->logo)) {
            SiteHelper::deleteLogo($site);
        }

        return SiteHelper::storeLogo($logo);
    }

    /**
     * @param Request $request
     * @return null|string
     */
    private function storeIcon(Request $request, Site $site): ?string
    {
        $icon = $request->file('site.icon', false);

        if ($icon === false) {
            return $site->icon;
        }

        if (!empty($site->icon)) {
            SiteHelper::deleteIcon($site);
        }

        return SiteHelper::storeIcon($icon);
    }


    /**
     * @param Site $site
     * @return View
     */
    public function edit(Site $site): View
    {
        return view('site.update', [
            'site' => $site,
        ]);
    }

    /**
     * @param Request $request
     * @param Site $site
     * @return RedirectResponse
     */
    public function update(Request $request, Site $site): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            array_merge(
                $site->validationRules()
            )
        );

        if (!$validator->fails()) {
            try {
                $validated = $validator->validate();
                $site->fill($validated['site']);
                $site->logo = $this->storeLogo($request, $site);
                $site->icon = $this->storeIcon($request, $site);
                $site->save();

                return redirect()->route('show_site', ['site' => $site->id]);
            } catch (\Exception $e) {
                Log::error($e->getMessage(), [__METHOD__, __CLASS__]);
                $validator->getMessageBag()->add('name', $e->getMessage());
            }
        }

        return redirect()->route('edit_site', ['site' => $site->id])
            ->withErrors($validator)
            ->withInput();
    }

    /**
     * @param Site $site
     * @return View
     */
    public function remove(Site $site): View
    {
        return view('site.remove', [
            'site' => $site,
        ]);
    }

    /**
     * @param Site $site
     * @return RedirectResponse
     */
    public function destroy(Site $site): RedirectResponse
    {
        try {
            $site->delete();
            $this->setFlashMessage(
                'Сайт удален!',
                self::FLASH_MESSAGE_LEVEL_SUCCESS
            );
        } catch (\Exception $e) {
            $this->setFlashMessage($e->getMessage(), self::FLASH_MESSAGE_LEVEL_ERROR);
        }

        return redirect()->route('site');
    }

    /**
     * @param Site $site
     * @return View
     */
    public function components(Site $site):View
    {
        $siteLayoutIds = $site->layouts()->pluck('layouts.id')->toArray();
        $layouts = $this->layoutRepository->findAllExcept($siteLayoutIds);
        $templates = $this->templateRepository->findAll($asList = true);

        return view('site.components.components', [
            'site' => $site,
            'layoutsByType' => $this->sortLayoutsByType($layouts),
            'templates' => $templates,
        ]);
    }

    /**
     * @param $layouts
     * @return array
     */
    public function sortLayoutsByType($layouts): array
    {
        $result = [];

        /** @var Layout $layout */
        foreach ($layouts as $layout) {
            $result[$layout->type][$layout->id] = $layout->name;
        }

        return $result ?? [];
    }

    /**
     * @param Request $request
     * @param Site $site
     * @return RedirectResponse
     */
    public function addLayouts(Request $request, Site $site): RedirectResponse
    {
        $layoutIds = $request->only('layouts');

        if (!empty($layoutIds)) {
            $layouts = $this->layoutRepository->findByIds($layoutIds['layouts']);

            foreach ($layouts as $layout) {
                $site->layouts()->save($layout);
            }
        }

        return redirect()->route('components_site', ['site' => $site]);
    }

    /**
     * @param Site $site
     * @param Layout $layout
     * @return RedirectResponse
     */
    public function removeLayout(Site $site, Layout $layout): RedirectResponse
    {
        $site->layouts()->detach([$layout->id]);

        return redirect()->route('components_site', ['site' => $site]);
    }

    /**
     * @param Request $request
     * @param Site $site
     * @return RedirectResponse
     */
    public function addTemplate(Request $request, Site $site): RedirectResponse
    {
        $templateId = $request->only('template');
        $template = $this->templateRepository->findById($templateId['template'] ?? '');

        if($template) {
            $site->template_id = $template->id;
            $site->save();
        }

        return redirect()->route('components_site', ['site' => $site]);
    }

    /**
     * @param Site $site
     * @return RedirectResponse
     */
    public function removeTemplate(Site $site): RedirectResponse
    {
        $site->template_id = null;
        $site->save();

        return redirect()->route('components_site', ['site' => $site]);
    }
}
