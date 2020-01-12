<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Repositories\CourseRepository;
use App\Repositories\TeacherRepository;
use App\Repositories\CenterRepository;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;
use App\Repositories\CategoryCourseRepository;
use App\Repositories\CourseCategoryRepository;
use App\Helpers\Helper;

class CourseController extends AppBaseController
{
    /** @var  CourseRepository */
    private $courseRepository;
    private $teacherRepository;
    private $centerRepository;
    private $categoryCourseRepository;
    private $courseCategoryRepository;

    public function __construct(CourseRepository $courseRepo, TeacherRepository $teacherRepository, CenterRepository $centerRepository, CategoryCourseRepository $categoryCourseRepository, CourseCategoryRepository $courseCategoryRepository)
    {
        $this->courseRepository = $courseRepo;
        $this->teacherRepository = $teacherRepository;
        $this->centerRepository = $centerRepository;
        $this->categoryCourseRepository = $categoryCourseRepository;
        $this->courseCategoryRepository = $courseCategoryRepository;
    }

    /**
     * Display a listing of the Course.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$this->courseRepository->pushCriteria(new RequestCriteria($request));
        $teachers = $this->teacherRepository->getAllTeacherByCenterForSelectBox(['*'],null,true,__('messages.course_choose_teacher_name'));
        $centers = $this->centerRepository->getAllForSelectBox(['*'],null,true,__('messages.course_choose_center_name'));
        $search = $request->search;
        $searchConditions = [];
        if(!empty($search)){
            if(!empty($search['name'])){
                array_push($searchConditions,['name','like','%'.$search['name'].'%']);
            }
            if(!empty($search['center_id']) && $search['center_id'] != 0){
                array_push($searchConditions,['courses.center_id','=', $search['center_id']]);
                $teachers = $this->teacherRepository->getAllTeacherByCenterForSelectBox(['*'],null,true,__('messages.course_choose_teacher_name'), $search['center_id']);
            }
            if(!empty($search['teacher_id']) && $search['teacher_id'] != 0){
                array_push($searchConditions,['courses.teacher_id','=', $search['teacher_id']]);
            }
            $courses = $this->courseRepository->orderBy('updated_at','desc')->search($searchConditions);
        }else{
            $courses = $this->courseRepository->orderBy('updated_at','desc')->paginate(15);
        }

        return view('backend.courses.index',compact('courses','teachers','centers'));
    }

    /**
     * Show the form for creating a new Course.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->categoryCourseRepository->buildTree(['id','name']);
        $selectedCategories = null;
        $teachers = $this->teacherRepository->getAllTeacherByCenterForSelectBox(['*'],null,true,"Chọn gia sư");
        $centers = $this->centerRepository->getAllForSelectBox(['*'],null,true,"Chọn trung tâm");
        $start_date = null;
        $end_date = null;
        return view('backend.courses.create',compact(array('teachers','centers','categories','selectedCategories','start_date','end_date')));
    }

    /**
     * Store a newly created Course in storage.
     *
     * @param CreateCourseRequest $request
     *
     * @return Response
     */
    public function store(CreateCourseRequest $request)
    {
        $this->validate($request, [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'name' => 'required',
        ]);

        $input = $request->all();
        if($request->cost)
            $input['cost'] = Helper::convert_money($request->cost);
        // Bắt buộc chọn trung tâm or gia sư ứng với khóa học
        if(($request['center_id']== 0 && $request['teacher_id']==0)){
            Flash::error(__('messages.course_please_choose_center_or_teacher'));
            return  back()->withInput();
        }

        if($request['categories'] == null){
            Flash::error(__('messages.course_please_choose_categories'));
            return  back()->withInput();
        }

        if (!empty($request->image)) {
            $imageName = time().'.courses.'.Helper::transText($request->image->getClientOriginalName(),'-');
            $request->image->move(public_path('uploads/courses'), $imageName);
            $request->image = $imageName;
            $input['image'] = '/public/uploads/courses/'.$imageName;
        }else{
            $input['image'] = '/public/uploads/courses/default-avatar.png';
        }

        $input['user_id'] = Auth::user()->id;
        $this->courseRepository->create($input);

        Flash::success(__('messages.created'));

        return redirect(route('admin.courses.index'));
    }

    /**
     * Display the specified Course.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $course = $this->courseRepository->findWithoutFail($id);

        if (empty($course)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.courses.index'));
        }

        return view('backend.courses.show')->with('course', $course);
    }

    /**
     * Show the form for editing the specified Course.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $course = $this->courseRepository->findWithoutFail($id);

        if (empty($course)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.courses.index'));
        }
        $categories = $this->categoryCourseRepository->buildTree(['id','name']);
        $selectedCategories = $this->courseCategoryRepository->findByField('course_id', '=', $id, ['category_course_id'], false)->toArray();
        $array = [];
        foreach ($selectedCategories as $selectedCategory) {
            array_push($array, $selectedCategory['category_course_id']);
        }
        $selectedCategories = $array;
        $teachers = $this->teacherRepository->getAllTeacherByCenterForSelectBox(['*'],null,true,"Chọn gia sư", $course->center->id);
        $centers = $this->centerRepository->getAllForSelectBox();
        $start_date = $course->start_date;
        $end_date = $course->end_date;
        return view('backend.courses.edit',compact(array('course','teachers','centers','categories','selectedCategories','start_date','end_date')));
    }

    /**
     * Update the specified Course in storage.
     *
     * @param  int              $id
     * @param UpdateCourseRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCourseRequest $request)
    {
        $course = $this->courseRepository->findWithoutFail($id);

        if (empty($course)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.courses.index'));
        }

        $this->validate($request, [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $input = $request->all();
        if($request->cost)
            $input['cost'] = Helper::convert_money($request->cost);
        // Bắt buộc chọn trung tâm or gia sư ứng với khóa học
        if(($request['center_id']== 0 && $request['teacher_id']==0)){
            Flash::error(__('messages.course_please_choose_center_or_teacher'));
            return  back()->withInput();
        }

        if($request['categories'] == null){
            Flash::error(__('messages.course_please_choose_categories'));
            return  back()->withInput();
        }

        if (!empty($request->image)) {
            $imageName = time().'.'.Helper::transText($request->image->getClientOriginalName(),'-');
            $request->image->move(public_path('uploads/courses'), $imageName);
            $request->image = $imageName;
            $input['image'] = '/public/uploads/courses/'.$imageName;
        }

        $input['user_id'] = Auth::user()->id;

        $this->courseRepository->update($input, $id);

        Flash::success(__('messages.updated'));

        return redirect(route('admin.courses.index'));
    }

    /**
     * Remove the specified Course from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id,Request $request)
    {
        if ($id == 'MULTI') {
            if(!is_null($request->ids )){
                foreach ($request->ids as $id) {
                    $course = $this->courseRepository->findWithoutFail($id);

                    if (empty($course)) {
                        Flash::error(__('messages.not-found'));

                        return redirect(route('admin.courses.index'));
                    }
                    $course->categories()->detach();
                    $this->courseRepository->delete($id);
                }

                Flash::success(__('messages.deleted'));
                return back();
            }else{
                Flash::error(__('messages.comments_please_choose_categories'));
                return redirect(route('admin.courses.index'));
            }
        }else{
            $course = $this->courseRepository->findWithoutFail($id);

            if (empty($course)) {
                Flash::error(__('messages.not-found'));

                return redirect(route('admin.courses.index'));
            }
            $course->categories()->detach();
            $this->courseRepository->delete($id);

            Flash::success(__('messages.deleted'));

            return back();
        }
    }
}
