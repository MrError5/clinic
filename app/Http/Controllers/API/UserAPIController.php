<?php

namespace App\Http\Controllers\API;
use Spatie\QueryBuilder\QueryBuilder;

use App\Http\Requests\API\CreateUserAPIRequest;
use App\Http\Requests\API\UpdateUserAPIRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class UserController
 * @package App\Http\Controllers\API
 */

class UserAPIController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     * GET|HEAD /users
     *
     * @param Request $request
     * @return Response
     */
     public function index(Request $request)
    {
        $users = QueryBuilder::for(User::class)
        // ->whereRoleIs('superadministrator')
      ->with('roles')
      ->allowedFilters($this->userRepository->getFieldsSearchable())
      ->allowedSorts($this->userRepository->getFieldsSearchable())
      ->paginate();
        return $this->sendResponse(
            $users->toArray(),
            __('messages.retrieved', ['model' => __('models/users.plural')])
        );
    }


    /**
     * Store a newly created User in storage.
     * POST /users
     *
     * @param CreateUserAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserAPIRequest $request)
    {
        $input = $request->all();

        $user = $this->userRepository->create($input);
        $user->attachRole($request->role);

        return $this->sendResponse(
            $user->toArray(),
            __('messages.saved', ['model' => __('models/users.singular')])
        );
    }

    /**
     * Display the specified User.
     * GET|HEAD /users/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var User $user */
        // $user = User::with('roles')->find($id);
        $user = $this->userRepository->find($id)->load('roles');


        if (empty($user)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/users.singular')])
            );
        }

        return $this->sendResponse(
            $user->toArray(),
            __('messages.retrieved', ['model' => __('models/users.singular')])
        );
    }

    /**
     * Update the specified User in storage.
     * PUT/PATCH /users/{id}
     *
     * @param int $id
     * @param UpdateUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserAPIRequest $request)
    {
        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->find($id)->load('roles');

        if (empty($user)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/users.singular')])
            );
        }

        $user = $this->userRepository->update($input, $id);
        // $user->detachRole($user->roles);
        // $user->attachRole($request->role);
        // $user->syncRoles($request->role);
        // $user->detachRole('superadministrator');
        // $admin->permissions()->detach([$createPost->id]);
        // $user->roles()->syncWithoutDetaching($user->id);
        // $user->attachRole($request->role);
        // $user->attachRole($request->role);

        // $user->roles()->sync([$request->role]);
$user->detachRoles($user->roles);
        $user->attachRole($request->role);

// $user->attachRoles($request->role);
        return $this->sendResponse(
            $user->toArray(),
            __('messages.updated', ['model' => __('models/users.singular')])
        );
    }

    /**
     * Remove the specified User from storage.
     * DELETE /users/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/users.singular')])
            );
        }

        $user->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/users.singular')])
        );
    }
}
