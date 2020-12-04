<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Tag;
use App\Models\User;
use App\Repositories\ProviderRepository;
use App\Repositories\TagRepository;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;

/**
 * Class TagController
 * @package App\Http\Controllers
 */
class TagController extends Controller
{
    /**
     * @var ProviderRepository
     */
    private $providerRepository;

    /**
     * @var TagRepository
     */
    private $tagRepository;

    /**
     * TagController constructor.
     * @param ProviderRepository $providerRepository
     * @param TagRepository $tagRepository
     */
    public function __construct(
        ProviderRepository $providerRepository,
        TagRepository $tagRepository
    )
    {
        $this->providerRepository = $providerRepository;
        $this->tagRepository = $tagRepository;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('tag.index', [
            'grid' => $this->getGrid(),
        ]);
    }

    /**
     * @param $query
     * @return Grid
     */
    private function getGrid(): Grid
    {
        $user = Auth::user();

        $query = (new Tag())
            ->newQuery()
            ->where('validated', 1);


        return new Grid(
            (new GridConfig())
                ->setDataProvider(new EloquentDataProvider($query))
                ->setPageSize(25)
                ->setColumns([
                    (new FieldConfig)
                        ->setName('name')
                        ->setLabel('Имя')
                        ->setSortable(true)
                        ->setSorting(Grid::SORT_ASC)
                        ->addFilter(
                            (new FilterConfig)
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )
                    ,
                    (new FieldConfig)
                        ->setName('id')
                        ->setLabel('Снять валидацию')
                        ->setCallback(function ($id) use ($user) {
                            return $this->getSiteLinks($id, $user);
                        })
                    ,
                ])
        );
    }

    /**
     * @param $tagId
     * @param User $currentUser
     * @return string
     */
    private function getSiteLinks($tagId, User $currentUser): string
    {
        $result = '';
        $tag = $this->tagRepository->findById($tagId);

        if ($currentUser->can('delete', Site::class)) {
            $result .= link_to_route(
                'set_un_validate_tag',
                '',
                ['tag' => $tag],
                ['class' => 'glyphicon glyphicon-remove']
            );
        }

        return $result;
    }
}
