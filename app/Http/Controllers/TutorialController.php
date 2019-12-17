<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTutorialRequest;
use App\Http\Requests\UpdateTutorialRequest;
use App\Repositories\GradeRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\TutorialRepository;
use App\Repositories\CityRepository;
use App\Repositories\DistrictRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\TutorialCodeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class TutorialController extends AppBaseController
{
    /** @var  TutorialRepository */
    private $tutorialRepository;
    private $gradeRepository;
    private $subjectRepository;
    private $cityRepository;
    private $districtRepository;
    private $transactionRepository;
    private $tutorialCodeRepository;

    public function __construct(TutorialRepository $tutorialRepo,GradeRepository $gradeRepository , SubjectRepository $subjectRepository, CityRepository $cityRepository, DistrictRepository $districtRepository, TransactionRepository $transactionRepository, TutorialCodeRepository $tutorialCodeRepository)
    {
        $this->tutorialRepository = $tutorialRepo;
        $this->gradeRepository = $gradeRepository;
        $this->subjectRepository = $subjectRepository;
        $this->cityRepository = $cityRepository;
        $this->districtRepository = $districtRepository;
        $this->transactionRepository = $transactionRepository;
        $this->tutorialCodeRepository = $tutorialCodeRepository;
    }

    /**
     * Display a listing of the Tutorial.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $checkActive = true;
        $checkConfirm = true;
        $search = $request->search;
        $searchConditions = [];
        $compare = [];
        $grades = $this->gradeRepository->getAllForSelectBox(['*'],null,true,__('messages.tutorials_choose_grade'));
        $subjects = $this->subjectRepository->getAllForSelectBox(['*'],null,true, __('messages.tutorials_choose_subject'));
        $cities = $this->cityRepository->getAllCitiesForSelectBox(['*'],null,true, __('messages.tutorials_choose_city'));
        $districts =  ['0'=> '-- '. __('messages.tutorials_choose_district') . ' --'];
        if(!empty($search)){
            if(!empty($search['title_or_phone'])){
                array_push($searchConditions,['title','like','%'.$search['title_or_phone'].'%']);
                array_push($searchConditions,['phone','like','%'.$search['title_or_phone'].'%']);
            }

//            if(!is_null($search['phone'])){
//                array_push($searchConditions,['phone','like','%'.$search['phone'].'%']);
//            }

            if(!empty($search['subject']) && ($search['subject'] != 0 )){
                array_push($compare,['subject_tutorials.subject_id', $search['subject']]);
            }

            if(!empty($search['grade']) && ($search['grade'] != 0 )){
                array_push($compare,['grade_tutorials.grade_id', $search['grade']]);
            }

            if(!empty($search['city_code']) && $search['city_code'] != 0){
                array_push($compare,['cities.code', $search['city_code']]);
                $districts = $this->districtRepository->getAllDistrictsByCodeCityForSelectBox(['*'],null,true,"Chọn quận/huyện", $search['city_code']);
            }

            if(!empty($search['district_id']) && $search['district_id'] != 0){
                array_push($compare,['districts.id', $search['district_id']]);
            }

            $tutorials = $this->tutorialRepository->orderBy('updated_at','desc')->search($searchConditions, $compare);
        }else{
            $tutorials = $this->tutorialRepository->orderBy('updated_at','desc')->paginate(15);
        }
        foreach ($tutorials as $tutorial){
            if($tutorial->active == 0){
                $checkActive = false;
            }
            if($tutorial->confirm == 0){
                $checkConfirm = false;
            }
        }

        return view('backend.tutorials.index',compact('grades','subjects','tutorials','cities','districts','checkActive','checkConfirm'));
    }

    /**
     * Show the form for creating a new Tutorial.
     *
     * @return Response
     */
    public function create()
    {
        $tutorial = null;
        $grades = $this->gradeRepository->getAllForSelectBox(['*'],null,false);
        $subjects = $this->subjectRepository->getAllForSelectBox(['*'],null,false);
        $cities = $this->cityRepository->getAllCitiesForSelectBox(['*'],null,true, __('messages.tutorials_placeholder_city'));
        $districts =  ['0'=>"-- ".__('messages.tutorials_placeholder_district')." --"];
        return view('backend.tutorials.create',compact('tutorial','cities','grades','subjects','districts'));
    }

    /**
     * Store a newly created Tutorial in storage.
     *
     * @param CreateTutorialRequest $request
     *
     * @return Response
     */
    public function store(CreateTutorialRequest $request)
    {
        $input = $request->all();
        $tutorial = $this->tutorialRepository->create($input);

        Flash::success(__('messages.created'));

        return redirect(route('admin.tutorials.index'));
    }

    /**
     * Display the specified Tutorial.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $tutorial = $this->tutorialRepository->findWithoutFail($id);

        if (empty($tutorial)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.tutorials.index'));
        }

        return view('backend.tutorials.show')->with('tutorial', $tutorial);
    }

    /**
     * Show the form for editing the specified Tutorial.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tutorial = $this->tutorialRepository->findWithoutFail($id);
        if (empty($tutorial)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.tutorials.index'));
        }

        $grades = $this->gradeRepository->getAllForSelectBox(['*'],null,false);
        $subjects = $this->subjectRepository->getAllForSelectBox(['*'],null,false);
        $cities = $this->cityRepository->getAllCitiesForSelectBox(['*'],null,true, __('messages.tutorials_placeholder_city'));
        $districts =  $this->districtRepository->getAllDistrictsByCodeCityForSelectBox(['*'],null,true, __('messages.tutorials_placeholder_district'), $tutorial->district->code_city);
//        dd($tutorial->district->city);
        return view('backend.tutorials.edit',compact('tutorial','grades','subjects','cities','districts'));
    }

    /**
     * Update the specified Tutorial in storage.
     *
     * @param  int              $id
     * @param UpdateTutorialRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTutorialRequest $request)
    {
        $tutorial = $this->tutorialRepository->findWithoutFail($id);

        if (empty($tutorial)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.tutorials.index'));
        }
        $this->validate($request, [
            'subjects'=>'required',
            'grades'=>'required',
        ]);

        $tutorial = $this->tutorialRepository->update($request->all(), $id);

        Flash::success(__('messages.updated'));

        return redirect(route('admin.tutorials.index'));
    }

    /**
     * Remove the specified Tutorial from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        if ($id == 'MULTI'){
            if(!is_null($request->ids)){
                foreach ($request->ids as $id) {
                    $tutorial = $this->tutorialRepository->findWithoutFail($id);

                    if (empty($tutorial)) {
                        Flash::error(__('messages.not-found'));

                        return redirect(route('admin.tutorials.index'));
                    }
                    #TODO: Xóa quan hệ với giao dịch, đưa giao dịch về với tài liệu không xác định
                    $transactions = $this->transactionRepository->findWhere(['tutorial_id'=>$id]);
                    foreach ($transactions as $tran){
                        $tran->tutorial_id = 0;
                        $tran->save();
                    }
                    $tutorial->grades()->detach();
                    $tutorial->subjects()->detach();

                    $this->tutorialCodeRepository->deleteWhere(['tutorial_id'=>$id]);
                    $this->tutorialRepository->delete($id);
                }
                Flash::success(__('messages.deleted'));
                return redirect(route('admin.tutorials.index'));
            }else{
                Flash::error(__('messages.tutorials_request'));
                return redirect(route('admin.tutorials.index'));
            }
        }
        else {
            $tutorial = $this->tutorialRepository->findWithoutFail($id);

            if (empty($tutorial)) {
                Flash::error(__('messages.not-found'));

                return redirect(route('admin.tutorials.index'));
            }

            #TODO: Xóa quan hệ với giao dịch, đưa giao dịch về với tài liệu không xác định
            $transactions = $this->transactionRepository->findWhere(['tutorial_id'=>$id]);
            foreach ($transactions as $tran){
                $tran->tutorial_id = 0;
                $tran->save();
            }
            $tutorial->grades()->detach();
            $tutorial->subjects()->detach();
            $this->tutorialCodeRepository->deleteWhere(['tutorial_id'=>$id]);
            $this->tutorialRepository->delete($id);

            Flash::success(__('messages.deleted'));

            return redirect(route('admin.tutorials.index'));
        }
    }
}
