<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTutorialAPIRequest;
use App\Http\Requests\API\UpdateTutorialAPIRequest;
use App\Models\Tutorial;
use App\Repositories\TutorialRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class TutorialController
 * @package App\Http\Controllers\API
 */

class TutorialAPIController extends AppBaseController
{
    /** @var  TutorialRepository */
    private $tutorialRepository;

    public function __construct(TutorialRepository $tutorialRepo)
    {
        $this->tutorialRepository = $tutorialRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/tutorials",
     *      summary="Get a listing of the Tutorials.",
     *      tags={"Tutorial"},
     *      description="Get all Tutorials",
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
     *                  @SWG\Items(ref="#/definitions/Tutorial")
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
        $this->tutorialRepository->pushCriteria(new RequestCriteria($request));
        $this->tutorialRepository->pushCriteria(new LimitOffsetCriteria($request));
        $tutorials = $this->tutorialRepository->all();

        return $this->sendResponse($tutorials->toArray(), 'Tutorials retrieved successfully');
    }

    /**
     * @param CreateTutorialAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/tutorials",
     *      summary="Store a newly created Tutorial in storage",
     *      tags={"Tutorial"},
     *      description="Store Tutorial",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Tutorial that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Tutorial")
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
     *                  ref="#/definitions/Tutorial"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTutorialAPIRequest $request)
    {
        $input = $request->all();

        $tutorials = $this->tutorialRepository->create($input);

        return $this->sendResponse($tutorials->toArray(), 'Tutorial saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/tutorials/{id}",
     *      summary="Display the specified Tutorial",
     *      tags={"Tutorial"},
     *      description="Get Tutorial",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Tutorial",
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
     *                  ref="#/definitions/Tutorial"
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
        /** @var Tutorial $tutorial */
        $tutorial = $this->tutorialRepository->findWithoutFail($id);

        if (empty($tutorial)) {
            return $this->sendError('Tutorial not found');
        }

        return $this->sendResponse($tutorial->toArray(), 'Tutorial retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateTutorialAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/tutorials/{id}",
     *      summary="Update the specified Tutorial in storage",
     *      tags={"Tutorial"},
     *      description="Update Tutorial",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Tutorial",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Tutorial that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Tutorial")
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
     *                  ref="#/definitions/Tutorial"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTutorialAPIRequest $request)
    {
        $input = $request->all();

        /** @var Tutorial $tutorial */
        $tutorial = $this->tutorialRepository->findWithoutFail($id);

        if (empty($tutorial)) {
            return $this->sendError('Tutorial not found');
        }

        $tutorial = $this->tutorialRepository->update($input, $id);

        return $this->sendResponse($tutorial->toArray(), 'Tutorial updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/tutorials/{id}",
     *      summary="Remove the specified Tutorial from storage",
     *      tags={"Tutorial"},
     *      description="Delete Tutorial",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Tutorial",
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
        /** @var Tutorial $tutorial */
        $tutorial = $this->tutorialRepository->findWithoutFail($id);

        if (empty($tutorial)) {
            return $this->sendError('Tutorial not found');
        }

        $tutorial->delete();

        return $this->sendResponse($id, 'Tutorial deleted successfully');
    }


    /**
     * @param int $id
     * @param UpdateTutorialAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/tutorials/{id}",
     *      summary="Update the specified Tutorial in storage",
     *      tags={"Tutorial"},
     *      description="Update Tutorial",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Tutorial",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Tutorial that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Tutorial")
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
     *                  ref="#/definitions/Tutorial"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function updateActive($id)
    {
        /** @var Tutorial $tutorial */
        $tutorial = $this->tutorialRepository->findWithoutFail($id);

        if (empty($tutorial)) {
            return $this->sendError('Tutorial not found');
        }
        if ($tutorial->active){
            $tutorial->active = 0;
        }else{
            $tutorial->active = 1;
        }

        $tutorial->save();

        $checkActive = true;

        $tutorials = $this->tutorialRepository->orderBy('updated_at','desc')->paginate(15);
        foreach ($tutorials as $value){
            if($value->active == 0){
                $checkActive = false;
            }
        }

        $responData = array_merge($tutorial->toArray(), ['checkActive'=>$checkActive]);
        return $this->sendResponse($responData, 'Tutorial updated successfully');
    }

    public function updateActiveAll(Request $request)
    {
        $ids = $request->tutorialIds;
        $activeType = $request->activeType;
        $result = [];
        array_push($result,["activeType" =>$activeType]);
        foreach ($ids as $id) {
            $tutorial = $this->tutorialRepository->findWithoutFail($id);

            if (empty($tutorial)) {
                return $this->sendError('Tutorial not found');
            }
            if($activeType == 1){
                $tutorial->active = 1;
            }else{
                $tutorial->active = 0;
            }

            $tutorial->save();
            array_push($result,$tutorial);
        }
        return $this->sendResponse($result,'Tutorial updated successfully');
    }

    public function updateConfirm($id)
    {
        /** @var Tutorial $tutorial */
        $tutorial = $this->tutorialRepository->findWithoutFail($id);

        if (empty($tutorial)) {
            return $this->sendError('Tutorial not found');
        }
        if ($tutorial->confirm){
            $tutorial->confirm= 0;
        }else{
            $tutorial->confirm = 1;
        }

        $tutorial->save();

        $checkConfirm = true;

        $tutorials = $this->tutorialRepository->orderBy('updated_at','desc')->paginate(15);
        foreach ($tutorials as $value){
            if($value->confirm == 0){
                $checkConfirm = false;
            }
        }

        $responData = array_merge($tutorial->toArray(), ['checkConfirm'=>$checkConfirm]);

        return $this->sendResponse($responData, 'Tutorial updated successfully');
    }

    public function updateConfirmAll(Request $request)
    {
        $ids = $request->tutorialIds;
        $comfirmType = $request->confirmType;
        $result = [];
        array_push($result,["comfirmType" => $comfirmType]);
        foreach ($ids as $id) {
            $tutorial = $this->tutorialRepository->findWithoutFail($id);

            if (empty($tutorial)) {
                return $this->sendError('Tutorial not found');
            }
            if($comfirmType == 1){
                $tutorial->confirm = 1;
            }else{
                $tutorial->confirm = 0;
            }

            $tutorial->save();
            array_push($result,$tutorial);
        }
        return $this->sendResponse($result,'Tutorial updated successfully');
    }

}
