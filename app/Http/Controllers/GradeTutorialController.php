<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGradeTutorialRequest;
use App\Http\Requests\UpdateGradeTutorialRequest;
use App\Repositories\GradeTutorialRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class GradeTutorialController extends AppBaseController
{
    /** @var  GradeTutorialRepository */
    private $gradeTutorialRepository;

    public function __construct(GradeTutorialRepository $gradeTutorialRepo)
    {
        $this->gradeTutorialRepository = $gradeTutorialRepo;
    }

    /**
     * Display a listing of the GradeTutorial.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->gradeTutorialRepository->pushCriteria(new RequestCriteria($request));
        $gradeTutorials = $this->gradeTutorialRepository->all();

        return view('backend.grade_tutorials.index')
            ->with('gradeTutorials', $gradeTutorials);
    }

    /**
     * Show the form for creating a new GradeTutorial.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.grade_tutorials.create');
    }

    /**
     * Store a newly created GradeTutorial in storage.
     *
     * @param CreateGradeTutorialRequest $request
     *
     * @return Response
     */
    public function store(CreateGradeTutorialRequest $request)
    {
        $input = $request->all();

        $gradeTutorial = $this->gradeTutorialRepository->create($input);

        Flash::success('Grade Tutorial saved successfully.');

        return redirect(route('admin.gradeTutorials.index'));
    }

    /**
     * Display the specified GradeTutorial.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $gradeTutorial = $this->gradeTutorialRepository->findWithoutFail($id);

        if (empty($gradeTutorial)) {
            Flash::error('Grade Tutorial not found');

            return redirect(route('admin.gradeTutorials.index'));
        }

        return view('backend.grade_tutorials.show')->with('gradeTutorial', $gradeTutorial);
    }

    /**
     * Show the form for editing the specified GradeTutorial.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $gradeTutorial = $this->gradeTutorialRepository->findWithoutFail($id);

        if (empty($gradeTutorial)) {
            Flash::error('Grade Tutorial not found');

            return redirect(route('admin.gradeTutorials.index'));
        }

        return view('backend.grade_tutorials.edit')->with('gradeTutorial', $gradeTutorial);
    }

    /**
     * Update the specified GradeTutorial in storage.
     *
     * @param  int              $id
     * @param UpdateGradeTutorialRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGradeTutorialRequest $request)
    {
        $gradeTutorial = $this->gradeTutorialRepository->findWithoutFail($id);

        if (empty($gradeTutorial)) {
            Flash::error('Grade Tutorial not found');

            return redirect(route('admin.gradeTutorials.index'));
        }

        $gradeTutorial = $this->gradeTutorialRepository->update($request->all(), $id);

        Flash::success('Grade Tutorial updated successfully.');

        return redirect(route('admin.gradeTutorials.index'));
    }

    /**
     * Remove the specified GradeTutorial from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $gradeTutorial = $this->gradeTutorialRepository->findWithoutFail($id);

        if (empty($gradeTutorial)) {
            Flash::error('Grade Tutorial not found');

            return redirect(route('admin.gradeTutorials.index'));
        }

        $this->gradeTutorialRepository->delete($id);

        Flash::success('Grade Tutorial deleted successfully.');

        return redirect(route('admin.gradeTutorials.index'));
    }
}
