<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCategoryCourseAPIRequest;
use App\Http\Requests\API\UpdateCategoryCourseAPIRequest;
use App\Models\CategoryCourse;
use App\Repositories\CategoryCourseRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CategoryCourseController
 * @package App\Http\Controllers\API
 */

class CategoryCourseAPIController extends AppBaseController
{
    /** @var  CategoryCourseRepository */
    private $categoryCourseRepository;

    public function __construct(CategoryCourseRepository $categoryCourseRepo)
    {
        $this->categoryCourseRepository = $categoryCourseRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/categoryCourses",
     *      summary="Get a listing of the CategoryCourses.",
     *      tags={"CategoryCourse"},
     *      description="Get all CategoryCourses",
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
     *                  @SWG\Items(ref="#/definitions/CategoryCourse")
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
        $this->categoryCourseRepository->pushCriteria(new RequestCriteria($request));
        $this->categoryCourseRepository->pushCriteria(new LimitOffsetCriteria($request));
        $categoryCourses = $this->categoryCourseRepository->all();

        return $this->sendResponse($categoryCourses->toArray(), 'Category Courses retrieved successfully');
    }

    /**
     * @param CreateCategoryCourseAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/categoryCourses",
     *      summary="Store a newly created CategoryCourse in storage",
     *      tags={"CategoryCourse"},
     *      description="Store CategoryCourse",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CategoryCourse that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CategoryCourse")
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
     *                  ref="#/definitions/CategoryCourse"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCategoryCourseAPIRequest $request)
    {
        $input = $request->all();

        $categoryCourses = $this->categoryCourseRepository->create($input);

        return $this->sendResponse($categoryCourses->toArray(), 'Category Course saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/categoryCourses/{id}",
     *      summary="Display the specified CategoryCourse",
     *      tags={"CategoryCourse"},
     *      description="Get CategoryCourse",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CategoryCourse",
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
     *                  ref="#/definitions/CategoryCourse"
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
        /** @var CategoryCourse $categoryCourse */
        $categoryCourse = $this->categoryCourseRepository->findWithoutFail($id);

        if (empty($categoryCourse)) {
            return $this->sendError('Category Course not found');
        }

        return $this->sendResponse($categoryCourse->toArray(), 'Category Course retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCategoryCourseAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/categoryCourses/{id}",
     *      summary="Update the specified CategoryCourse in storage",
     *      tags={"CategoryCourse"},
     *      description="Update CategoryCourse",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CategoryCourse",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CategoryCourse that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CategoryCourse")
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
     *                  ref="#/definitions/CategoryCourse"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCategoryCourseAPIRequest $request)
    {
        $input = $request->all();

        /** @var CategoryCourse $categoryCourse */
        $categoryCourse = $this->categoryCourseRepository->findWithoutFail($id);

        if (empty($categoryCourse)) {
            return $this->sendError('Category Course not found');
        }

        $categoryCourse = $this->categoryCourseRepository->update($input, $id);

        return $this->sendResponse($categoryCourse->toArray(), 'CategoryCourse updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/categoryCourses/{id}",
     *      summary="Remove the specified CategoryCourse from storage",
     *      tags={"CategoryCourse"},
     *      description="Delete CategoryCourse",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CategoryCourse",
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
        /** @var CategoryCourse $categoryCourse */
        $categoryCourse = $this->categoryCourseRepository->findWithoutFail($id);

        if (empty($categoryCourse)) {
            return $this->sendError('Category Course not found');
        }

        $categoryCourse->delete();

        return $this->sendResponse($id, 'Category Course deleted successfully');
    }
}
