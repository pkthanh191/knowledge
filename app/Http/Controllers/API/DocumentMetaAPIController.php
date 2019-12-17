<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDocumentMetaAPIRequest;
use App\Http\Requests\API\UpdateDocumentMetaAPIRequest;
use App\Models\DocumentMeta;
use App\Repositories\DocumentMetaRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class DocumentMetaController
 * @package App\Http\Controllers\API
 */

class DocumentMetaAPIController extends AppBaseController
{
    /** @var  DocumentMetaRepository */
    private $documentMetaRepository;

    public function __construct(DocumentMetaRepository $documentMetaRepo)
    {
        $this->documentMetaRepository = $documentMetaRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/documentMetas",
     *      summary="Get a listing of the DocumentMetas.",
     *      tags={"DocumentMeta"},
     *      description="Get all DocumentMetas",
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
     *                  @SWG\Items(ref="#/definitions/DocumentMeta")
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
        $this->documentMetaRepository->pushCriteria(new RequestCriteria($request));
        $this->documentMetaRepository->pushCriteria(new LimitOffsetCriteria($request));
        $documentMetas = $this->documentMetaRepository->all();

        return $this->sendResponse($documentMetas->toArray(), 'Document Metas retrieved successfully');
    }

    /**
     * @param CreateDocumentMetaAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/documentMetas",
     *      summary="Store a newly created DocumentMeta in storage",
     *      tags={"DocumentMeta"},
     *      description="Store DocumentMeta",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="DocumentMeta that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/DocumentMeta")
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
     *                  ref="#/definitions/DocumentMeta"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateDocumentMetaAPIRequest $request)
    {
        $input = $request->all();

        $documentMetas = $this->documentMetaRepository->create($input);

        return $this->sendResponse($documentMetas->toArray(), 'Document Meta saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/documentMetas/{id}",
     *      summary="Display the specified DocumentMeta",
     *      tags={"DocumentMeta"},
     *      description="Get DocumentMeta",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DocumentMeta",
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
     *                  ref="#/definitions/DocumentMeta"
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
        /** @var DocumentMeta $documentMeta */
        $documentMeta = $this->documentMetaRepository->findWithoutFail($id);

        if (empty($documentMeta)) {
            return $this->sendError('Document Meta not found');
        }

        return $this->sendResponse($documentMeta->toArray(), 'Document Meta retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateDocumentMetaAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/documentMetas/{id}",
     *      summary="Update the specified DocumentMeta in storage",
     *      tags={"DocumentMeta"},
     *      description="Update DocumentMeta",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DocumentMeta",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="DocumentMeta that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/DocumentMeta")
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
     *                  ref="#/definitions/DocumentMeta"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateDocumentMetaAPIRequest $request)
    {
        $input = $request->all();

        /** @var DocumentMeta $documentMeta */
        $documentMeta = $this->documentMetaRepository->findWithoutFail($id);

        if (empty($documentMeta)) {
            return $this->sendError('Document Meta not found');
        }

        $documentMeta = $this->documentMetaRepository->update($input, $id);

        return $this->sendResponse($documentMeta->toArray(), 'DocumentMeta updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/documentMetas/{id}",
     *      summary="Remove the specified DocumentMeta from storage",
     *      tags={"DocumentMeta"},
     *      description="Delete DocumentMeta",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DocumentMeta",
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
        /** @var DocumentMeta $documentMeta */
        $documentMeta = $this->documentMetaRepository->findWithoutFail($id);

        if (empty($documentMeta)) {
            return $this->sendError('Document Meta not found');
        }

        $documentMeta->delete();

        return $this->sendResponse($id, 'Document Meta deleted successfully');
    }



    public function getDocumentMeta($id)
    {
        /** @var DocumentMeta $documentMeta */
        $documentMeta = $this->documentMetaRepository->orderBy('orderSort','asc')->findByField('category_doc_meta_id', $id);
        if (empty($documentMeta)) {
            return $this->sendError('Document Meta not found');
        }

        return $this->sendResponse($documentMeta->toArray(), 'Document Meta retrieved successfully');
    }
}
