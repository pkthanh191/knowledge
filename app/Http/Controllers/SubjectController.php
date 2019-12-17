<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Repositories\SubjectRepository;
use App\Repositories\SubjectTutorialRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class SubjectController extends AppBaseController
{
    /** @var  SubjectRepository */
    private $subjectRepository;
    private $subjectTutorialRepository;

    public function __construct(SubjectRepository $subjectRepo, SubjectTutorialRepository $subjectTutorialRepo)
    {
        $this->subjectRepository = $subjectRepo;
        $this->subjectTutorialRepository = $subjectTutorialRepo;
    }

    /**
     * Display a listing of the Subject.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        if(!empty($search)){
            if(!empty($search['name'])){
                $subjects = $this->subjectRepository->findByField([['name','LIKE','%'.$search['name'].'%']]);
            }
        }else{
            $subjects = $this->subjectRepository->paginate(15);
        }

        return view('backend.subjects.index')
            ->with('subjects', $subjects);
    }

    /**
     * Show the form for creating a new Subject.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.subjects.create');
    }

    /**
     * Store a newly created Subject in storage.
     *
     * @param CreateSubjectRequest $request
     *
     * @return Response
     */
    public function store(CreateSubjectRequest $request)
    {
        $input = $request->all();

        $subject = $this->subjectRepository->create($input);

        Flash::success(__('messages.created'));

        return redirect(route('admin.subjects.index'));
    }

    /**
     * Display the specified Subject.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $subject = $this->subjectRepository->findWithoutFail($id);

        if (empty($subject)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.subjects.index'));
        }

        return view('backend.subjects.show')->with('subject', $subject);
    }

    /**
     * Show the form for editing the specified Subject.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $subject = $this->subjectRepository->findWithoutFail($id);

        if (empty($subject)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.subjects.index'));
        }

        return view('backend.subjects.edit')->with('subject', $subject);
    }

    /**
     * Update the specified Subject in storage.
     *
     * @param  int              $id
     * @param UpdateSubjectRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSubjectRequest $request)
    {
        $subject = $this->subjectRepository->findWithoutFail($id);

        if (empty($subject)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.subjects.index'));
        }

        $subject = $this->subjectRepository->update($request->all(), $id);

        Flash::success(__('messages.updated'));

        return redirect(route('admin.subjects.index'));
    }

    /**
     * Remove the specified Subject from storage.
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
                    $subject = $this->subjectRepository->findWithoutFail($id);
                    if (empty($subject)) {
                        Flash::error(__('messages.not-found'));
                        return back();
                    }
                    if (!$subject->tutorials->isEmpty()) {
                        Flash::warning(__('messages.alert_delete_subject'));
                        return back();
                    }
                    array_push($checked, $id);
                }
                foreach ($checked as $id) {
                    $this->subjectTutorialRepository->deleteWhere([['subject_id', '=', $id]]);
                    $this->subjectRepository->delete($id);
                }
                Flash::success(__('messages.deleted'));
                return back();
            } else {
                Flash::error(__('messages.subjects_please_choose'));
                return back();
            }
        } else {
            $subject = $this->subjectRepository->findWithoutFail($id);
            if (empty($subject)) {
                Flash::error(__('messages.no-items'));
                return back();
            } elseif (!$subject->tutorials->isEmpty()) {
                Flash::warning(__('messages.alert_delete_subject'));
                return back();
            }
            $this->subjectTutorialRepository->deleteWhere([['subject_id', '=', $id]]);
            $this->subjectRepository->delete($id);
            Flash::success(__('messages.deleted'));
            return back();
        }
    }
}
