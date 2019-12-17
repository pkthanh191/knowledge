<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCenterRequest;
use App\Http\Requests\UpdateCenterRequest;
use App\Repositories\CenterRepository;
use App\Helpers\Helper;
use App\Repositories\CourseRepository;
use App\Repositories\TeacherRepository;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;

class CenterController extends AppBaseController
{
    /** @var  CenterRepository */
    private $centerRepository;
    private $teacherRepository;
    private $courseRepository;


    public function __construct(CenterRepository $centerRepo, CourseRepository $courseRepository, TeacherRepository $teacherRepository)
    {
        $this->centerRepository = $centerRepo;
        $this->teacherRepository = $teacherRepository;
        $this->courseRepository = $courseRepository;
    }

    /**
     * Display a listing of the Center.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $searchCondition = [['id','<>',0]];
        if (!empty($search)) {
            if (!empty($search['name'])) {
                array_push($searchCondition, ['name', 'LIKE', '%' . $search['name'] . '%']);
            }
            if (!empty($search['address'])) {
                array_push($searchCondition, ['address', 'LIKE', '%' . $search['address'] . '%']);
            }
            if (!is_null($search['phone'])) {
                array_push($searchCondition, ['phone', 'LIKE', '%' . $search['phone'] . '%']);
            }
            if (!empty($search['email'])) {
                array_push($searchCondition, ['email', 'LIKE', '%' . $search['email'] . '%']);
            }

            $centers = $this->centerRepository->orderBy('updated_at','desc')->findWhere($searchCondition,['*'],true,15);
        } else {
            $centers = $this->centerRepository->orderBy('updated_at','desc')->findByField('id','<>',0,['*'],true,15);
//            $centers->shift();
        }

        return view('backend.centers.index')
            ->with('centers', $centers);


    }

    /**
     * Show the form for creating a new Center.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.centers.create');
    }

    /**
     * Store a newly created Center in storage.
     *
     * @param CreateCenterRequest $request
     *
     * @return Response
     */
    public function store(CreateCenterRequest $request)
    {
        $input = $request->all();

        if (!empty($request->image)) {
            $imageName = time() . '.centers.' . Helper::transText($request->image->getClientOriginalName(),'-');
            $request->image->move(public_path('uploads'), $imageName);
            $request->image = $imageName;
            $input['image'] = '/uploads/' . $imageName;
        } else {
            $input['image'] = '/uploads/default_image.png';
        }
        $input['user_id'] = Auth::user()->id;

        $center = $this->centerRepository->create($input);

        Flash::success(__('messages.created'));

        return redirect(route('admin.centers.index'));
    }

    /**
     * Display the specified Center.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $center = $this->centerRepository->findWithoutFail($id);

        if (empty($center)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.centers.index'));
        }

        return view('backend.centers.show')->with('center', $center);
    }

    /**
     * Show the form for editing the specified Center.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $center = $this->centerRepository->findWithoutFail($id);

        if (empty($center)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.centers.index'));
        }

        return view('backend.centers.edit')->with('center', $center);
    }

    /**
     * Update the specified Center in storage.
     *
     * @param  int $id
     * @param UpdateCenterRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCenterRequest $request)
    {
        $center = $this->centerRepository->findWithoutFail($id);

        if (empty($center)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.centers.index'));
        }
        $email = $center->email;
        $input = $request->all();

        if (!empty($request->image)) {
            $imageName = time() . '.' . Helper::transText($request->image->getClientOriginalName(),'-');
            $request->image->move(public_path('uploads'), $imageName);
            $request->image = $imageName;
            $input['image'] = '/uploads/' . $imageName;
        }
        $input['user_id'] = Auth::user()->id;

        Flash::success(__('messages.updated'));


        $center = $this->centerRepository->update($input, $id);

        return redirect(route('admin.centers.index'));
    }

    /**
     * Remove the specified Center from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        if ($id == 'MULTI') {

            if (empty($request->ids)) {
                Flash::warning(__('messages.not-found-center'));

            } else {

                foreach ($request->ids as $id) {

                    $center = $this->centerRepository->findWithoutFail($id);

                    if (empty($center)) {
                        Flash::error(__('messages.not-found-center'));

                        return redirect(route('admin.centers.index'));
                    }

                    $teachers = $this->teacherRepository->findWhere([['center_id', '=', $id]], ['*']);
                    $courses = $this->courseRepository->findWhere([['center_id', '=', $id]], ['*']);
                    if (count($teachers) == 0 && count($courses) == 0) {
                        $this->centerRepository->delete($id);

                    } else {
                        Flash::error(__('messages.center_undeleted'));
                        return redirect(route('admin.centers.index'));
                    }
                }
                Flash::success(__('messages.deleted'));
                return redirect(route('admin.centers.index'));
            }
        } else {
            $center = $this->centerRepository->findWithoutFail($id);

            if (empty($center)) {
                Flash::error(__('messages.not-found'));

                return redirect(route('admin.centers.index'));
            }

            $teachers = $this->teacherRepository->findWhere([['center_id', '=', $id]], ['*']);
            $courses = $this->courseRepository->findWhere([['center_id', '=', $id]], ['*']);
            if (count($teachers) == 0 && count($courses) == 0) {
                $this->centerRepository->delete($id);

                Flash::success(__('messages.deleted'));

                return redirect(route('admin.centers.index'));
            } else {
                Flash::error(__('messages.center_undeleted'));

                return redirect(route('admin.centers.index'));
            }


        }

    }
}
