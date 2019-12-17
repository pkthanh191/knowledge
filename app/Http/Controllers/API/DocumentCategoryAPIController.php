<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDocumentCategoryAPIRequest;
use App\Http\Requests\API\UpdateDocumentCategoryAPIRequest;
use App\Models\DocumentCategory;
use App\Repositories\DocumentCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class DocumentCategoryController
 * @package App\Http\Controllers\API
 */

class DocumentCategoryAPIController extends AppBaseController
{
    /** @var  DocumentCategoryRepository */
    private $documentCategoryRepository;

    public function __construct(DocumentCategoryRepository $documentCategoryRepo)
    {
        $this->documentCategoryRepository = $documentCategoryRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/documentCategories",
     *      summary="Get a listing of the DocumentCategories.",
     *      tags={"DocumentCategory"},
     *      description="Get all DocumentCategories",
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
     *                  @SWG\Items(ref="#/definitions/DocumentCategory")
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
        $this->documentCategoryRepository->pushCriteria(new RequestCriteria($request));
        $this->documentCategoryRepository->pushCriteria(new LimitOffsetCriteria($request));
        $documentCategories = $this->documentCategoryRepository->all();

        return $this->sendResponse($documentCategories->toArray(), 'Document Categories retrieved successfully');
    }

    /**
     * @param CreateDocumentCategoryAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/documentCategories",
     *      summary="Store a newly created DocumentCategory in storage",
     *      tags={"DocumentCategory"},
     *      description="Store DocumentCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="DocumentCategory that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/DocumentCategory")
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
     *                  ref="#/definitions/DocumentCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateDocumentCategoryAPIRequest $request)
    {
        $input = $request->all();

        $documentCategories = $this->documentCategoryRepository->create($input);

        return $this->sendResponse($documentCategories->toArray(), 'Document Category saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/documentCategories/{id}",
     *      summary="Display the specified DocumentCategory",
     *      tags={"DocumentCategory"},
     *      description="Get DocumentCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DocumentCategory",
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
     *                  ref="#/definitions/DocumentCategory"
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
        /** @var DocumentCategory $documentCategory */
        $documentCategory = $this->documentCategoryRepository->findWithoutFail($id);

        if (empty($documentCategory)) {
            return $this->sendError('Document Category not found');
        }

        return $this->sendResponse($documentCategory->toArray(), 'Document Category retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateDocumentCategoryAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/documentCategories/{id}",
     *      summary="Update the specified DocumentCategory in storage",
     *      tags={"DocumentCategory"},
     *      description="Update DocumentCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DocumentCategory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="DocumentCategory that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/DocumentCategory")
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
     *                  ref="#/definitions/DocumentCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateDocumentCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var DocumentCategory $documentCategory */
        $documentCategory = $this->documentCategoryRepository->findWithoutFail($id);

        if (empty($documentCategory)) {
            return $this->sendError('Document Category not found');
        }

        $documentCategory = $this->documentCategoryRepository->update($input, $id);

        return $this->sendResponse($documentCategory->toArray(), 'DocumentCategory updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/documentCategories/{id}",
     *      summary="Remove the specified DocumentCategory from storage",
     *      tags={"DocumentCategory"},
     *      description="Delete DocumentCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DocumentCategory",
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
        /** @var DocumentCategory $documentCategory */
        $documentCategory = $this->documentCategoryRepository->findWithoutFail($id);

        if (empty($documentCategory)) {
            return $this->sendError('Document Category not found');
        }

        $documentCategory->delete();

        return $this->sendResponse($id, 'Document Category deleted successfully');
    }

}
