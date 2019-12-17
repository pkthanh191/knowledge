<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCommentNewsAPIRequest;
use App\Http\Requests\API\UpdateCommentNewsAPIRequest;
use App\Models\CommentNews;
use App\Repositories\CommentNewsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CommentNewsController
 * @package App\Http\Controllers\API
 */

class CommentNewsAPIController extends AppBaseController
{
    /** @var  CommentNewsRepository */
    private $commentNewsRepository;

    public function __construct(CommentNewsRepository $commentNewsRepo)
    {
        $this->commentNewsRepository = $commentNewsRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/commentNews",
     *      summary="Get a listing of the CommentNews.",
     *      tags={"CommentNews"},
     *      description="Get all CommentNews",
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
     *                  @SWG\Items(ref="#/definitions/CommentNews")
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
        $this->commentNewsRepository->pushCriteria(new RequestCriteria($request));
        $this->commentNewsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $commentNews = $this->commentNewsRepository->all();

        return $this->sendResponse($commentNews->toArray(), 'Comment News retrieved successfully');
    }

    /**
     * @param CreateCommentNewsAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/commentNews",
     *      summary="Store a newly created CommentNews in storage",
     *      tags={"CommentNews"},
     *      description="Store CommentNews",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CommentNews that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CommentNews")
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
     *                  ref="#/definitions/CommentNews"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCommentNewsAPIRequest $request)
    {
        $input = $request->all();

        $commentNews = $this->commentNewsRepository->create($input);

        return $this->sendResponse($commentNews->toArray(), 'Comment News saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/commentNews/{id}",
     *      summary="Display the specified CommentNews",
     *      tags={"CommentNews"},
     *      description="Get CommentNews",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CommentNews",
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
     *                  ref="#/definitions/CommentNews"
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
        /** @var CommentNews $commentNews */
        $commentNews = $this->commentNewsRepository->findWithoutFail($id);

        if (empty($commentNews)) {
            return $this->sendError('Comment News not found');
        }

        return $this->sendResponse($commentNews->toArray(), 'Comment News retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCommentNewsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/commentNews/{id}",
     *      summary="Update the specified CommentNews in storage",
     *      tags={"CommentNews"},
     *      description="Update CommentNews",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CommentNews",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CommentNews that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CommentNews")
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
     *                  ref="#/definitions/CommentNews"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCommentNewsAPIRequest $request)
    {
        $input = $request->all();

        /** @var CommentNews $commentNews */
        $commentNews = $this->commentNewsRepository->findWithoutFail($id);

        if (empty($commentNews)) {
            return $this->sendError('Comment News not found');
        }

        $commentNews = $this->commentNewsRepository->update($input, $id);

        return $this->sendResponse($commentNews->toArray(), 'CommentNews updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/commentNews/{id}",
     *      summary="Remove the specified CommentNews from storage",
     *      tags={"CommentNews"},
     *      description="Delete CommentNews",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CommentNews",
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
        /** @var CommentNews $commentNews */
        $commentNews = $this->commentNewsRepository->findWithoutFail($id);

        if (empty($commentNews)) {
            return $this->sendError('Comment News not found');
        }

        $commentNews->delete();

        return $this->sendResponse($id, 'Comment News deleted successfully');
    }
}
