<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCommentTestAPIRequest;
use App\Http\Requests\API\UpdateCommentTestAPIRequest;
use App\Models\CommentTest;
use App\Repositories\CommentTestRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CommentTestController
 * @package App\Http\Controllers\API
 */

class CommentTestAPIController extends AppBaseController
{
    /** @var  CommentTestRepository */
    private $commentTestRepository;

    public function __construct(CommentTestRepository $commentTestRepo)
    {
        $this->commentTestRepository = $commentTestRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/commentTests",
     *      summary="Get a listing of the CommentTests.",
     *      tags={"CommentTest"},
     *      description="Get all CommentTests",
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
     *                  @SWG\Items(ref="#/definitions/CommentTest")
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
        $this->commentTestRepository->pushCriteria(new RequestCriteria($request));
        $this->commentTestRepository->pushCriteria(new LimitOffsetCriteria($request));
        $commentTests = $this->commentTestRepository->all();

        return $this->sendResponse($commentTests->toArray(), 'Comment Tests retrieved successfully');
    }

    /**
     * @param CreateCommentTestAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/commentTests",
     *      summary="Store a newly created CommentTest in storage",
     *      tags={"CommentTest"},
     *      description="Store CommentTest",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CommentTest that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CommentTest")
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
     *                  ref="#/definitions/CommentTest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCommentTestAPIRequest $request)
    {
        $input = $request->all();

        $commentTests = $this->commentTestRepository->create($input);

        return $this->sendResponse($commentTests->toArray(), 'Comment Test saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/commentTests/{id}",
     *      summary="Display the specified CommentTest",
     *      tags={"CommentTest"},
     *      description="Get CommentTest",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CommentTest",
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
     *                  ref="#/definitions/CommentTest"
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
        /** @var CommentTest $commentTest */
        $commentTest = $this->commentTestRepository->findWithoutFail($id);

        if (empty($commentTest)) {
            return $this->sendError('Comment Test not found');
        }

        return $this->sendResponse($commentTest->toArray(), 'Comment Test retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCommentTestAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/commentTests/{id}",
     *      summary="Update the specified CommentTest in storage",
     *      tags={"CommentTest"},
     *      description="Update CommentTest",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CommentTest",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CommentTest that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CommentTest")
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
     *                  ref="#/definitions/CommentTest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCommentTestAPIRequest $request)
    {
        $input = $request->all();

        /** @var CommentTest $commentTest */
        $commentTest = $this->commentTestRepository->findWithoutFail($id);

        if (empty($commentTest)) {
            return $this->sendError('Comment Test not found');
        }

        $commentTest = $this->commentTestRepository->update($input, $id);

        return $this->sendResponse($commentTest->toArray(), 'CommentTest updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/commentTests/{id}",
     *      summary="Remove the specified CommentTest from storage",
     *      tags={"CommentTest"},
     *      description="Delete CommentTest",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CommentTest",
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
        /** @var CommentTest $commentTest */
        $commentTest = $this->commentTestRepository->findWithoutFail($id);

        if (empty($commentTest)) {
            return $this->sendError('Comment Test not found');
        }

        $commentTest->delete();

        return $this->sendResponse($id, 'Comment Test deleted successfully');
    }
}
