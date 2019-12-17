<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDocumentMetaValueAPIRequest;
use App\Http\Requests\API\UpdateDocumentMetaValueAPIRequest;
use App\Models\DocumentMetaValue;
use App\Repositories\DocumentMetaValueRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class DocumentMetaValueController
 * @package App\Http\Controllers\API
 */

class DocumentMetaValueAPIController extends AppBaseController
{
    /** @var  DocumentMetaValueRepository */
    private $documentMetaValueRepository;

    public function __construct(DocumentMetaValueRepository $documentMetaValueRepo)
    {
        $this->documentMetaValueRepository = $documentMetaValueRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/documentMetaValues",
     *      summary="Get a listing of the DocumentMetaValues.",
     *      tags={"DocumentMetaValue"},
     *      description="Get all DocumentMetaValues",
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
     *                  @SWG\Items(ref="#/definitions/DocumentMetaValue")
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
        $this->documentMetaValueRepository->pushCriteria(new RequestCriteria($request));
        $this->documentMetaValueRepository->pushCriteria(new LimitOffsetCriteria($request));
        $documentMetaValues = $this->documentMetaValueRepository->all();

        return $this->sendResponse($documentMetaValues->toArray(), 'Document Meta Values retrieved successfully');
    }

    /**
     * @param CreateDocumentMetaValueAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/documentMetaValues",
     *      summary="Store a newly created DocumentMetaValue in storage",
     *      tags={"DocumentMetaValue"},
     *      description="Store DocumentMetaValue",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="DocumentMetaValue that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/DocumentMetaValue")
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
     *                  ref="#/definitions/DocumentMetaValue"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateDocumentMetaValueAPIRequest $request)
    {
        $input = $request->all();

        $documentMetaValues = $this->documentMetaValueRepository->create($input);

        return $this->sendResponse($documentMetaValues->toArray(), 'Document Meta Value saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/documentMetaValues/{id}",
     *      summary="Display the specified DocumentMetaValue",
     *      tags={"DocumentMetaValue"},
     *      description="Get DocumentMetaValue",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DocumentMetaValue",
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
     *                  ref="#/definitions/DocumentMetaValue"
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
        /** @var DocumentMetaValue $documentMetaValue */
        $documentMetaValue = $this->documentMetaValueRepository->findWithoutFail($id);

        if (empty($documentMetaValue)) {
            return $this->sendError('Document Meta Value not found');
        }

        return $this->sendResponse($documentMetaValue->toArray(), 'Document Meta Value retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateDocumentMetaValueAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/documentMetaValues/{id}",
     *      summary="Update the specified DocumentMetaValue in storage",
     *      tags={"DocumentMetaValue"},
     *      description="Update DocumentMetaValue",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DocumentMetaValue",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="DocumentMetaValue that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/DocumentMetaValue")
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
     *                  ref="#/definitions/DocumentMetaValue"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateDocumentMetaValueAPIRequest $request)
    {
        $input = $request->all();

        /** @var DocumentMetaValue $documentMetaValue */
        $documentMetaValue = $this->documentMetaValueRepository->findWithoutFail($id);

        if (empty($documentMetaValue)) {
            return $this->sendError('Document Meta Value not found');
        }

        $documentMetaValue = $this->documentMetaValueRepository->update($input, $id);

        return $this->sendResponse($documentMetaValue->toArray(), 'DocumentMetaValue updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/documentMetaValues/{id}",
     *      summary="Remove the specified DocumentMetaValue from storage",
     *      tags={"DocumentMetaValue"},
     *      description="Delete DocumentMetaValue",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DocumentMetaValue",
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
        /** @var DocumentMetaValue $documentMetaValue */
        $documentMetaValue = $this->documentMetaValueRepository->findWithoutFail($id);

        if (empty($documentMetaValue)) {
            return $this->sendError('Document Meta Value not found');
        }

        $documentMetaValue->delete();

        return $this->sendResponse($id, 'Document Meta Value deleted successfully');
    }
}
