<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCategoryTestAPIRequest;
use App\Http\Requests\API\UpdateCategoryTestAPIRequest;
use App\Models\CategoryTest;
use App\Repositories\CategoryTestRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CategoryTestController
 * @package App\Http\Controllers\API
 */

class CategoryTestAPIController extends AppBaseController
{
    /** @var  CategoryTestRepository */
    private $categoryTestRepository;

    public function __construct(CategoryTestRepository $categoryTestRepo)
    {
        $this->categoryTestRepository = $categoryTestRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/categoryTests",
     *      summary="Get a listing of the CategoryTests.",
     *      tags={"CategoryTest"},
     *      description="Get all CategoryTests",
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
     *                  @SWG\Items(ref="#/definitions/CategoryTest")
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
        $this->categoryTestRepository->pushCriteria(new RequestCriteria($request));
        $this->categoryTestRepository->pushCriteria(new LimitOffsetCriteria($request));
        $categoryTests = $this->categoryTestRepository->all();

        return $this->sendResponse($categoryTests->toArray(), 'Category Tests retrieved successfully');
    }

    /**
     * @param CreateCategoryTestAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/categoryTests",
     *      summary="Store a newly created CategoryTest in storage",
     *      tags={"CategoryTest"},
     *      description="Store CategoryTest",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CategoryTest that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CategoryTest")
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
     *                  ref="#/definitions/CategoryTest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCategoryTestAPIRequest $request)
    {
        $input = $request->all();

        $categoryTests = $this->categoryTestRepository->create($input);

        return $this->sendResponse($categoryTests->toArray(), 'Category Test saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/categoryTests/{id}",
     *      summary="Display the specified CategoryTest",
     *      tags={"CategoryTest"},
     *      description="Get CategoryTest",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CategoryTest",
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
     *                  ref="#/definitions/CategoryTest"
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
        /** @var CategoryTest $categoryTest */
        $categoryTest = $this->categoryTestRepository->findWithoutFail($id);

        if (empty($categoryTest)) {
            return $this->sendError('Category Test not found');
        }

        return $this->sendResponse($categoryTest->toArray(), 'Category Test retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCategoryTestAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/categoryTests/{id}",
     *      summary="Update the specified CategoryTest in storage",
     *      tags={"CategoryTest"},
     *      description="Update CategoryTest",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CategoryTest",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CategoryTest that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CategoryTest")
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
     *                  ref="#/definitions/CategoryTest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCategoryTestAPIRequest $request)
    {
        $input = $request->all();

        /** @var CategoryTest $categoryTest */
        $categoryTest = $this->categoryTestRepository->findWithoutFail($id);

        if (empty($categoryTest)) {
            return $this->sendError('Category Test not found');
        }

        $categoryTest = $this->categoryTestRepository->update($input, $id);

        return $this->sendResponse($categoryTest->toArray(), 'CategoryTest updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/categoryTests/{id}",
     *      summary="Remove the specified CategoryTest from storage",
     *      tags={"CategoryTest"},
     *      description="Delete CategoryTest",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CategoryTest",
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
        /** @var CategoryTest $categoryTest */
        $categoryTest = $this->categoryTestRepository->findWithoutFail($id);

        if (empty($categoryTest)) {
            return $this->sendError('Category Test not found');
        }

        $categoryTest->delete();

        return $this->sendResponse($id, 'Category Test deleted successfully');
    }
}
