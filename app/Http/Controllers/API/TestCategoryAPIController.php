<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTestCategoryAPIRequest;
use App\Http\Requests\API\UpdateTestCategoryAPIRequest;
use App\Models\TestCategory;
use App\Repositories\TestCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class TestCategoryController
 * @package App\Http\Controllers\API
 */

class TestCategoryAPIController extends AppBaseController
{
    /** @var  TestCategoryRepository */
    private $testCategoryRepository;

    public function __construct(TestCategoryRepository $testCategoryRepo)
    {
        $this->testCategoryRepository = $testCategoryRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/testCategories",
     *      summary="Get a listing of the TestCategories.",
     *      tags={"TestCategory"},
     *      description="Get all TestCategories",
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
     *                  @SWG\Items(ref="#/definitions/TestCategory")
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
        $this->testCategoryRepository->pushCriteria(new RequestCriteria($request));
        $this->testCategoryRepository->pushCriteria(new LimitOffsetCriteria($request));
        $testCategories = $this->testCategoryRepository->all();

        return $this->sendResponse($testCategories->toArray(), 'Test Categories retrieved successfully');
    }

    /**
     * @param CreateTestCategoryAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/testCategories",
     *      summary="Store a newly created TestCategory in storage",
     *      tags={"TestCategory"},
     *      description="Store TestCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="TestCategory that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/TestCategory")
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
     *                  ref="#/definitions/TestCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTestCategoryAPIRequest $request)
    {
        $input = $request->all();

        $testCategories = $this->testCategoryRepository->create($input);

        return $this->sendResponse($testCategories->toArray(), 'Test Category saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/testCategories/{id}",
     *      summary="Display the specified TestCategory",
     *      tags={"TestCategory"},
     *      description="Get TestCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of TestCategory",
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
     *                  ref="#/definitions/TestCategory"
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
        /** @var TestCategory $testCategory */
        $testCategory = $this->testCategoryRepository->findWithoutFail($id);

        if (empty($testCategory)) {
            return $this->sendError('Test Category not found');
        }

        return $this->sendResponse($testCategory->toArray(), 'Test Category retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateTestCategoryAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/testCategories/{id}",
     *      summary="Update the specified TestCategory in storage",
     *      tags={"TestCategory"},
     *      description="Update TestCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of TestCategory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="TestCategory that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/TestCategory")
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
     *                  ref="#/definitions/TestCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTestCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var TestCategory $testCategory */
        $testCategory = $this->testCategoryRepository->findWithoutFail($id);

        if (empty($testCategory)) {
            return $this->sendError('Test Category not found');
        }

        $testCategory = $this->testCategoryRepository->update($input, $id);

        return $this->sendResponse($testCategory->toArray(), 'TestCategory updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/testCategories/{id}",
     *      summary="Remove the specified TestCategory from storage",
     *      tags={"TestCategory"},
     *      description="Delete TestCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of TestCategory",
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
        /** @var TestCategory $testCategory */
        $testCategory = $this->testCategoryRepository->findWithoutFail($id);

        if (empty($testCategory)) {
            return $this->sendError('Test Category not found');
        }

        $testCategory->delete();

        return $this->sendResponse($id, 'Test Category deleted successfully');
    }
}
