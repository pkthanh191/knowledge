<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Repositories\TeacherRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Auth;
use App\Repositories\CenterRepository;
use App\Helpers\Helper;

class TeacherController extends AppBaseController
{
    /** @var  TeacherRepository */
    private $teacherRepository;
    private $centerRepository;

    public function __construct(TeacherRepository $teacherRepo,CenterRepository $centerRepository)
    {
        $this->teacherRepository = $teacherRepo;
        $this->centerRepository = $centerRepository;
    }

    /**
     * Display a listing of the Teacher.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->teacherRepository->pushCriteria(new RequestCriteria($request));
        $centers = $this->centerRepository->getAllForSelectBox(['*'],null,true,__('messages.course_choose_center_name'));
        $search = $request->search;
        $searchCondition = [['id','<>',0]];
        if(!empty($search)){
            if(!empty($search['name'])){
                array_push($searchCondition,['name','LIKE','%'.$search['name'].'%']);
            }
            if (!empty($search['email'])) {
                array_push($searchCondition,['email','LIKE','%'.$search['email'].'%']);
            }
            if (!is_null($search['phone'])) {
                array_push($searchCondition, ['phone', 'LIKE', '%'.$search['phone'] .'%']);
            }
            if (!empty($search['center_id']) && $search['center_id'] != 0) {
                array_push($searchCondition, ['center_id', '=', $search['center_id']]);
            }
            $teachers = $this->teacherRepository->orderBy('feature','desc')->orderBy('updated_at','desc')->search($searchCondition);
        }else{
            $teachers = $this->teacherRepository->orderBy('feature','desc')->orderBy('updated_at','desc')->findByField('id','<>',0,['*'],true,15);
//            $teachers->shift();
        }

        return view('backend.teachers.index')
            ->with('teachers', $teachers)->with('centers', $centers)->with('totalPages');
    }

    /**
     * Show the form for creating a new Teacher.
     *
     * @return Response
     */
    public function create()
    {
        $teacher = null;
        $centers = $this->centerRepository->getAllForSelectBox();
        return view('backend.teachers.create')->with('centers',$centers);
    }

    /**
     * Store a newly created Teacher in storage.
     *
     * @param CreateTeacherRequest $request
     *
     * @return Response
     */
    public function store(CreateTeacherRequest $request)
    {
        $input = $request->all();
        if (!empty($request->image)) {
            $imageName = time().'.teachers.'.Helper::transText($request->image->getClientOriginalName(),'-');
            $request->image->move(public_path('uploads'), $imageName);
            $request->image = $imageName;
            $input['image'] = '/public/uploads/'.$imageName;
        }
        $input['user_id'] = Auth::user()->id;
        $teacher = $this->teacherRepository->create($input);

        Flash::success(__('messages.created'));

        return redirect(route('admin.teachers.index'));
    }

    /**
     * Display the specified Teacher.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $teacher = $this->teacherRepository->findWithoutFail($id);

        if (empty($teacher)) {
            Flash::error(__('messages.no-items'));

            return redirect(route('admin.teachers.index'));
        }

        return view('backend.teachers.show')->with('teacher', $teacher);
    }

    /**
     * Show the form for editing the specified Teacher.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $teacher = $this->teacherRepository->findWithoutFail($id);
        $centers = $this->centerRepository->getAllForSelectBox(['*'],$id);
        if (empty($teacher)) {
            Flash::error(__('messages.no-items'));

            return redirect(route('admin.teachers.index'));
        }

        return view('backend.teachers.edit')->with('teacher', $teacher)->with('centers',$centers);
    }

    /**
     * Update the specified Teacher in storage.
     *
     * @param  int              $id
     * @param UpdateTeacherRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTeacherRequest $request)
    {

        $teacher = $this->teacherRepository->findWithoutFail($id);

        if (empty($teacher)) {
            Flash::error(__('messages.no-items'));

            return redirect(route('admin.teachers.index'));
        }

        $input = $request->all();
        if (!empty($request->image)) {
            $imageName = time().'.'.Helper::transText($request->image->getClientOriginalName(),'-');
            $request->image->move(public_path('uploads'), $imageName);
            $request->image = $imageName;
            $input['image'] = '/public/uploads/'.$imageName;
        }
        $teacher = $this->teacherRepository->update($input, $id);

        Flash::success(__('messages.updated'));

        return redirect(route('admin.teachers.index'));
    }

    /**
     * Remove the specified Teacher from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id,Request $request)
    {
        if ($id == 'MULTI') {
            if (!is_null($request->ids)) {
                foreach ($request->ids as $id) {
                    $teacher = $this->teacherRepository->findWithoutFail($id);

                    if (empty($teacher)) {
                        Flash::error(__('messages.not-found'));
                        return redirect(route('admin.teachers.index'));
                    }
                    $courses = $teacher->courses;
                    if (count($courses) == 0) {
                        $this->teacherRepository->delete($id);
                    } else {
                        Flash::error(__('messages.teacher_have_courses'));
                        return back();
                    }
//                    $this->teacherRepository->delete($id);
                }

                Flash::success(__('messages.deleted'));
                return redirect(route('admin.teachers.index'));
            }
            else{
                Flash::error(__('messages.teacher_check'));
                return redirect(route('admin.teachers.index'));
            }
        }
        else {
            $teacher = $this->teacherRepository->findWithoutFail($id);

            if (empty($teacher)) {
                Flash::error(__('messages.no-items'));

                return redirect(route('admin.teachers.index'));
            }
            $courses = $teacher->courses;

            if(count($courses) == 0){
                $this->teacherRepository->delete($id);

                Flash::success(__('messages.deleted'));
                return back();
            }else{
                Flash::error(__('messages.teacher_have_courses'));
                return back();
            }

        }
    }
}
