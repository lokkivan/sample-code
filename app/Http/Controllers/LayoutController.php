<?php

namespace App\Http\Controllers;

use App\Factories\LayoutFactory;
use App\Factories\LayoutFileFactory;
use App\Helpers\LayoutFileHelper;
use App\Models\Layout;
use App\Models\LayoutFile;
use App\Models\User;
use App\Repositories\LayoutRepository;
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
 * Class LayoutController
 * @package App\Http\Controllers
 */
class LayoutController extends Controller
{
    /**
     * @var LayoutRepository
     */
    private $layoutRepository;

    /**
     * LayoutFileFactory
     */
    private $layoutFileFactory;

    /**
     * LayoutController constructor.
     * @param LayoutRepository $layoutRepository
     */
    public function __construct(
        LayoutRepository $layoutRepository,
        LayoutFileFactory $layoutFileFactory
    )
    {
        $this->layoutRepository = $layoutRepository;
        $this->layoutFileFactory = $layoutFileFactory;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('layout.index', [
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
                ->setDataProvider(new EloquentDataProvider(Layout::query()))
                ->setPageSize(25)
                ->setColumns([
                    (new FieldConfig)
                        ->setName('type')
                        ->setLabel(__('layout.type'))
                        ->setSortable(true)
                        ->setSorting(Grid::SORT_ASC)
                        ->addFilter(
                            (new FilterConfig)
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )
                    ,
                    (new FieldConfig)
                        ->setName('name')
                        ->setLabel(__('layout.name'))
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
    private function getLayoutsLinks($layoutId, User $currentUser): string
    {
        $result = '';
        $layout = $this->layoutRepository->findById($layoutId);

        if ($currentUser->can('show', Layout::class)) {
            $result .= link_to_route(
                'show_layout',
                '',
                ['layout' => $layout],
                ['class' => 'glyphicon glyphicon-search']
            );
        }
        if ($currentUser->can('update', Layout::class)) {
            $result .= link_to_route(
                'edit_layout',
                '',
                ['layout' => $layout],
                ['class' => 'glyphicon glyphicon-pencil']
            );
        }

        if ($currentUser->can('delete', Layout::class)) {
            $result .= link_to_route(
                'remove_layout',
                '',
                ['layout' => $layout],
                ['class' => 'glyphicon glyphicon-remove']
            );
        }

        return $result;
    }

    /**
     * @param Request $request
     * @param Layout $layout
     * @return View
     */
    public function show(Request $request, Layout $layout): View
    {
        return view('layout.show', [
            'layout' => $layout,
        ]);
    }

    /**
     * @param Layout $layout
     * @return View
     */
    public function create(Layout $layout): View
    {
        return view('layout.create', [
            'layout' => $layout,
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $layout = LayoutFactory::create();

        $validator = Validator::make(
            $request->all(),
            array_merge(
                $layout->validationRules()
            )
        );

        if (!$validator->fails()) {

            try {
                $validated = $validator->validate();
                $layout->fill($validated['layout']);
                $layout->save();

                if ($request->layout_file) {
                    foreach ($request->layout_file as $file) {

                        $this->createLayoutFile($layout, $file);
                    }
                }
                return redirect()->route('show_layout', ['layout' => $layout]);

            } catch (\Exception $e) {
                Log::error($e->getMessage(), [__CLASS__, __METHOD__]);
                $validator->getMessageBag()->add('', $e->getMessage());
            }
        }

        return redirect()
            ->route('create_layout')
            ->withErrors($validator)
            ->withInput()
            ;
    }

    /**
     * @param Layout $layout
     * @param $file
     */
    private function createLayoutFile(Layout $layout, $file): void
    {
        $newFile = LayoutFileHelper::storeLayoutFile($layout, $file);

        $layoutFile = $this->layoutFileFactory->create();
        $layoutFile->layout_id = $layout->id;
        $layoutFile->file_name = $newFile;
        $layoutFile->save();
    }

    /**
     * @param Layout $layout
     * @return View
     */
    public function edit(Layout $layout): View
    {
        return view('layout.update', [
            'layout' => $layout,
        ]);
    }

    /**
     * @param Request $request
     * @param Layout $layout
     * @return RedirectResponse
     */
    public function update(Request $request, Layout $layout): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            array_merge(
                $layout->validationRules()
            )
        );

        if (!$validator->fails()) {
            try {
                $validated = $validator->validate();
                $layout->fill($validated['layout']);
                $layout->save();

                if ($request->layout_file) {
                    foreach ($request->layout_file as $file) {
                        $this->createLayoutFile($layout, $file);
                    }
                }

                return redirect()->route('show_layout', ['layout' => $layout]);
            } catch (\Exception $e) {
                Log::error($e->getMessage(), [__METHOD__, __CLASS__]);
                $validator->getMessageBag()->add('name', $e->getMessage());
            }
        }

        return redirect()->route('edit_layout', ['layout' => $layout->id])
            ->withErrors($validator)
            ->withInput();
    }

    /**
     * @param Layout $layout
     * @return View
     */
    public function remove(Layout $layout): View
    {
        return view('layout.remove', [
            'layout' => $layout,
        ]);
    }

    /**
     * @param Layout $layout
     * @return RedirectResponse
     */
    public function destroy(Layout $layout): RedirectResponse
    {
        try {
            $layout->delete();
            $this->setFlashMessage(
                __('layout.deleted'),
                self::FLASH_MESSAGE_LEVEL_SUCCESS
            );
        } catch (\Exception $e) {
            $this->setFlashMessage($e->getMessage(), self::FLASH_MESSAGE_LEVEL_ERROR);
        }

        return redirect()->route('layout');
    }

    /**
     * @param Request $request
     * @param Layout $layout
     * @return RedirectResponse
     */
    public function addLayoutFile(Request $request, Layout $layout): RedirectResponse
    {
        if ($request->layout_file) {
            $this->createLayoutFile($layout, $request->layout_file);
        }

        return redirect()->route('show_layout', ['layout' => $layout->id]);
    }

    /**
     * @param LayoutFile $layoutFile
     * @return View
     */
    public function removeLayoutFile(LayoutFile $layoutFile): View
    {
        return view('layout.remove_layout_file', [
            'layoutFile' => $layoutFile,
        ]);
    }

    /**
     * @param LayoutFile $layoutFile
     * @return BinaryFileResponse
     */
    public function downloadFile(LayoutFile $layoutFile): BinaryFileResponse
    {
        return response()->download(LayoutFileHelper::getFilePath($layoutFile));
    }
}
