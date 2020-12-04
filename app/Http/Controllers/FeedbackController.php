<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Repositories\FeedbackRepository;
use App\Repositories\SiteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Nayjest\Grids\Grid;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\GridConfig;

/**
 * Class FeedbackController
 * @package App\Http\Controllers
 */
class FeedbackController extends Controller
{
    /**
     * @var FeedbackRepository
     */
    private $feedbackRepository;

    /**
     * @var SiteRepository
     */
    private $siteRepository;

    /**
     * FeedbackController constructor.
     * @param FeedbackRepository $feedbackRepository
     * @param SiteRepository $siteRepository
     */
    public function __construct(
        FeedbackRepository $feedbackRepository,
        SiteRepository $siteRepository
    )
    {
        $this->feedbackRepository = $feedbackRepository;
        $this->siteRepository = $siteRepository;
    }

    /**
     * @return View
     */
    public function index():View
    {
        return view('feedback.index', [
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
                ->setDataProvider(new EloquentDataProvider(Feedback::query()))
                ->setPageSize(25)
                ->setColumns([
                    (new FieldConfig)
                        ->setName('message')
                        ->setLabel(__('feedback.message'))
                        ->setSortable(true)
                        ->setSorting(Grid::SORT_ASC)
                    ,
                    (new FieldConfig)
                        ->setName('reply_email')
                        ->setLabel(__('feedback.reply_email'))
                        ->setSortable(true)
                        ->setSorting(Grid::SORT_ASC)
                    ,
                    (new FieldConfig)
                        ->setName('site_id')
                        ->setLabel(__('feedback.site_id'))
                        ->setCallback(function ($siteId) {
                            return $this->siteRepository->findById($siteId)->domain_name;
                        })
                    ,
                    (new FieldConfig)
                        ->setName('answered')
                        ->setLabel(__('feedback.answered'))
                        ->setSortable(true)
                        ->setCallback(function ($answered) use ($user) {
                            return $answered ? "Да" : "Нет";
                        })
                    ,
                    (new FieldConfig)
                        ->setName('created_at')
                        ->setLabel(__('feedback.created_at'))
                        ->setSortable(true)
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
     * @param $feedbackId
     * @param User $currentUser
     * @return string
     */
    private function getLinks($feedbackId, User $currentUser): string
    {
        $result = '';
        $feedback = $this->feedbackRepository->findById($feedbackId);

        if ($currentUser->can('show', Feedback::class)) {
            $result .= link_to_route(
                'show_feedback',
                '',
                ['feedback' => $feedback],
                ['class' => 'glyphicon glyphicon-search']
            );
        }
        if ($currentUser->can('update', Feedback::class)) {
            $result .= link_to_route(
                'edit_feedback',
                '',
                ['feedback' => $feedback],
                ['class' => 'glyphicon glyphicon-pencil']
            );
        }

        if ($currentUser->can('delete', Feedback::class)) {
            $result .= link_to_route(
                'remove_feedback',
                '',
                ['feedback' => $feedback],
                ['class' => 'glyphicon glyphicon-remove']
            );
        }

        return $result;
    }

    /**
     * @param Feedback $feedback
     * @return View
     */
    public function show(Feedback $feedback): View
    {
        return view('feedback.show', [
            'feedback' => $feedback,
        ]);
    }

    /**
     * @param Feedback $feedback
     * @return View
     */
    public function edit(Feedback $feedback): View
    {
        return view('feedback.update', [
            'feedback' => $feedback,
        ]);
    }

    /**
     * @param Request $request
     * @param Feedback $feedback
     * @return RedirectResponse
     */
    public function update(Request $request, Feedback $feedback): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            array_merge(
                $feedback->validationRules()
            )
        );

        if (!$validator->fails()) {
            try {
                $feedback->answered = 0;
                $validated = $validator->validate();
                $feedback->fill($validated['feedback']);
                $feedback->save();

                return redirect()->route('show_feedback', ['feedback' => $feedback]);
            } catch (\Exception $e) {
                Log::error($e->getMessage(), [__METHOD__, __CLASS__]);
                $validator->getMessageBag()->add('name', $e->getMessage());
            }
        }

        return redirect()->route('edit_feedback', ['feedback' => $feedback])
            ->withErrors($validator)
            ->withInput();
    }

    /**
     * @param Feedback $feedback
     * @return View
     */
    public function remove(Feedback $feedback): View
    {
        return view('feedback.remove', [
            'feedback' => $feedback,
        ]);
    }

    /**
     * @param Feedback $feedback
     * @return RedirectResponse
     */
    public function destroy(Feedback $feedback): RedirectResponse
    {
        try {
            $feedback->delete();
            $this->setFlashMessage(
                __('Сообщение было удалено!'),
                self::FLASH_MESSAGE_LEVEL_SUCCESS
            );
        } catch (\Exception $e) {
            $this->setFlashMessage($e->getMessage(), self::FLASH_MESSAGE_LEVEL_ERROR);
        }

        return redirect()->route('feedback');
    }
}
