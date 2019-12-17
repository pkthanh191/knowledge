<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDocumentMetaRequest;
use App\Http\Requests\UpdateDocumentMetaRequest;
use App\Repositories\CategoryDocMetaRepository;
use App\Repositories\DocumentMetaRepository;
use App\Repositories\DocumentMetaValueRepository;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;

class DocumentMetaController extends AppBaseController
{
    /** @var  DocumentMetaRepository */
    private $documentMetaRepository;
    private $categoryDocMetaRepository;
    private $documentMetaValueRepository;

    public function __construct(DocumentMetaRepository $documentMetaRepo, CategoryDocMetaRepository $categoryDocMetaRepo, DocumentMetaValueRepository $documentMetaValueRepo)
    {
        $this->documentMetaRepository = $documentMetaRepo;
        $this->categoryDocMetaRepository = $categoryDocMetaRepo;
        $this->documentMetaValueRepository = $documentMetaValueRepo;
    }

    /**
     * Display a listing of the DocumentMeta.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $keyword = $request->search;
        if (!empty($keyword)) {
            $documentMetas = $this->documentMetaRepository->findByField('name', 'LIKE', '%' . $keyword . '%', ["*"]);
        } else {
            $documentMetas = $this->documentMetaRepository->orderBy('category_doc_meta_id')->orderBy('orderSort','asc')->orderBy('updated_at','desc')->paginate(15);
        }

        return view('backend.document_metas.index', compact('documentMetas'));
    }

    /**
     * Show the form for creating a new DocumentMeta.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->categoryDocMetaRepository->getAllForSelectBox(['id', 'name'], null, true);
        return view('backend.document_metas.create', compact('categories'));
    }

    /**
     * Store a newly created DocumentMeta in storage.
     *
     * @param CreateDocumentMetaRequest $request
     *
     * @return Response
     */
    public function store(CreateDocumentMetaRequest $request)
    {
        $input = $request->all();

        if ($input['category_doc_meta_id'] == 0) {
            Flash::error(__('messages.document_metas_no_category'));
            return back()->withInput();
        }

        $input['user_id'] = Auth::user()->id;

        $this->documentMetaRepository->create($input);

        Flash::success(__('messages.created'));

        return redirect(route('admin.documentMetas.index'));
    }

    /**
     * Display the specified DocumentMeta.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $documentMeta = $this->documentMetaRepository->findWithoutFail($id);

        if (empty($documentMeta)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.documentMetas.index'));
        }

        return view('backend.document_metas.show', compact('documentMeta'));
    }

    /**
     * Show the form for editing the specified DocumentMeta.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $categories = $this->categoryDocMetaRepository->getAllForSelectBox(['id', 'name'], null, true);
        $documentMeta = $this->documentMetaRepository->findWithoutFail($id);

        if (empty($documentMeta)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.documentMetas.index'));
        }

        return view('backend.document_metas.edit', compact('categories', 'documentMeta'));
    }

    /**
     * Update the specified DocumentMeta in storage.
     *
     * @param  int $id
     * @param UpdateDocumentMetaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDocumentMetaRequest $request)
    {
        $documentMeta = $this->documentMetaRepository->findWithoutFail($id);

        if (empty($documentMeta)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.documentMetas.index'));
        }

        if ($request->category_doc_meta_id == 0) {
            Flash::error(__('messages.document_metas_no_category'));
            return back()->withInput();
        }

        $this->documentMetaRepository->update($request->all(), $id);

        Flash::success(__('messages.updated'));

        return redirect(route('admin.documentMetas.index'));
    }

    /**
     * Remove the specified DocumentMeta from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        if ($id == 'MULTI') {
            if (empty($request->ids)) {
                Flash::warning(__('messages.document_metas__multi_delete_no_item'));
                return redirect(route('admin.documentMetas.index'));
            } else {
                foreach ($request->ids as $id) {
                    $documentMetasValues = $this->documentMetaValueRepository->findByField('doc_meta_id', '=', $id);
                    $canDelete = true;
                    foreach ($documentMetasValues as $key => $documentMetasValue) {
                        if (count($documentMetasValue) > 0 && $documentMetasValue->value != null) {
                            $canDelete = false;
                            break;
                        }
                    }
                    if ($canDelete == true) {
                        foreach ($documentMetasValues as $key => $documentMetasValue) {
                            $this->documentMetaValueRepository->delete($documentMetasValue->id);
                        }
                        $this->documentMetaRepository->delete($id);
                    }
                }
                if ($canDelete == true) {
                    Flash::success(__('messages.deleted'));
                }
                else{
                    Flash::error(__('messages.document_metas_cannot_delete_have_metas_value'));
                }
                    return redirect(route('admin.documentMetas.index'));
            }
        } else {
            $documentMetasValues = $this->documentMetaValueRepository->findByField('doc_meta_id', '=', $id);
            $canDelete = true;
            foreach ($documentMetasValues as $key => $documentMetasValue) {
                if (count($documentMetasValue) > 0 && $documentMetasValue->value != null) {
                    $canDelete = false;
                    break;
                }
            }
            if ($canDelete == true) {
                foreach ($documentMetasValues as $key => $documentMetasValue) {
                    $this->documentMetaValueRepository->delete($documentMetasValue->id);
                }
                $this->documentMetaRepository->delete($id);
                Flash::success(__('messages.deleted'));
            } else {
                Flash::error(__('messages.document_metas_cannot_delete_have_metas_value'));
            }
            return redirect(route('admin.documentMetas.index'));
        }
    }
}
