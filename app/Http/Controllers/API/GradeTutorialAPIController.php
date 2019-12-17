<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateGradeTutorialAPIRequest;
use App\Http\Requests\API\UpdateGradeTutorialAPIRequest;
use App\Models\GradeTutorial;
use App\Repositories\GradeTutorialRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class GradeTutorialController
 * @package App\Http\Controllers\API
 */

class GradeTutorialAPIController extends AppBaseController
{
    /** @var  GradeTutorialRepository */
    private $gradeTutorialRepository;

    public function __construct(GradeTutorialRepository $gradeTutorialRepo)
    {
        $this->gradeTutorialRepository = $gradeTutorialRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/gradeTutorials",
     *      summary="Get a listing of the GradeTutorials.",
     *      tags={"GradeTutorial"},
     *      description="Get all GradeTutorials",
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
     *                  @SWG\Items(ref="#/definitions/GradeTutorial")
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
        $this->gradeTutorialRepository->pushCriteria(new RequestCriteria($request));
        $this->gradeTutorialRepository->pushCriteria(new LimitOffsetCriteria($request));
        $gradeTutorials = $this->gradeTutorialRepository->all();

        return $this->sendResponse($gradeTutorials->toArray(), 'Grade Tutorials retrieved successfully');
    }

    /**
     * @param CreateGradeTutorialAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/gradeTutorials",
     *      summary="Store a newly created GradeTutorial in storage",
     *      tags={"GradeTutorial"},
     *      description="Store GradeTutorial",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="GradeTutorial that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/GradeTutorial")
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
     *                  ref="#/definitions/GradeTutorial"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateGradeTutorialAPIRequest $request)
    {
        $input = $request->all();

        $gradeTutorials = $this->gradeTutorialRepository->create($input);

        return $this->sendResponse($gradeTutorials->toArray(), 'Grade Tutorial saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/gradeTutorials/{id}",
     *      summary="Display the specified GradeTutorial",
     *      tags={"GradeTutorial"},
     *      description="Get GradeTutorial",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of GradeTutorial",
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
     *                  ref="#/definitions/GradeTutorial"
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
        /** @var GradeTutorial $gradeTutorial */
        $gradeTutorial = $this->gradeTutorialRepository->findWithoutFail($id);

        if (empty($gradeTutorial)) {
            return $this->sendError('Grade Tutorial not found');
        }

        return $this->sendResponse($gradeTutorial->toArray(), 'Grade Tutorial retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateGradeTutorialAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/gradeTutorials/{id}",
     *      summary="Update the specified GradeTutorial in storage",
     *      tags={"GradeTutorial"},
     *      description="Update GradeTutorial",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of GradeTutorial",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="GradeTutorial that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/GradeTutorial")
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
     *                  ref="#/definitions/GradeTutorial"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateGradeTutorialAPIRequest $request)
    {
        $input = $request->all();

        /** @var GradeTutorial $gradeTutorial */
        $gradeTutorial = $this->gradeTutorialRepository->findWithoutFail($id);

        if (empty($gradeTutorial)) {
            return $this->sendError('Grade Tutorial not found');
        }

        $gradeTutorial = $this->gradeTutorialRepository->update($input, $id);

        return $this->sendResponse($gradeTutorial->toArray(), 'GradeTutorial updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/gradeTutorials/{id}",
     *      summary="Remove the specified GradeTutorial from storage",
     *      tags={"GradeTutorial"},
     *      description="Delete GradeTutorial",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of GradeTutorial",
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
        /** @var GradeTutorial $gradeTutorial */
        $gradeTutorial = $this->gradeTutorialRepository->findWithoutFail($id);

        if (empty($gradeTutorial)) {
            return $this->sendError('Grade Tutorial not found');
        }

        $gradeTutorial->delete();

        return $this->sendResponse($id, 'Grade Tutorial deleted successfully');
    }
}
