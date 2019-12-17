<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubjectTutorialRequest;
use App\Http\Requests\UpdateSubjectTutorialRequest;
use App\Repositories\SubjectTutorialRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class SubjectTutorialController extends AppBaseController
{
    /** @var  SubjectTutorialRepository */
    private $subjectTutorialRepository;

    public function __construct(SubjectTutorialRepository $subjectTutorialRepo)
    {
        $this->subjectTutorialRepository = $subjectTutorialRepo;
    }

    /**
     * Display a listing of the SubjectTutorial.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->subjectTutorialRepository->pushCriteria(new RequestCriteria($request));
        $subjectTutorials = $this->subjectTutorialRepository->all();

        return view('backend.subject_tutorials.index')
            ->with('subjectTutorials', $subjectTutorials);
    }

    /**
     * Show the form for creating a new SubjectTutorial.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.subject_tutorials.create');
    }

    /**
     * Store a newly created SubjectTutorial in storage.
     *
     * @param CreateSubjectTutorialRequest $request
     *
     * @return Response
     */
    public function store(CreateSubjectTutorialRequest $request)
    {
        $input = $request->all();

        $subjectTutorial = $this->subjectTutorialRepository->create($input);

        Flash::success('Subject Tutorial saved successfully.');

        return redirect(route('admin.subjectTutorials.index'));
    }

    /**
     * Display the specified SubjectTutorial.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $subjectTutorial = $this->subjectTutorialRepository->findWithoutFail($id);

        if (empty($subjectTutorial)) {
            Flash::error('Subject Tutorial not found');

            return redirect(route('admin.subjectTutorials.index'));
        }

        return view('backend.subject_tutorials.show')->with('subjectTutorial', $subjectTutorial);
    }

    /**
     * Show the form for editing the specified SubjectTutorial.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $subjectTutorial = $this->subjectTutorialRepository->findWithoutFail($id);

        if (empty($subjectTutorial)) {
            Flash::error('Subject Tutorial not found');

            return redirect(route('admin.subjectTutorials.index'));
        }

        return view('backend.subject_tutorials.edit')->with('subjectTutorial', $subjectTutorial);
    }

    /**
     * Update the specified SubjectTutorial in storage.
     *
     * @param  int              $id
     * @param UpdateSubjectTutorialRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSubjectTutorialRequest $request)
    {
        $subjectTutorial = $this->subjectTutorialRepository->findWithoutFail($id);

        if (empty($subjectTutorial)) {
            Flash::error('Subject Tutorial not found');

            return redirect(route('admin.subjectTutorials.index'));
        }

        $subjectTutorial = $this->subjectTutorialRepository->update($request->all(), $id);

        Flash::success('Subject Tutorial updated successfully.');

        return redirect(route('admin.subjectTutorials.index'));
    }

    /**
     * Remove the specified SubjectTutorial from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $subjectTutorial = $this->subjectTutorialRepository->findWithoutFail($id);

        if (empty($subjectTutorial)) {
            Flash::error('Subject Tutorial not found');

            return redirect(route('admin.subjectTutorials.index'));
        }

        $this->subjectTutorialRepository->delete($id);

        Flash::success('Subject Tutorial deleted successfully.');

        return redirect(route('admin.subjectTutorials.index'));
    }
}
