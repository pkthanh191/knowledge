<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Repositories\GradeRepository;
use App\Repositories\GradeTutorialRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class GradeController extends AppBaseController
{
    /** @var  GradeRepository */
    private $gradeRepository;
    private $gradeTutorialRepository;

    public function __construct(GradeRepository $gradeRepo, GradeTutorialRepository $gradeTutorialRepo)
    {
        $this->gradeRepository = $gradeRepo;
        $this->gradeTutorialRepository = $gradeTutorialRepo;
    }

    /**
     * Display a listing of the Grade.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        if (!empty($search)) {
            if (!empty($search['name'])) {
                $grades = $this->gradeRepository->findByField([['name', 'LIKE', '%' . $search['name'] . '%']]);
            }
        } else {
            $grades = $this->gradeRepository->paginate(15);
        }

        return view('backend.grades.index')
            ->with('grades', $grades);
    }

    /**
     * Show the form for creating a new Grade.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.grades.create');
    }

    /**
     * Store a newly created Grade in storage.
     *
     * @param CreateGradeRequest $request
     *
     * @return Response
     */
    public function store(CreateGradeRequest $request)
    {
        $input = $request->all();

        $grade = $this->gradeRepository->create($input);

        Flash::success(__('messages.grades_success_create'));

        return redirect(route('admin.grades.index'));
    }

    /**
     * Display the specified Grade.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $grade = $this->gradeRepository->findWithoutFail($id);

        if (empty($grade)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.grades.index'));
        }

        return view('backend.grades.show')->with('grade', $grade);
    }

    /**
     * Show the form for editing the specified Grade.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $grade = $this->gradeRepository->findWithoutFail($id);

        if (empty($grade)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.grades.index'));
        }

        return view('backend.grades.edit')->with('grade', $grade);
    }

    /**
     * Update the specified Grade in storage.
     *
     * @param  int $id
     * @param UpdateGradeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGradeRequest $request)
    {
        $grade = $this->gradeRepository->findWithoutFail($id);

        if (empty($grade)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.grades.index'));
        }

        $grade = $this->gradeRepository->update($request->all(), $id);

        Flash::success(__('messages.grades_success_create'));

        return redirect(route('admin.grades.index'));
    }

    /**
     * Remove the specified Grade from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        if ($id == 'MULTI') {
            if (!is_null($request->ids)) {
                $checked = [];
                foreach ($request->ids as $id) {
                    $grade = $this->gradeRepository->findWithoutFail($id);
                    if (empty($grade)) {
                        Flash::error(__('messages.not-found'));
                        return back();
                    }
                    if (!$grade->tutorials->isEmpty()) {
                        Flash::warning(__('messages.alert_delete_grade'));
                        return back();
                    }
                    array_push($checked, $id);
                }
                foreach ($checked as $id) {
                    $this->gradeTutorialRepository->deleteWhere([['grade_id', '=', $id]]);
                    $this->gradeRepository->delete($id);
                }
                Flash::success(__('messages.deleted'));
                return back();
            } else {
                Flash::error(__('messages.grades_please_choose'));
                return back();
            }
        } else {
            $grade = $this->gradeRepository->findWithoutFail($id);
            if (empty($grade)) {
                Flash::error(__('messages.no-items'));
                return back();
            } elseif (!$grade->tutorials->isEmpty()) {
                Flash::warning(__('messages.alert_delete_grade'));
                return back();
            }
            $this->gradeTutorialRepository->deleteWhere([['grade_id', '=', $id]]);
            $this->gradeRepository->delete($id);
            Flash::success(__('messages.deleted'));
            return back();
        }
    }
}