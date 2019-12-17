<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateGradeAPIRequest;
use App\Http\Requests\API\UpdateGradeAPIRequest;
use App\Models\Grade;
use App\Repositories\GradeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class GradeController
 * @package App\Http\Controllers\API
 */

class GradeAPIController extends AppBaseController
{
    /** @var  GradeRepository */
    private $gradeRepository;

    public function __construct(GradeRepository $gradeRepo)
    {
        $this->gradeRepository = $gradeRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/grades",
     *      summary="Get a listing of the Grades.",
     *      tags={"Grade"},
     *      description="Get all Grades",
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
     *                  @SWG\Items(ref="#/definitions/Grade")
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
        $this->gradeRepository->pushCriteria(new RequestCriteria($request));
        $this->gradeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $grades = $this->gradeRepository->all();

        return $this->sendResponse($grades->toArray(), 'Grades retrieved successfully');
    }

    /**
     * @param CreateGradeAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/grades",
     *      summary="Store a newly created Grade in storage",
     *      tags={"Grade"},
     *      description="Store Grade",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Grade that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Grade")
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
     *                  ref="#/definitions/Grade"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateGradeAPIRequest $request)
    {
        $input = $request->all();

        $grades = $this->gradeRepository->create($input);

        return $this->sendResponse($grades->toArray(), 'Grade saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/grades/{id}",
     *      summary="Display the specified Grade",
     *      tags={"Grade"},
     *      description="Get Grade",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Grade",
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
     *                  ref="#/definitions/Grade"
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
        /** @var Grade $grade */
        $grade = $this->gradeRepository->findWithoutFail($id);

        if (empty($grade)) {
            return $this->sendError('Grade not found');
        }

        return $this->sendResponse($grade->toArray(), 'Grade retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateGradeAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/grades/{id}",
     *      summary="Update the specified Grade in storage",
     *      tags={"Grade"},
     *      description="Update Grade",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Grade",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Grade that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Grade")
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
     *                  ref="#/definitions/Grade"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateGradeAPIRequest $request)
    {
        $input = $request->all();

        /** @var Grade $grade */
        $grade = $this->gradeRepository->findWithoutFail($id);

        if (empty($grade)) {
            return $this->sendError('Grade not found');
        }

        $grade = $this->gradeRepository->update($input, $id);

        return $this->sendResponse($grade->toArray(), 'Grade updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/grades/{id}",
     *      summary="Remove the specified Grade from storage",
     *      tags={"Grade"},
     *      description="Delete Grade",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Grade",
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
        /** @var Grade $grade */
        $grade = $this->gradeRepository->findWithoutFail($id);

        if (empty($grade)) {
            return $this->sendError('Grade not found');
        }

        $grade->delete();

        return $this->sendResponse($id, 'Grade deleted successfully');
    }
}
