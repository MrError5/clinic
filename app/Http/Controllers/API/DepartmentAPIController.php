<?php

namespace App\Http\Controllers\API;
use Spatie\QueryBuilder\QueryBuilder;

use App\Http\Requests\API\CreateDepartmentAPIRequest;
use App\Http\Requests\API\UpdateDepartmentAPIRequest;
use App\Models\Department;
use App\Repositories\DepartmentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class DepartmentController
 * @package App\Http\Controllers\API
 */

class DepartmentAPIController extends AppBaseController
{
    /** @var  DepartmentRepository */
    private $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepo)
    {
        $this->departmentRepository = $departmentRepo;
    }

    /**
     * Display a listing of the Department.
     * GET|HEAD /departments
     *
     * @param Request $request
     * @return Response
     */
     public function index(Request $request)
    {
        $departments = QueryBuilder::for(Department::class)
       ->with('branches')
      ->allowedFilters($this->departmentRepository->getFieldsSearchable())
      ->allowedSorts($this->departmentRepository->getFieldsSearchable())
      ->paginate();
        return $this->sendResponse(
            $departments->toArray(),
            __('messages.retrieved', ['model' => __('models/departments.plural')])
        );
    }


    /**
     * Store a newly created Department in storage.
     * POST /departments
     *
     * @param CreateDepartmentAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDepartmentAPIRequest $request)
    {
        $input = $request->all();

        $department = $this->departmentRepository->create($input);
        $department->branches()->sync($request->branches);

        return $this->sendResponse(
            $department->toArray(),
            __('messages.saved', ['model' => __('models/departments.singular')])
        );
    }

    /**
     * Display the specified Department.
     * GET|HEAD /departments/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Department $department */
        $department = $this->departmentRepository->find($id)->load('branches');

        if (empty($department)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/departments.singular')])
            );
        }

        return $this->sendResponse(
            $department->toArray(),
            __('messages.retrieved', ['model' => __('models/departments.singular')])
        );
    }

    /**
     * Update the specified Department in storage.
     * PUT/PATCH /departments/{id}
     *
     * @param int $id
     * @param UpdateDepartmentAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDepartmentAPIRequest $request)
    {
        $input = $request->all();

        /** @var Department $department */
        $department = $this->departmentRepository->find($id);

        if (empty($department)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/departments.singular')])
            );
        }

        $department = $this->departmentRepository->update($input, $id);
        $department->branches()->sync($request->branches);

        return $this->sendResponse(
            $department->toArray(),
            __('messages.updated', ['model' => __('models/departments.singular')])
        );
    }

    /**
     * Remove the specified Department from storage.
     * DELETE /departments/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Department $department */
        $department = $this->departmentRepository->find($id);

        if (empty($department)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/departments.singular')])
            );
        }

        $department->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/departments.singular')])
        );
    }
}
