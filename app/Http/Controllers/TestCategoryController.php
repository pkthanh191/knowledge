<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTestCategoryRequest;
use App\Http\Requests\UpdateTestCategoryRequest;
use App\Repositories\TestCategoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class TestCategoryController extends AppBaseController
{
    /** @var  TestCategoryRepository */
    private $testCategoryRepository;

    public function __construct(TestCategoryRepository $testCategoryRepo)
    {
        $this->testCategoryRepository = $testCategoryRepo;
    }

    /**
     * Display a listing of the TestCategory.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->testCategoryRepository->pushCriteria(new RequestCriteria($request));
        $testCategories = $this->testCategoryRepository->all();

        return view('backend.test_categories.index')
            ->with('testCategories', $testCategories);
    }

    /**
     * Show the form for creating a new TestCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.test_categories.create');
    }

    /**
     * Store a newly created TestCategory in storage.
     *
     * @param CreateTestCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateTestCategoryRequest $request)
    {
        $input = $request->all();

        $testCategory = $this->testCategoryRepository->create($input);

        Flash::success('Test Category saved successfully.');

        return redirect(route('admin.testCategories.index'));
    }

    /**
     * Display the specified TestCategory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $testCategory = $this->testCategoryRepository->findWithoutFail($id);

        if (empty($testCategory)) {
            Flash::error('Test Category not found');

            return redirect(route('admin.testCategories.index'));
        }

        return view('backend.test_categories.show')->with('testCategory', $testCategory);
    }

    /**
     * Show the form for editing the specified TestCategory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $testCategory = $this->testCategoryRepository->findWithoutFail($id);

        if (empty($testCategory)) {
            Flash::error('Test Category not found');

            return redirect(route('admin.testCategories.index'));
        }

        return view('backend.test_categories.edit')->with('testCategory', $testCategory);
    }

    /**
     * Update the specified TestCategory in storage.
     *
     * @param  int              $id
     * @param UpdateTestCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTestCategoryRequest $request)
    {
        $testCategory = $this->testCategoryRepository->findWithoutFail($id);

        if (empty($testCategory)) {
            Flash::error('Test Category not found');

            return redirect(route('admin.testCategories.index'));
        }

        $testCategory = $this->testCategoryRepository->update($request->all(), $id);

        Flash::success('Test Category updated successfully.');

        return redirect(route('admin.testCategories.index'));
    }

    /**
     * Remove the specified TestCategory from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $testCategory = $this->testCategoryRepository->findWithoutFail($id);

        if (empty($testCategory)) {
            Flash::error('Test Category not found');

            return redirect(route('admin.testCategories.index'));
        }

        $this->testCategoryRepository->delete($id);

        Flash::success('Test Category deleted successfully.');

        return redirect(route('admin.testCategories.index'));
    }
}
