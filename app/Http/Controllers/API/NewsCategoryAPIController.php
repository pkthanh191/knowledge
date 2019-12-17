<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateNewsCategoryAPIRequest;
use App\Http\Requests\API\UpdateNewsCategoryAPIRequest;
use App\Models\NewsCategory;
use App\Repositories\NewsCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class NewsCategoryController
 * @package App\Http\Controllers\API
 */

class NewsCategoryAPIController extends AppBaseController
{
    /** @var  NewsCategoryRepository */
    private $newsCategoryRepository;

    public function __construct(NewsCategoryRepository $newsCategoryRepo)
    {
        $this->newsCategoryRepository = $newsCategoryRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/newsCategories",
     *      summary="Get a listing of the NewsCategories.",
     *      tags={"NewsCategory"},
     *      description="Get all NewsCategories",
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
     *                  @SWG\Items(ref="#/definitions/NewsCategory")
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
        $this->newsCategoryRepository->pushCriteria(new RequestCriteria($request));
        $this->newsCategoryRepository->pushCriteria(new LimitOffsetCriteria($request));
        $newsCategories = $this->newsCategoryRepository->all();

        return $this->sendResponse($newsCategories->toArray(), 'News Categories retrieved successfully');
    }

    /**
     * @param CreateNewsCategoryAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/newsCategories",
     *      summary="Store a newly created NewsCategory in storage",
     *      tags={"NewsCategory"},
     *      description="Store NewsCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="NewsCategory that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/NewsCategory")
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
     *                  ref="#/definitions/NewsCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateNewsCategoryAPIRequest $request)
    {
        $input = $request->all();

        $newsCategories = $this->newsCategoryRepository->create($input);

        return $this->sendResponse($newsCategories->toArray(), 'News Category saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/newsCategories/{id}",
     *      summary="Display the specified NewsCategory",
     *      tags={"NewsCategory"},
     *      description="Get NewsCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NewsCategory",
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
     *                  ref="#/definitions/NewsCategory"
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
        /** @var NewsCategory $newsCategory */
        $newsCategory = $this->newsCategoryRepository->findWithoutFail($id);

        if (empty($newsCategory)) {
            return $this->sendError('News Category not found');
        }

        return $this->sendResponse($newsCategory->toArray(), 'News Category retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateNewsCategoryAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/newsCategories/{id}",
     *      summary="Update the specified NewsCategory in storage",
     *      tags={"NewsCategory"},
     *      description="Update NewsCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NewsCategory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="NewsCategory that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/NewsCategory")
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
     *                  ref="#/definitions/NewsCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateNewsCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var NewsCategory $newsCategory */
        $newsCategory = $this->newsCategoryRepository->findWithoutFail($id);

        if (empty($newsCategory)) {
            return $this->sendError('News Category not found');
        }

        $newsCategory = $this->newsCategoryRepository->update($input, $id);

        return $this->sendResponse($newsCategory->toArray(), 'NewsCategory updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/newsCategories/{id}",
     *      summary="Remove the specified NewsCategory from storage",
     *      tags={"NewsCategory"},
     *      description="Delete NewsCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NewsCategory",
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
        /** @var NewsCategory $newsCategory */
        $newsCategory = $this->newsCategoryRepository->findWithoutFail($id);

        if (empty($newsCategory)) {
            return $this->sendError('News Category not found');
        }

        $newsCategory->delete();

        return $this->sendResponse($id, 'News Category deleted successfully');
    }
}
