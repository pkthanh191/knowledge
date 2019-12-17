<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCategoryDocMetaAPIRequest;
use App\Http\Requests\API\UpdateCategoryDocMetaAPIRequest;
use App\Models\CategoryDocMeta;
use App\Repositories\CategoryDocMetaRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CategoryDocMetaController
 * @package App\Http\Controllers\API
 */

class CategoryDocMetaAPIController extends AppBaseController
{
    /** @var  CategoryDocMetaRepository */
    private $categoryDocMetaRepository;

    public function __construct(CategoryDocMetaRepository $categoryDocMetaRepo)
    {
        $this->categoryDocMetaRepository = $categoryDocMetaRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/categoryDocMetas",
     *      summary="Get a listing of the CategoryDocMetas.",
     *      tags={"CategoryDocMeta"},
     *      description="Get all CategoryDocMetas",
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
     *                  @SWG\Items(ref="#/definitions/CategoryDocMeta")
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
        $this->categoryDocMetaRepository->pushCriteria(new RequestCriteria($request));
        $this->categoryDocMetaRepository->pushCriteria(new LimitOffsetCriteria($request));
        $categoryDocMetas = $this->categoryDocMetaRepository->all();

        return $this->sendResponse($categoryDocMetas->toArray(), 'Category Doc Metas retrieved successfully');
    }

    /**
     * @param CreateCategoryDocMetaAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/categoryDocMetas",
     *      summary="Store a newly created CategoryDocMeta in storage",
     *      tags={"CategoryDocMeta"},
     *      description="Store CategoryDocMeta",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CategoryDocMeta that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CategoryDocMeta")
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
     *                  ref="#/definitions/CategoryDocMeta"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCategoryDocMetaAPIRequest $request)
    {
        $input = $request->all();

        $categoryDocMetas = $this->categoryDocMetaRepository->create($input);

        return $this->sendResponse($categoryDocMetas->toArray(), 'Category Doc Meta saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/categoryDocMetas/{id}",
     *      summary="Display the specified CategoryDocMeta",
     *      tags={"CategoryDocMeta"},
     *      description="Get CategoryDocMeta",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CategoryDocMeta",
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
     *                  ref="#/definitions/CategoryDocMeta"
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
        /** @var CategoryDocMeta $categoryDocMeta */
        $categoryDocMeta = $this->categoryDocMetaRepository->findWithoutFail($id);

        if (empty($categoryDocMeta)) {
            return $this->sendError('Category Doc Meta not found');
        }

        return $this->sendResponse($categoryDocMeta->toArray(), 'Category Doc Meta retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCategoryDocMetaAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/categoryDocMetas/{id}",
     *      summary="Update the specified CategoryDocMeta in storage",
     *      tags={"CategoryDocMeta"},
     *      description="Update CategoryDocMeta",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CategoryDocMeta",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CategoryDocMeta that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CategoryDocMeta")
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
     *                  ref="#/definitions/CategoryDocMeta"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCategoryDocMetaAPIRequest $request)
    {
        $input = $request->all();

        /** @var CategoryDocMeta $categoryDocMeta */
        $categoryDocMeta = $this->categoryDocMetaRepository->findWithoutFail($id);

        if (empty($categoryDocMeta)) {
            return $this->sendError('Category Doc Meta not found');
        }

        $categoryDocMeta = $this->categoryDocMetaRepository->update($input, $id);

        return $this->sendResponse($categoryDocMeta->toArray(), 'CategoryDocMeta updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/categoryDocMetas/{id}",
     *      summary="Remove the specified CategoryDocMeta from storage",
     *      tags={"CategoryDocMeta"},
     *      description="Delete CategoryDocMeta",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CategoryDocMeta",
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
        /** @var CategoryDocMeta $categoryDocMeta */
        $categoryDocMeta = $this->categoryDocMetaRepository->findWithoutFail($id);

        if (empty($categoryDocMeta)) {
            return $this->sendError('Category Doc Meta not found');
        }

        $categoryDocMeta->delete();

        return $this->sendResponse($id, 'Category Doc Meta deleted successfully');
    }
}
