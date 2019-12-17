<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCenterAPIRequest;
use App\Http\Requests\API\UpdateCenterAPIRequest;
use App\Models\Center;
use App\Repositories\CenterRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CenterController
 * @package App\Http\Controllers\API
 */

class CenterAPIController extends AppBaseController
{
    /** @var  CenterRepository */
    private $centerRepository;

    public function __construct(CenterRepository $centerRepo)
    {
        $this->centerRepository = $centerRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/centers",
     *      summary="Get a listing of the Centers.",
     *      tags={"Center"},
     *      description="Get all Centers",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Center")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->centerRepository->pushCriteria(new RequestCriteria($request));
        $this->centerRepository->pushCriteria(new LimitOffsetCriteria($request));
        $centers = $this->centerRepository->all();

        return $this->sendResponse($centers->toArray(), 'Centers retrieved successfully');
    }

    /**
     * @param CreateCenterAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/centers",
     *      summary="Store a newly created Center in storage",
     *      tags={"Center"},
     *      description="Store Center",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Center that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Center")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Center"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCenterAPIRequest $request)
    {
        $input = $request->all();

        $centers = $this->centerRepository->create($input);

        return $this->sendResponse($centers->toArray(), 'Center saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/centers/{id}",
     *      summary="Display the specified Center",
     *      tags={"Center"},
     *      description="Get Center",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Center",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Center"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Center $center */
        $center = $this->centerRepository->findWithoutFail($id);

        if (empty($center)) {
            return $this->sendError('Center not found');
        }

        return $this->sendResponse($center->toArray(), 'Center retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCenterAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/centers/{id}",
     *      summary="Update the specified Center in storage",
     *      tags={"Center"},
     *      description="Update Center",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Center",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Center that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Center")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Center"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCenterAPIRequest $request)
    {
        $input = $request->all();

        /** @var Center $center */
        $center = $this->centerRepository->findWithoutFail($id);

        if (empty($center)) {
            return $this->sendError('Center not found');
        }

        $center = $this->centerRepository->update($input, $id);

        return $this->sendResponse($center->toArray(), 'Center updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/centers/{id}",
     *      summary="Remove the specified Center from storage",
     *      tags={"Center"},
     *      description="Delete Center",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Center",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Center $center */
        $center = $this->centerRepository->findWithoutFail($id);

        if (empty($center)) {
            return $this->sendError('Center not found');
        }

        $center->delete();

        return $this->sendResponse($id, 'Center deleted successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\GET(
     *      path="/centers/{id}/teachers",
     *      summary="Get all teachers of center",
     *      tags={"Center"},
     *      description="Get teachers of Center",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Center",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getTeachers($center_id)
    {
        /** @var Teachers $teachers */
        $center = $this->centerRepository->findWithoutFail($center_id);
        if (empty($center)) {
            return $this->sendError('Center not found');
        }
        $teachers = $center->teachers;
        return $this->sendResponse($teachers, 'Get teachers successfully');
    }
}
