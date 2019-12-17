<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCourseAPIRequest;
use App\Http\Requests\API\UpdateCourseAPIRequest;
use App\Models\Course;
use App\Repositories\CourseRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CourseController
 * @package App\Http\Controllers\API
 */

class CourseAPIController extends AppBaseController
{
    /** @var  CourseRepository */
    private $courseRepository;

    public function __construct(CourseRepository $courseRepo)
    {
        $this->courseRepository = $courseRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/courses",
     *      summary="Get a listing of the Courses.",
     *      tags={"Course"},
     *      description="Get all Courses",
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
     *                  @SWG\Items(ref="#/definitions/Course")
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
        $this->courseRepository->pushCriteria(new RequestCriteria($request));
        $this->courseRepository->pushCriteria(new LimitOffsetCriteria($request));
        $courses = $this->courseRepository->all();

        return $this->sendResponse($courses->toArray(), 'Courses retrieved successfully');
    }

    /**
     * @param CreateCourseAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/courses",
     *      summary="Store a newly created Course in storage",
     *      tags={"Course"},
     *      description="Store Course",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Course that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Course")
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
     *                  ref="#/definitions/Course"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCourseAPIRequest $request)
    {
        $input = $request->all();

        $courses = $this->courseRepository->create($input);

        return $this->sendResponse($courses->toArray(), 'Course saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/courses/{id}",
     *      summary="Display the specified Course",
     *      tags={"Course"},
     *      description="Get Course",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Course",
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
     *                  ref="#/definitions/Course"
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
        /** @var Course $course */
        $course = $this->courseRepository->findWithoutFail($id);

        if (empty($course)) {
            return $this->sendError('Course not found');
        }

        return $this->sendResponse($course->toArray(), 'Course retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCourseAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/courses/{id}",
     *      summary="Update the specified Course in storage",
     *      tags={"Course"},
     *      description="Update Course",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Course",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Course that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Course")
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
     *                  ref="#/definitions/Course"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCourseAPIRequest $request)
    {
        $input = $request->all();

        /** @var Course $course */
        $course = $this->courseRepository->findWithoutFail($id);

        if (empty($course)) {
            return $this->sendError('Course not found');
        }

        $course = $this->courseRepository->update($input, $id);

        return $this->sendResponse($course->toArray(), 'Course updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/courses/{id}",
     *      summary="Remove the specified Course from storage",
     *      tags={"Course"},
     *      description="Delete Course",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Course",
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
        /** @var Course $course */
        $course = $this->courseRepository->findWithoutFail($id);

        if (empty($course)) {
            return $this->sendError('Course not found');
        }

        $course->delete();

        return $this->sendResponse($id, 'Course deleted successfully');
    }
}
