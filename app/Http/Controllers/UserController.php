<?php

namespace App\Http\Controllers;

use App\Factories\UserFactory;
use App\Helpers\UserHelper;
use Auth;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Log;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use Nayjest\Grids\SelectFilterConfig;
use Validator;

class UserController extends Controller
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserFactory
     */
    private $userFactory;

    /**
     * UserController constructor.
     * @param RoleRepository $roleRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        RoleRepository $roleRepository,
        UserRepository $userRepository,
        UserFactory $userFactory
    )
    {
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
        $this->userFactory = $userFactory;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('users.index', [
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
                ->setDataProvider(new EloquentDataProvider(User::query()))
                ->setPageSize(25)
                ->setColumns([
                    (new FieldConfig)
                        ->setName('id')
                        ->setLabel(__('user.id'))
                        ->setSortable(true)
                        ->setSorting(Grid::SORT_ASC),
                    (new FieldConfig)
                        ->setName('name')
                        ->setLabel(__('user.name'))
                        ->setSortable(false)
                        ->addFilter(
                            (new FilterConfig)
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        ),
                    (new FieldConfig)
                        ->setName('email')
                        ->setLabel(__('user.email'))
                        ->setSortable(false)
                        ->addFilter(
                            (new FilterConfig)
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        ),
                    (new FieldConfig)
                        ->setName('phone')
                        ->setLabel(__('user.phone'))
                        ->setSortable(false)
                        ->addFilter(
                            (new FilterConfig)
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        ),
                    (new FieldConfig)
                        ->setName('role')
                        ->setLabel(__('user.role'))
                        ->setSortable(false)
                        ->setCallback(function ($role) {
                            return UserHelper::getRoleName($role);
                        })
                        ->addFilter(
                            (new SelectFilterConfig)
                                ->setName('role')
                                ->setSubmittedOnChange(true)
                                ->setOptions($this->roleRepository->getRoles())
                        ),
                    (new FieldConfig)
                        ->setName('comment')
                        ->setLabel(__('user.comment'))
                    ,
                    (new FieldConfig)
                        ->setName('id')
                        ->setLabel(__('utils.operations'))
                        ->setCallback(function ($id) use ($user) {
                            return $this->getUserLinks($id, $user);
                        }),
                ])
        );
    }

    /**
     * @param int $userID
     * @param User $currentUser
     * @return string
     */
    private function getUserLinks($userID, User $currentUser)
    {
        $result = '';
        $user = $this->userRepository->findById($userID);

        if ($currentUser->can('view', $user)) {
            $result .= link_to_route(
                'show_user',
                '',
                ['user' => $userID],
                ['class' => 'glyphicon glyphicon-search']
            );
        }

        if ($currentUser->can('update', $user)) {
            $result .= link_to_route(
                'edit_user',
                '',
                ['user' => $userID],
                ['class' => 'glyphicon glyphicon-pencil']
            );
        }

        if ($currentUser->can('delete', $user)) {
            $result .= link_to_route(
                'remove_user',
                '',
                ['user' => $userID],
                ['class' => 'glyphicon glyphicon-remove']
            );
        }

        return $result;
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('users.create', [
            'model' => $this->userFactory->create(),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $this->userFactory->create();
        $validator = Validator::make($request->all(), $user->validationRules());

        if (!$validator->fails()) {
            try {
                $user->fill($validator->validate());
                $user->save();
                $this->setFlashMessage(
                    str_replace(':email', $user->email, __('user.user_created')),
                    self::FLASH_MESSAGE_LEVEL_SUCCESS
                );

                return redirect()->route('users');
            } catch (\Exception $e) {
                Log::error($e->getMessage(), [__METHOD__, __CLASS__]);
                $validator->getMessageBag()->add('', $e->getMessage());
            }
        }

        return redirect()->route('create_user')
            ->withErrors($validator)
            ->withInput()
            ;
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @return View
     */
    public function show(User $user): View
    {
        return view('users.show', [
            'model' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('users.update', [
            'model' => $user,
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        return $this->updateUserData($request, $user, false);
    }

    /**
     * @param Request $request
     * @param User $user
     * @param bool $profileRequest
     * @return RedirectResponse
     */
    private function updateUserData(Request $request, User $user, $profileRequest = false): RedirectResponse
    {
        $validator = Validator::make($request->all(), $user->validationRules());

        if (!$validator->fails()) {
            try {
                $user->fill($validator->validate());
                $user->save();
                $this->setFlashMessage(
                    $profileRequest ?
                        __('user.profile_updated') :
                        str_replace(':email', $user->email, __('user.user_updated'))
                    ,
                    self::FLASH_MESSAGE_LEVEL_SUCCESS
                );

                if ($profileRequest) {
                    return redirect()->route('my_profile');
                }

                return redirect()->route('show_user', ['user' => $user->id]);
            } catch (\Exception $e) {
                Log::error($e->getMessage(), [__METHOD__, __CLASS__]);
                $validator->getMessageBag()->add('name', $e->getMessage());
            }
        }

        if ($profileRequest) {
            return redirect()->route('my_profile_edit')
                ->withErrors($validator)
                ->withInput()
                ;
        }

        return redirect()->route($profileRequest ? 'my_profile_edit' : 'edit_user', ['user' => $user->id])
            ->withErrors($validator)
            ->withInput()
            ;
    }

    /**
     * @param User $user
     * @return View
     */
    public function remove(User $user): View
    {
        return view('users.remove', [
            'model' => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            $email = $user->email;
            $user->delete();
            $this->setFlashMessage(
                str_replace(':email', $email, __('user.user_deleted')),
                self::FLASH_MESSAGE_LEVEL_SUCCESS
            );
        } catch (\Exception $e) {
            $this->setFlashMessage($e->getMessage(), self::FLASH_MESSAGE_LEVEL_ERROR);
        }

        return redirect()->route('users');
    }

    /**
     * @param User $user
     * @return View
     */
    public function changePassword(User $user): View
    {
        return view('users.change_password', [
            'model' => $user,
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function storePassword(Request $request, User $user): RedirectResponse
    {
        return $this->updateUserPassword($request, $user, false);
    }

    /**
     * @param Request $request
     * @param User $user
     * @param bool $profileRequest
     * @return RedirectResponse
     */
    private function updateUserPassword(Request $request, User $user, $profileRequest = false): RedirectResponse
    {
        $validator = Validator::make($request->all(), $user->changePasswordValidationRules());

        if (!$validator->fails()) {
            try {
                $user->fill($validator->validate());
                $user->save();
                $this->setFlashMessage(
                    $profileRequest ?
                        __('user.profile_password_updated') :
                        str_replace(':email', $user->email, __('user.user_password_updated'))
                    ,
                    self::FLASH_MESSAGE_LEVEL_SUCCESS
                );

                if ($profileRequest) {
                    return redirect()->route('my_profile');
                }

                return redirect()->route('show_user', ['user' => $user->id]);
            } catch (\Exception $e) {
                Log::error($e->getMessage(), [__METHOD__, __CLASS__]);
                $validator->getMessageBag()->add('name', $e->getMessage());
            }
        }

        if ($profileRequest) {
            return redirect()->route('my_profile_change_password')
                ->withErrors($validator)
                ->withInput()
                ;
        }

        return redirect()->route('change_password_user', ['user' => $user->id])
            ->withErrors($validator)
            ->withInput()
            ;
    }

    /**
     * @param User $user
     * @param RoleRepository $repository
     * @return View
     */
    public function changeRole(User $user, RoleRepository $repository): View
    {
        return view('users.change_role', [
            'model' => $user,
            'roles' => $repository->getRoles(),
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function storeRole(Request $request, User $user): RedirectResponse
    {
        $validator = Validator::make($request->all(), $user->changeRoleValidationRules());

        if (!$validator->fails()) {
            try {
                $user->role = $validator->validate()['role'];
                $user->save();
                $this->setFlashMessage(
                    str_replace(':email', $user->email, __('user.user_role_updated')),
                    self::FLASH_MESSAGE_LEVEL_SUCCESS
                );

                return redirect()->route('show_user', ['user' => $user->id]);
            } catch (\Exception $e) {
                Log::error($e->getMessage(), [__METHOD__, __CLASS__]);
                $validator->getMessageBag()->add('name', $e->getMessage());
            }
        }

        return redirect()->route('change_role_user', ['user' => $user->id])
            ->withErrors($validator)
            ->withInput()
            ;
    }

    /**
     * @return View
     */
    public function myProfile(): View
    {
        return view('users.my_profile', [
            'model' => Auth::user(),
        ]);
    }

    /**
     * @return View
     */
    public function editMyProfile(): View
    {
        return view('users.edit_my_profile', [
            'model' => Auth::user(),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateMyProfile(Request $request): RedirectResponse
    {
        return $this->updateUserData($request, Auth::user(), true);
    }

    /**
     * @return View
     */
    public function changePasswordMyProfile(): View
    {
        return view('users.change_password_my_profile', [
            'model' => Auth::user(),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function storePasswordMyProfile(Request $request): RedirectResponse
    {
        return $this->updateUserPassword($request, Auth::user(), true);
    }
}
