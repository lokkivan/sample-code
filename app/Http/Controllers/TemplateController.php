<?php

namespace App\Http\Controllers;

use App\Factories\TemplateFactory;
use App\Factories\TemplateFileFactory;
use App\Helpers\TemplateFileHelper;
use App\Models\Layout;
use App\Models\Template;
use App\Models\TemplateFile;
use App\Models\User;
use App\Repositories\TemplateRepository;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;

class TemplateController extends Controller
{
    /**
     * @var TemplateFileFactory
     */
    private $templateFileFactory;

    /**
     * @var TemplateRepository
     */
    private $templateRepository;

    /**
     * @var TemplateFactory
     */
    private $templateFactory;

    /**
     * TemplateController constructor.
     * @param TemplateRepository $templateRepository
     * @param TemplateFileFactory $templateFileFactory
     * @param TemplateFactory $templateFactory
     */
    public function __construct(
        TemplateRepository $templateRepository,
        TemplateFileFactory $templateFileFactory,
        TemplateFactory $templateFactory
    )
    {
        $this->templateFileFactory = $templateFileFactory;
        $this->templateRepository = $templateRepository;
        $this->templateFactory = $templateFactory;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('template.index', [
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
                ->setDataProvider(new EloquentDataProvider(Template::query()))
                ->setPageSize(25)
                ->setColumns([
                    (new FieldConfig)
                        ->setName('name')
                        ->setLabel(__('template.name'))
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
                            return $this->getLinks($id, $user);
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
    private function getLinks($templateId, User $currentUser): string
    {
        $result = '';
        $template = $this->templateRepository->findById($templateId);

        if ($currentUser->can('show', Layout::class)) {
            $result .= link_to_route(
                'show_template',
                '',
                ['template' => $template],
                ['class' => 'glyphicon glyphicon-search']
            );
        }
        if ($currentUser->can('update', Layout::class)) {
            $result .= link_to_route(
                'edit_template',
                '',
                ['template' => $template],
                ['class' => 'glyphicon glyphicon-pencil']
            );
        }

        if ($currentUser->can('delete', Layout::class)) {
            $result .= link_to_route(
                'remove_template',
                '',
                ['template' => $template],
                ['class' => 'glyphicon glyphicon-remove']
            );
        }

        return $result;
    }

    /**
     * @param Template $template
     * @return View
     */
    public function show(Template $template): View
    {
        return view('template.show', [
            'template' => $template,
        ]);
    }

    /**
     * @param Template $template
     * @return View
     */
    public function create(Template $template): View
    {
        return view('template.create', [
            'template' => $template,
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $remplate = $this->templateFactory->create();

        $validator = Validator::make(
            $request->all(),
            array_merge(
                $remplate->validationRules()
            )
        );

        if (!$validator->fails()) {
            try {
                $validated = $validator->validate();
                $remplate->fill($validated['template']);
                $remplate->save();

                if ($request->template_file) {
                    foreach ($request->template_file as $file) {

                        $this->createTemplateFile($remplate, $file);
                    }
                }
                return redirect()->route('show_template', ['template' => $remplate]);

            } catch (\Exception $e) {
                \Log::error($e->getMessage(), [__CLASS__, __METHOD__]);
                $validator->getMessageBag()->add('', $e->getMessage());
            }
        }

        return redirect()
            ->route('create_template')
            ->withErrors($validator)
            ->withInput()
            ;
    }

    /**
     * @param Layout $layout
     * @param $file
     */
    private function createTemplateFile(Template $template, $file): void
    {
        $newFile = TemplateFileHelper::storeLayoutFile($template, $file);

        $templateFile = $this->templateFileFactory->create();
        $templateFile->template_id = $template->id;
        $templateFile->file_name = $newFile;
        $templateFile->save();
    }

    /**
     * @param Template $template
     * @return View
     */
    public function edit(Template $template): View
    {
        return view('template.update', [
            'template' => $template,
        ]);
    }

    /**
     * @param Request $request
     * @param Template $template
     * @return RedirectResponse
     */
    public function update(Request $request, Template $template): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            array_merge(
                $template->validationRules()
            )
        );

        if (!$validator->fails()) {
            try {
                $validated = $validator->validate();
                $template->fill($validated['template']);
                $template->save();

                if ($request->template_file) {
                    foreach ($request->template_file as $file) {
                        $this->createTemplateFile($template, $file);
                    }
                }

                return redirect()->route('show_template', ['template' => $template]);
            } catch (\Exception $e) {
                \Log::error($e->getMessage(), [__METHOD__, __CLASS__]);
                $validator->getMessageBag()->add('name', $e->getMessage());
            }
        }

        return redirect()->route('edit_template', ['template' => $template->id])
            ->withErrors($validator)
            ->withInput();
    }

    /**
     * @param Template $template
     * @return View
     */
    public function remove(Template $template): View
    {
        return view('template.remove', [
            'template' => $template,
        ]);
    }

    /**
     * @param Template $template
     * @return RedirectResponse
     */
    public function destroy(Template $template): RedirectResponse
    {
        try {
            $template->delete();
            $this->setFlashMessage(
                __('Шаблон был удален!'),
                self::FLASH_MESSAGE_LEVEL_SUCCESS
            );
        } catch (\Exception $e) {
            \Log::error($e->getMessage(), [__METHOD__, __CLASS__]);
            $this->setFlashMessage($e->getMessage(), self::FLASH_MESSAGE_LEVEL_ERROR);
        }

        return redirect()->route('template');
    }

    /**
     * @param TemplateFile $templateFile
     * @return View
     */
    public function removeTemplateFile(TemplateFile $templateFile): View
    {
        return view('template.remove_template_file', [
            'templateFile' => $templateFile,
        ]);
    }

    /**
     * @param TemplateFile $templateFile
     * @return RedirectResponse
     */
    public function destroyTemplateFile(TemplateFile $templateFile): RedirectResponse
    {
        $template = $templateFile->template;
        try {
            $templateFile->delete();
            \Storage::delete($templateFile->file_name);
        } catch (\Exception $e) {
            \Log::error($e->getMessage(), [__METHOD__, __CLASS__]);
        }

        return redirect()->route('show_template', ['template' => $template->id]);
    }

    /**
     * @param TemplateFile $templateFile
     * @return BinaryFileResponse
     */
    public function downloadFile(TemplateFile $templateFile): BinaryFileResponse
    {
        return response()->download(TemplateFileHelper::getFilePath($templateFile));
    }
}
