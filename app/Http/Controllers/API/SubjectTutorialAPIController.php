<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSubjectTutorialAPIRequest;
use App\Http\Requests\API\UpdateSubjectTutorialAPIRequest;
use App\Models\SubjectTutorial;
use App\Repositories\SubjectTutorialRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class SubjectTutorialController
 * @package App\Http\Controllers\API
 */

class SubjectTutorialAPIController extends AppBaseController
{
    /** @var  SubjectTutorialRepository */
    private $subjectTutorialRepository;

    public function __construct(SubjectTutorialRepository $subjectTutorialRepo)
    {
        $this->subjectTutorialRepository = $subjectTutorialRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/subjectTutorials",
     *      summary="Get a listing of the SubjectTutorials.",
     *      tags={"SubjectTutorial"},
     *      description="Get all SubjectTutorials",
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
     *                  @SWG\Items(ref="#/definitions/SubjectTutorial")
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
        $this->subjectTutorialRepository->pushCriteria(new RequestCriteria($request));
        $this->subjectTutorialRepository->pushCriteria(new LimitOffsetCriteria($request));
        $subjectTutorials = $this->subjectTutorialRepository->all();

        return $this->sendResponse($subjectTutorials->toArray(), 'Subject Tutorials retrieved successfully');
    }

    /**
     * @param CreateSubjectTutorialAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/subjectTutorials",
     *      summary="Store a newly created SubjectTutorial in storage",
     *      tags={"SubjectTutorial"},
     *      description="Store SubjectTutorial",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SubjectTutorial that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SubjectTutorial")
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
     *                  ref="#/definitions/SubjectTutorial"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSubjectTutorialAPIRequest $request)
    {
        $input = $request->all();

        $subjectTutorials = $this->subjectTutorialRepository->create($input);

        return $this->sendResponse($subjectTutorials->toArray(), 'Subject Tutorial saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/subjectTutorials/{id}",
     *      summary="Display the specified SubjectTutorial",
     *      tags={"SubjectTutorial"},
     *      description="Get SubjectTutorial",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SubjectTutorial",
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
     *                  ref="#/definitions/SubjectTutorial"
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
        /** @var SubjectTutorial $subjectTutorial */
        $subjectTutorial = $this->subjectTutorialRepository->findWithoutFail($id);

        if (empty($subjectTutorial)) {
            return $this->sendError('Subject Tutorial not found');
        }

        return $this->sendResponse($subjectTutorial->toArray(), 'Subject Tutorial retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSubjectTutorialAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/subjectTutorials/{id}",
     *      summary="Update the specified SubjectTutorial in storage",
     *      tags={"SubjectTutorial"},
     *      description="Update SubjectTutorial",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SubjectTutorial",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SubjectTutorial that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SubjectTutorial")
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
     *                  ref="#/definitions/SubjectTutorial"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSubjectTutorialAPIRequest $request)
    {
        $input = $request->all();

        /** @var SubjectTutorial $subjectTutorial */
        $subjectTutorial = $this->subjectTutorialRepository->findWithoutFail($id);

        if (empty($subjectTutorial)) {
            return $this->sendError('Subject Tutorial not found');
        }

        $subjectTutorial = $this->subjectTutorialRepository->update($input, $id);

        return $this->sendResponse($subjectTutorial->toArray(), 'SubjectTutorial updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/subjectTutorials/{id}",
     *      summary="Remove the specified SubjectTutorial from storage",
     *      tags={"SubjectTutorial"},
     *      description="Delete SubjectTutorial",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SubjectTutorial",
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
        /** @var SubjectTutorial $subjectTutorial */
        $subjectTutorial = $this->subjectTutorialRepository->findWithoutFail($id);

        if (empty($subjectTutorial)) {
            return $this->sendError('Subject Tutorial not found');
        }

        $subjectTutorial->delete();

        return $this->sendResponse($id, 'Subject Tutorial deleted successfully');
    }
}
