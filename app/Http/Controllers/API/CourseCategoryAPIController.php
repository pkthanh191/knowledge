<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCourseCategoryAPIRequest;
use App\Http\Requests\API\UpdateCourseCategoryAPIRequest;
use App\Models\CourseCategory;
use App\Repositories\CourseCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CourseCategoryController
 * @package App\Http\Controllers\API
 */

class CourseCategoryAPIController extends AppBaseController
{
    /** @var  CourseCategoryRepository */
    private $courseCategoryRepository;

    public function __construct(CourseCategoryRepository $courseCategoryRepo)
    {
        $this->courseCategoryRepository = $courseCategoryRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/courseCategories",
     *      summary="Get a listing of the CourseCategories.",
     *      tags={"CourseCategory"},
     *      description="Get all CourseCategories",
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
     *                  @SWG\Items(ref="#/definitions/CourseCategory")
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
        $this->courseCategoryRepository->pushCriteria(new RequestCriteria($request));
        $this->courseCategoryRepository->pushCriteria(new LimitOffsetCriteria($request));
        $courseCategories = $this->courseCategoryRepository->all();

        return $this->sendResponse($courseCategories->toArray(), 'Course Categories retrieved successfully');
    }

    /**
     * @param CreateCourseCategoryAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/courseCategories",
     *      summary="Store a newly created CourseCategory in storage",
     *      tags={"CourseCategory"},
     *      description="Store CourseCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CourseCategory that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CourseCategory")
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
     *                  ref="#/definitions/CourseCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCourseCategoryAPIRequest $request)
    {
        $input = $request->all();

        $courseCategories = $this->courseCategoryRepository->create($input);

        return $this->sendResponse($courseCategories->toArray(), 'Course Category saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/courseCategories/{id}",
     *      summary="Display the specified CourseCategory",
     *      tags={"CourseCategory"},
     *      description="Get CourseCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CourseCategory",
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
     *                  ref="#/definitions/CourseCategory"
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
        /** @var CourseCategory $courseCategory */
        $courseCategory = $this->courseCategoryRepository->findWithoutFail($id);

        if (empty($courseCategory)) {
            return $this->sendError('Course Category not found');
        }

        return $this->sendResponse($courseCategory->toArray(), 'Course Category retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCourseCategoryAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/courseCategories/{id}",
     *      summary="Update the specified CourseCategory in storage",
     *      tags={"CourseCategory"},
     *      description="Update CourseCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CourseCategory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CourseCategory that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CourseCategory")
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
     *                  ref="#/definitions/CourseCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCourseCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var CourseCategory $courseCategory */
        $courseCategory = $this->courseCategoryRepository->findWithoutFail($id);

        if (empty($courseCategory)) {
            return $this->sendError('Course Category not found');
        }

        $courseCategory = $this->courseCategoryRepository->update($input, $id);

        return $this->sendResponse($courseCategory->toArray(), 'CourseCategory updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/courseCategories/{id}",
     *      summary="Remove the specified CourseCategory from storage",
     *      tags={"CourseCategory"},
     *      description="Delete CourseCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CourseCategory",
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
        /** @var CourseCategory $courseCategory */
        $courseCategory = $this->courseCategoryRepository->findWithoutFail($id);

        if (empty($courseCategory)) {
            return $this->sendError('Course Category not found');
        }

        $courseCategory->delete();

        return $this->sendResponse($id, 'Course Category deleted successfully');
    }
}
