<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCategoryNewsAPIRequest;
use App\Http\Requests\API\UpdateCategoryNewsAPIRequest;
use App\Models\CategoryNews;
use App\Repositories\CategoryNewsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CategoryNewsController
 * @package App\Http\Controllers\API
 */

class CategoryNewsAPIController extends AppBaseController
{
    /** @var  CategoryNewsRepository */
    private $categoryNewsRepository;

    public function __construct(CategoryNewsRepository $categoryNewsRepo)
    {
        $this->categoryNewsRepository = $categoryNewsRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/categoryNews",
     *      summary="Get a listing of the CategoryNews.",
     *      tags={"CategoryNews"},
     *      description="Get all CategoryNews",
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
     *                  @SWG\Items(ref="#/definitions/CategoryNews")
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
        $this->categoryNewsRepository->pushCriteria(new RequestCriteria($request));
        $this->categoryNewsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $categoryNews = $this->categoryNewsRepository->all();

        return $this->sendResponse($categoryNews->toArray(), 'Category News retrieved successfully');
    }

    /**
     * @param CreateCategoryNewsAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/categoryNews",
     *      summary="Store a newly created CategoryNews in storage",
     *      tags={"CategoryNews"},
     *      description="Store CategoryNews",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CategoryNews that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CategoryNews")
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
     *                  ref="#/definitions/CategoryNews"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCategoryNewsAPIRequest $request)
    {
        $input = $request->all();

        $categoryNews = $this->categoryNewsRepository->create($input);

        return $this->sendResponse($categoryNews->toArray(), 'Category News saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/categoryNews/{id}",
     *      summary="Display the specified CategoryNews",
     *      tags={"CategoryNews"},
     *      description="Get CategoryNews",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CategoryNews",
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
     *                  ref="#/definitions/CategoryNews"
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
        /** @var CategoryNews $categoryNews */
        $categoryNews = $this->categoryNewsRepository->findWithoutFail($id);

        if (empty($categoryNews)) {
            return $this->sendError('Category News not found');
        }

        return $this->sendResponse($categoryNews->toArray(), 'Category News retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCategoryNewsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/categoryNews/{id}",
     *      summary="Update the specified CategoryNews in storage",
     *      tags={"CategoryNews"},
     *      description="Update CategoryNews",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CategoryNews",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CategoryNews that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CategoryNews")
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
     *                  ref="#/definitions/CategoryNews"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCategoryNewsAPIRequest $request)
    {
        $input = $request->all();

        /** @var CategoryNews $categoryNews */
        $categoryNews = $this->categoryNewsRepository->findWithoutFail($id);

        if (empty($categoryNews)) {
            return $this->sendError('Category News not found');
        }

        $categoryNews = $this->categoryNewsRepository->update($input, $id);

        return $this->sendResponse($categoryNews->toArray(), 'CategoryNews updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/categoryNews/{id}",
     *      summary="Remove the specified CategoryNews from storage",
     *      tags={"CategoryNews"},
     *      description="Delete CategoryNews",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CategoryNews",
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
        /** @var CategoryNews $categoryNews */
        $categoryNews = $this->categoryNewsRepository->findWithoutFail($id);

        if (empty($categoryNews)) {
            return $this->sendError('Category News not found');
        }

        $categoryNews->delete();

        return $this->sendResponse($id, 'Category News deleted successfully');
    }
}
