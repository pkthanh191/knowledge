<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDocumentCategoryRequest;
use App\Http\Requests\UpdateDocumentCategoryRequest;
use App\Repositories\DocumentCategoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class DocumentCategoryController extends AppBaseController
{
    /** @var  DocumentCategoryRepository */
    private $documentCategoryRepository;

    public function __construct(DocumentCategoryRepository $documentCategoryRepo)
    {
        $this->documentCategoryRepository = $documentCategoryRepo;
    }

    /**
     * Display a listing of the DocumentCategory.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->documentCategoryRepository->pushCriteria(new RequestCriteria($request));
        $documentCategories = $this->documentCategoryRepository->all();

        return view('backend.document_categories.index')
            ->with('documentCategories', $documentCategories);
    }

    /**
     * Show the form for creating a new DocumentCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.document_categories.create');
    }

    /**
     * Store a newly created DocumentCategory in storage.
     *
     * @param CreateDocumentCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateDocumentCategoryRequest $request)
    {
        $input = $request->all();

        $documentCategory = $this->documentCategoryRepository->create($input);

        Flash::success('Document Category saved successfully.');

        return redirect(route('admin.documentCategories.index'));
    }

    /**
     * Display the specified DocumentCategory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $documentCategory = $this->documentCategoryRepository->findWithoutFail($id);

        if (empty($documentCategory)) {
            Flash::error('Document Category not found');

            return redirect(route('admin.documentCategories.index'));
        }

        return view('backend.document_categories.show')->with('documentCategory', $documentCategory);
    }

    /**
     * Show the form for editing the specified DocumentCategory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $documentCategory = $this->documentCategoryRepository->findWithoutFail($id);

        if (empty($documentCategory)) {
            Flash::error('Document Category not found');

            return redirect(route('admin.documentCategories.index'));
        }

        return view('backend.document_categories.edit')->with('documentCategory', $documentCategory);
    }

    /**
     * Update the specified DocumentCategory in storage.
     *
     * @param  int              $id
     * @param UpdateDocumentCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDocumentCategoryRequest $request)
    {
        $documentCategory = $this->documentCategoryRepository->findWithoutFail($id);

        if (empty($documentCategory)) {
            Flash::error('Document Category not found');

            return redirect(route('admin.documentCategories.index'));
        }

        $documentCategory = $this->documentCategoryRepository->update($request->all(), $id);

        Flash::success('Document Category updated successfully.');

        return redirect(route('admin.documentCategories.index'));
    }

    /**
     * Remove the specified DocumentCategory from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $documentCategory = $this->documentCategoryRepository->findWithoutFail($id);

        if (empty($documentCategory)) {
            Flash::error('Document Category not found');

            return redirect(route('admin.documentCategories.index'));
        }

        $this->documentCategoryRepository->delete($id);

        Flash::success('Document Category deleted successfully.');

        return redirect(route('admin.documentCategories.index'));
    }
}
