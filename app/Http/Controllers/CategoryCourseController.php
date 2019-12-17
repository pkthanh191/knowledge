<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryCourseRequest;
use App\Http\Requests\UpdateCategoryCourseRequest;
use App\Repositories\CategoryCourseRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Auth;
use App\Http\Controllers\CourseCategoryController;
use App\Repositories\CourseCategoryRepository;

class CategoryCourseController extends AppBaseController
{
    /** @var  CategoryCourseRepository */
    private $categoryCourseRepository;
    private $courseCategoryRepository;

    public function __construct(CategoryCourseRepository $categoryCourseRepo, CourseCategoryRepository $courseCategoryRepository)
    {
        $this->categoryCourseRepository = $categoryCourseRepo;
        $this->courseCategoryRepository = $courseCategoryRepository;
    }

    /**
     * Display a listing of the CategoryCourse.
     *
     * @param Request $request
     * @return Response
     */

    public function index(Request $request)
    {
        $keyword = $request->search;
        if (!empty($keyword)) {
            $categoryCourses = $this->categoryCourseRepository->findByField('name', 'LIKE', '%' . $keyword . '%', ["*"]);
        } else {
            $categoryCourses = $this->categoryCourseRepository->orderBy('orderSort','asc')->orderBy('updated_at','desc')->buildTree();
        }

        return view('backend.category_courses.index')
            ->with('categoryCourses', $categoryCourses);

    }


    /**
     * Show the form for creating a new CategoryCourse.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->categoryCourseRepository->buildTreeForSelectBox(['id', 'name'], $this->SEPARATOR_SPACE, null, __('messages.category_course_selectbox_parent'));
        return view('backend.category_courses.create')->with('categories', $categories);
    }

    /**
     * Store a newly created CategoryCourse in storage.
     *
     * @param CreateCategoryCourseRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryCourseRequest $request)
    {
        $this->validate($request, [
            'name' => 'max:255',
        ]);
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $categoryCourse = $this->categoryCourseRepository->create($input);

        Flash::success(__('messages.created'));

        return redirect(route('admin.categoryCourses.index'));

    }

    /**
     * Display the specified CategoryCourse.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $categoryCourse = $this->categoryCourseRepository->findWithoutFail($id);

        if (empty($categoryCourse)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.categoryCourses.index'));
        }

        return view('backend.category_courses.show')->with('categoryCourse', $categoryCourse);

    }

    /**
     * Show the form for editing the specified CategoryCourse.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $categoryCourse = $this->categoryCourseRepository->findWithoutFail($id);
        $categories = $this->categoryCourseRepository->buildTreeForSelectBox(['id', 'name'], $this->SEPARATOR_SPACE, $id, __('messages.category_course_selectbox_parent'));

        if (empty($categoryCourse)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.categoryCourses.index'));
        }

        return view('backend.category_courses.edit')->with('categoryCourse', $categoryCourse)->with('categories', $categories);
    }

    /**
     * Update the specified CategoryCourse in storage.
     *
     * @param  int $id
     * @param UpdateCategoryCourseRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryCourseRequest $request)
    {
        $this->validate($request, [
            'name' => 'max:255',
        ]);
        $categoryCourse = $this->categoryCourseRepository->findWithoutFail($id);

        if (empty($categoryCourse)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.categoryCourses.index'));
        }
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $categoryCourse = $this->categoryCourseRepository->update($input, $id);

        Flash::success(__('messages.updated'));

        return redirect(route('admin.categoryCourses.index'));

    }

    /**
     * Remove the specified CategoryCourse from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        if ($id == 'MULTI') {
            if (($request->ids) != null) {
                foreach ($request->ids as $id) {
                    $categoryCourse = $this->categoryCourseRepository->findWithoutFail($id);
                    if (empty($categoryCourse)) {
                        Flash::error(__('messages.not-found'));
                        return redirect(route('admin.categoryCourses.index'));
                    }
                    $children = $categoryCourse->children();
                    $courses = $categoryCourse->courses;

                    if (count($children) != 0) {
                        Flash::error(__('messages.category_course_have_children'));
                        return redirect(route('admin.categoryCourses.index'));
                    }

                    if (count($courses) != 0) {
                        Flash::error(__('messages.category_course_have_courses'));
                        return back();
                    }

                    if (count($children) == 0 && count($courses) == 0) {
                        $this->categoryCourseRepository->delete($id);
                    }
                    Flash::success(__('messages.deleted'));
                    return redirect(route('admin.categoryCourses.index'));
                }
                Flash::error(__('messages.category_course_must_select_a_category_to_delete'));
                return redirect(route('admin.categoryCourses.index'));

            }
        } else {
            $categoryCourse = $this->categoryCourseRepository->findWithoutFail($id);

            if (empty($categoryCourse)) {
                Flash::error(__('messages.not-found'));
                return redirect(route('admin.categoryCourses.index'));
            }
            $children = $categoryCourse->children();
            $courses = $categoryCourse->courses;

            if (count($children) != 0) {
                Flash::error(__('messages.category_course_have_children'));
                return back();
            }

            if (count($courses) != 0) {
                Flash::error(__('messages.category_course_have_courses'));
                return back();
            }


            if (count($children) == 0 && count($courses) == 0) {
                $this->categoryCourseRepository->delete($id);

                Flash::success(__('messages.deleted'));

                return back();
            }
        }
    }
}
