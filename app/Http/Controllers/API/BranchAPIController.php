<?php

namespace App\Http\Controllers\API;
use Spatie\QueryBuilder\QueryBuilder;

use App\Http\Requests\API\CreateBranchAPIRequest;
use App\Http\Requests\API\UpdateBranchAPIRequest;
use App\Models\Branch;
use App\Repositories\BranchRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class BranchController
 * @package App\Http\Controllers\API
 */

class BranchAPIController extends AppBaseController
{
    /** @var  BranchRepository */
    private $branchRepository;

    public function __construct(BranchRepository $branchRepo)
    {
        $this->branchRepository = $branchRepo;
    }

    /**
     * Display a listing of the Branch.
     * GET|HEAD /branches
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $branches = QueryBuilder::for(Branch::class)
        ->allowedFilters($this->branchRepository->getFieldsSearchable())
        ->allowedSorts($this->branchRepository->getFieldsSearchable())

        ->get();

        return $this->sendResponse(
            $branches->toArray(),
            __('messages.retrieved', ['model' => __('models/branches.plural')])
        );
    }

    /**
     * Store a newly created Branch in storage.
     * POST /branches
     *
     * @param CreateBranchAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateBranchAPIRequest $request)
    {
        $input = $request->all();

        $branch = $this->branchRepository->create($input);

        return $this->sendResponse(
            $branch->toArray(),
            __('messages.saved', ['model' => __('models/branches.singular')])
        );
    }

    /**
     * Display the specified Branch.
     * GET|HEAD /branches/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Branch $branch */
        $branch = $this->branchRepository->find($id);

        if (empty($branch)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/branches.singular')])
            );
        }

        return $this->sendResponse(
            $branch->toArray(),
            __('messages.retrieved', ['model' => __('models/branches.singular')])
        );
    }

    /**
     * Update the specified Branch in storage.
     * PUT/PATCH /branches/{id}
     *
     * @param int $id
     * @param UpdateBranchAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBranchAPIRequest $request)
    {
        $input = $request->all();

        /** @var Branch $branch */
        $branch = $this->branchRepository->find($id);

        if (empty($branch)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/branches.singular')])
            );
        }

        $branch = $this->branchRepository->update($input, $id);

        return $this->sendResponse(
            $branch->toArray(),
            __('messages.updated', ['model' => __('models/branches.singular')])
        );
    }

    /**
     * Remove the specified Branch from storage.
     * DELETE /branches/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Branch $branch */
        $branch = $this->branchRepository->find($id);

        if (empty($branch)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/branches.singular')])
            );
        }

        $branch->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/branches.singular')])
        );
    }
}
