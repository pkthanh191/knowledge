<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCategoryDocAPIRequest;
use App\Http\Requests\API\UpdateCategoryDocAPIRequest;
use App\Models\CategoryDoc;
use App\Repositories\CategoryDocRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CategoryDocController
 * @package App\Http\Controllers\API
 */

class CategoryDocAPIController extends AppBaseController
{
    /** @var  CategoryDocRepository */
    private $categoryDocRepository;

    public function __construct(CategoryDocRepository $categoryDocRepo)
    {
        $this->categoryDocRepository = $categoryDocRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/categoryDocs",
     *      summary="Get a listing of the CategoryDocs.",
     *      tags={"CategoryDoc"},
     *      description="Get all CategoryDocs",
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
     *                  @SWG\Items(ref="#/definitions/CategoryDoc")
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
        $this->categoryDocRepository->pushCriteria(new RequestCriteria($request));
        $this->categoryDocRepository->pushCriteria(new LimitOffsetCriteria($request));
        $categoryDocs = $this->categoryDocRepository->all();

        return $this->sendResponse($categoryDocs->toArray(), 'Category Docs retrieved successfully');
    }

    /**
     * @param CreateCategoryDocAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/categoryDocs",
     *      summary="Store a newly created CategoryDoc in storage",
     *      tags={"CategoryDoc"},
     *      description="Store CategoryDoc",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CategoryDoc that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CategoryDoc")
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
     *                  ref="#/definitions/CategoryDoc"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCategoryDocAPIRequest $request)
    {
        $input = $request->all();

        $categoryDocs = $this->categoryDocRepository->create($input);

        return $this->sendResponse($categoryDocs->toArray(), 'Category Doc saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/categoryDocs/{id}",
     *      summary="Display the specified CategoryDoc",
     *      tags={"CategoryDoc"},
     *      description="Get CategoryDoc",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CategoryDoc",
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
     *                  ref="#/definitions/CategoryDoc"
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
        /** @var CategoryDoc $categoryDoc */
        $categoryDoc = $this->categoryDocRepository->findWithoutFail($id);

        if (empty($categoryDoc)) {
            return $this->sendError('Category Doc not found');
        }

        return $this->sendResponse($categoryDoc->toArray(), 'Category Doc retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCategoryDocAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/categoryDocs/{id}",
     *      summary="Update the specified CategoryDoc in storage",
     *      tags={"CategoryDoc"},
     *      description="Update CategoryDoc",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CategoryDoc",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CategoryDoc that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CategoryDoc")
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
     *                  ref="#/definitions/CategoryDoc"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCategoryDocAPIRequest $request)
    {
        $input = $request->all();

        /** @var CategoryDoc $categoryDoc */
        $categoryDoc = $this->categoryDocRepository->findWithoutFail($id);

        if (empty($categoryDoc)) {
            return $this->sendError('Category Doc not found');
        }

        $categoryDoc = $this->categoryDocRepository->update($input, $id);

        return $this->sendResponse($categoryDoc->toArray(), 'CategoryDoc updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/categoryDocs/{id}",
     *      summary="Remove the specified CategoryDoc from storage",
     *      tags={"CategoryDoc"},
     *      description="Delete CategoryDoc",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CategoryDoc",
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
        /** @var CategoryDoc $categoryDoc */
        $categoryDoc = $this->categoryDocRepository->findWithoutFail($id);

        if (empty($categoryDoc)) {
            return $this->sendError('Category Doc not found');
        }

        $categoryDoc->delete();

        return $this->sendResponse($id, 'Category Doc deleted successfully');
    }

}
