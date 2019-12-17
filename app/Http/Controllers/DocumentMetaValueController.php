<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDocumentMetaValueRequest;
use App\Http\Requests\UpdateDocumentMetaValueRequest;
use App\Repositories\DocumentMetaValueRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class DocumentMetaValueController extends AppBaseController
{
    /** @var  DocumentMetaValueRepository */
    private $documentMetaValueRepository;

    public function __construct(DocumentMetaValueRepository $documentMetaValueRepo)
    {
        $this->documentMetaValueRepository = $documentMetaValueRepo;
    }

    /**
     * Display a listing of the DocumentMetaValue.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->documentMetaValueRepository->pushCriteria(new RequestCriteria($request));
        $documentMetaValues = $this->documentMetaValueRepository->all();

        return view('backend.document_meta_values.index')
            ->with('documentMetaValues', $documentMetaValues);
    }

    /**
     * Show the form for creating a new DocumentMetaValue.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.document_meta_values.create');
    }

    /**
     * Store a newly created DocumentMetaValue in storage.
     *
     * @param CreateDocumentMetaValueRequest $request
     *
     * @return Response
     */
    public function store(CreateDocumentMetaValueRequest $request)
    {
        $input = $request->all();

        $documentMetaValue = $this->documentMetaValueRepository->create($input);

        Flash::success('Document Meta Value saved successfully.');

        return redirect(route('admin.documentMetaValues.index'));
    }

    /**
     * Display the specified DocumentMetaValue.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $documentMetaValue = $this->documentMetaValueRepository->findWithoutFail($id);

        if (empty($documentMetaValue)) {
            Flash::error('Document Meta Value not found');

            return redirect(route('admin.documentMetaValues.index'));
        }

        return view('backend.document_meta_values.show')->with('documentMetaValue', $documentMetaValue);
    }

    /**
     * Show the form for editing the specified DocumentMetaValue.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $documentMetaValue = $this->documentMetaValueRepository->findWithoutFail($id);

        if (empty($documentMetaValue)) {
            Flash::error('Document Meta Value not found');

            return redirect(route('admin.documentMetaValues.index'));
        }

        return view('backend.document_meta_values.edit')->with('documentMetaValue', $documentMetaValue);
    }

    /**
     * Update the specified DocumentMetaValue in storage.
     *
     * @param  int              $id
     * @param UpdateDocumentMetaValueRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDocumentMetaValueRequest $request)
    {
        $documentMetaValue = $this->documentMetaValueRepository->findWithoutFail($id);

        if (empty($documentMetaValue)) {
            Flash::error('Document Meta Value not found');

            return redirect(route('admin.documentMetaValues.index'));
        }

        $documentMetaValue = $this->documentMetaValueRepository->update($request->all(), $id);

        Flash::success('Document Meta Value updated successfully.');

        return redirect(route('admin.documentMetaValues.index'));
    }

    /**
     * Remove the specified DocumentMetaValue from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $documentMetaValue = $this->documentMetaValueRepository->findWithoutFail($id);

        if (empty($documentMetaValue)) {
            Flash::error('Document Meta Value not found');

            return redirect(route('admin.documentMetaValues.index'));
        }

        $this->documentMetaValueRepository->delete($id);

        Flash::success('Document Meta Value deleted successfully.');

        return redirect(route('admin.documentMetaValues.index'));
    }
}
