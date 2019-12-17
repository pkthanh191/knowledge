<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCourseOrderAPIRequest;
use App\Http\Requests\API\UpdateCourseOrderAPIRequest;
use App\Models\CourseOrder;
use App\Repositories\CourseOrderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CourseOrderController
 * @package App\Http\Controllers\API
 */

class CourseOrderAPIController extends AppBaseController
{
    /** @var  CourseOrderRepository */
    private $courseOrderRepository;

    public function __construct(CourseOrderRepository $courseOrderRepo)
    {
        $this->courseOrderRepository = $courseOrderRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/courseOrders",
     *      summary="Get a listing of the CourseOrders.",
     *      tags={"CourseOrder"},
     *      description="Get all CourseOrders",
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
     *                  @SWG\Items(ref="#/definitions/CourseOrder")
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
        $this->courseOrderRepository->pushCriteria(new RequestCriteria($request));
        $this->courseOrderRepository->pushCriteria(new LimitOffsetCriteria($request));
        $courseOrders = $this->courseOrderRepository->all();

        return $this->sendResponse($courseOrders->toArray(), 'Course Orders retrieved successfully');
    }

    /**
     * @param CreateCourseOrderAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/courseOrders",
     *      summary="Store a newly created CourseOrder in storage",
     *      tags={"CourseOrder"},
     *      description="Store CourseOrder",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CourseOrder that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CourseOrder")
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
     *                  ref="#/definitions/CourseOrder"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCourseOrderAPIRequest $request)
    {
        $input = $request->all();

        $courseOrders = $this->courseOrderRepository->create($input);

        return $this->sendResponse($courseOrders->toArray(), 'Course Order saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/courseOrders/{id}",
     *      summary="Display the specified CourseOrder",
     *      tags={"CourseOrder"},
     *      description="Get CourseOrder",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CourseOrder",
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
     *                  ref="#/definitions/CourseOrder"
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
        /** @var CourseOrder $courseOrder */
        $courseOrder = $this->courseOrderRepository->findWithoutFail($id);

        if (empty($courseOrder)) {
            return $this->sendError('Course Order not found');
        }

        return $this->sendResponse($courseOrder->toArray(), 'Course Order retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCourseOrderAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/courseOrders/{id}",
     *      summary="Update the specified CourseOrder in storage",
     *      tags={"CourseOrder"},
     *      description="Update CourseOrder",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CourseOrder",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CourseOrder that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CourseOrder")
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
     *                  ref="#/definitions/CourseOrder"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCourseOrderAPIRequest $request)
    {
        $input = $request->all();

        /** @var CourseOrder $courseOrder */
        $courseOrder = $this->courseOrderRepository->findWithoutFail($id);

        if (empty($courseOrder)) {
            return $this->sendError('Course Order not found');
        }

        $courseOrder = $this->courseOrderRepository->update($input, $id);

        return $this->sendResponse($courseOrder->toArray(), 'CourseOrder updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/courseOrders/{id}",
     *      summary="Remove the specified CourseOrder from storage",
     *      tags={"CourseOrder"},
     *      description="Delete CourseOrder",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CourseOrder",
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
        /** @var CourseOrder $courseOrder */
        $courseOrder = $this->courseOrderRepository->findWithoutFail($id);

        if (empty($courseOrder)) {
            return $this->sendError('Course Order not found');
        }

        $courseOrder->delete();

        return $this->sendResponse($id, 'Course Order deleted successfully');
    }
}
