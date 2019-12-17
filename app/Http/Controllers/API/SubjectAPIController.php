<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSubjectAPIRequest;
use App\Http\Requests\API\UpdateSubjectAPIRequest;
use App\Models\Subject;
use App\Repositories\SubjectRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class SubjectController
 * @package App\Http\Controllers\API
 */

class SubjectAPIController extends AppBaseController
{
    /** @var  SubjectRepository */
    private $subjectRepository;

    public function __construct(SubjectRepository $subjectRepo)
    {
        $this->subjectRepository = $subjectRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/subjects",
     *      summary="Get a listing of the Subjects.",
     *      tags={"Subject"},
     *      description="Get all Subjects",
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
     *                  @SWG\Items(ref="#/definitions/Subject")
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
        $this->subjectRepository->pushCriteria(new RequestCriteria($request));
        $this->subjectRepository->pushCriteria(new LimitOffsetCriteria($request));
        $subjects = $this->subjectRepository->all();

        return $this->sendResponse($subjects->toArray(), 'Subjects retrieved successfully');
    }

    /**
     * @param CreateSubjectAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/subjects",
     *      summary="Store a newly created Subject in storage",
     *      tags={"Subject"},
     *      description="Store Subject",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Subject that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Subject")
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
     *                  ref="#/definitions/Subject"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSubjectAPIRequest $request)
    {
        $input = $request->all();

        $subjects = $this->subjectRepository->create($input);

        return $this->sendResponse($subjects->toArray(), 'Subject saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/subjects/{id}",
     *      summary="Display the specified Subject",
     *      tags={"Subject"},
     *      description="Get Subject",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Subject",
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
     *                  ref="#/definitions/Subject"
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
        /** @var Subject $subject */
        $subject = $this->subjectRepository->findWithoutFail($id);

        if (empty($subject)) {
            return $this->sendError('Subject not found');
        }

        return $this->sendResponse($subject->toArray(), 'Subject retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSubjectAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/subjects/{id}",
     *      summary="Update the specified Subject in storage",
     *      tags={"Subject"},
     *      description="Update Subject",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Subject",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Subject that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Subject")
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
     *                  ref="#/definitions/Subject"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSubjectAPIRequest $request)
    {
        $input = $request->all();

        /** @var Subject $subject */
        $subject = $this->subjectRepository->findWithoutFail($id);

        if (empty($subject)) {
            return $this->sendError('Subject not found');
        }

        $subject = $this->subjectRepository->update($input, $id);

        return $this->sendResponse($subject->toArray(), 'Subject updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/subjects/{id}",
     *      summary="Remove the specified Subject from storage",
     *      tags={"Subject"},
     *      description="Delete Subject",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Subject",
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
        /** @var Subject $subject */
        $subject = $this->subjectRepository->findWithoutFail($id);

        if (empty($subject)) {
            return $this->sendError('Subject not found');
        }

        $subject->delete();

        return $this->sendResponse($id, 'Subject deleted successfully');
    }
}
