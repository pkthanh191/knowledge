<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCoefficientAPIRequest;
use App\Http\Requests\API\UpdateCoefficientAPIRequest;
use App\Models\Coefficient;
use App\Repositories\CoefficientRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CoefficientController
 * @package App\Http\Controllers\API
 */

class CoefficientAPIController extends AppBaseController
{
    /** @var  CoefficientRepository */
    private $coefficientRepository;

    public function __construct(CoefficientRepository $coefficientRepo)
    {
        $this->coefficientRepository = $coefficientRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/coefficients",
     *      summary="Get a listing of the Coefficients.",
     *      tags={"Coefficient"},
     *      description="Get all Coefficients",
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
     *                  @SWG\Items(ref="#/definitions/Coefficient")
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
        $this->coefficientRepository->pushCriteria(new RequestCriteria($request));
        $this->coefficientRepository->pushCriteria(new LimitOffsetCriteria($request));
        $coefficients = $this->coefficientRepository->all();

        return $this->sendResponse($coefficients->toArray(), 'Coefficients retrieved successfully');
    }

    /**
     * @param CreateCoefficientAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/coefficients",
     *      summary="Store a newly created Coefficient in storage",
     *      tags={"Coefficient"},
     *      description="Store Coefficient",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Coefficient that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Coefficient")
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
     *                  ref="#/definitions/Coefficient"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCoefficientAPIRequest $request)
    {
        $input = $request->all();

        $coefficients = $this->coefficientRepository->create($input);

        return $this->sendResponse($coefficients->toArray(), 'Coefficient saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/coefficients/{id}",
     *      summary="Display the specified Coefficient",
     *      tags={"Coefficient"},
     *      description="Get Coefficient",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Coefficient",
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
     *                  ref="#/definitions/Coefficient"
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
        /** @var Coefficient $coefficient */
        $coefficient = $this->coefficientRepository->findWithoutFail($id);

        if (empty($coefficient)) {
            return $this->sendError('Coefficient not found');
        }

        return $this->sendResponse($coefficient->toArray(), 'Coefficient retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCoefficientAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/coefficients/{id}",
     *      summary="Update the specified Coefficient in storage",
     *      tags={"Coefficient"},
     *      description="Update Coefficient",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Coefficient",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Coefficient that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Coefficient")
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
     *                  ref="#/definitions/Coefficient"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCoefficientAPIRequest $request)
    {
        $input = $request->all();

        /** @var Coefficient $coefficient */
        $coefficient = $this->coefficientRepository->findWithoutFail($id);

        if (empty($coefficient)) {
            return $this->sendError('Coefficient not found');
        }

        $coefficient = $this->coefficientRepository->update($input, $id);

        return $this->sendResponse($coefficient->toArray(), 'Coefficient updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/coefficients/{id}",
     *      summary="Remove the specified Coefficient from storage",
     *      tags={"Coefficient"},
     *      description="Delete Coefficient",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Coefficient",
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
        /** @var Coefficient $coefficient */
        $coefficient = $this->coefficientRepository->findWithoutFail($id);

        if (empty($coefficient)) {
            return $this->sendError('Coefficient not found');
        }

        $coefficient->delete();

        return $this->sendResponse($id, 'Coefficient deleted successfully');
    }
}
