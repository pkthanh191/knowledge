<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryDocMetaRequest;
use App\Http\Requests\UpdateCategoryDocMetaRequest;
use App\Repositories\CategoryDocMetaRepository;
use App\Repositories\DocumentMetaRepository;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;

class CategoryDocMetaController extends AppBaseController
{
    /** @var  CategoryDocMetaRepository */
    private $categoryDocMetaRepository;
    private $documentMetaRepository;

    public function __construct(CategoryDocMetaRepository $categoryDocMetaRepo, DocumentMetaRepository $documentMetaRepo)
    {
        $this->categoryDocMetaRepository = $categoryDocMetaRepo;
        $this->documentMetaRepository = $documentMetaRepo;
    }

    /**
     * Display a listing of the CategoryDocMeta.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $keyword = $request->search;
        if(!empty($keyword)){
            $categoryDocMetas = $this->categoryDocMetaRepository->findByField('name','LIKE','%'.$keyword.'%',["*"]);
        }else{
            $categoryDocMetas = $this->categoryDocMetaRepository->paginate(15);
        }
        return view('backend.category_doc_metas.index', compact('categoryDocMetas'));
    }

    /**
     * Show the form for creating a new CategoryDocMeta.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.category_doc_metas.create');
    }

    /**
     * Store a newly created CategoryDocMeta in storage.
     *
     * @param CreateCategoryDocMetaRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryDocMetaRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;

        $this->categoryDocMetaRepository->create($input);

        Flash::success(__('messages.created'));

        return redirect(route('admin.categoryDocMetas.index'));
    }

    /**
     * Display the specified CategoryDocMeta.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $categoryDocMeta = $this->categoryDocMetaRepository->findWithoutFail($id);

        if (empty($categoryDocMeta)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.categoryDocMetas.index'));
        }

        return view('backend.category_doc_metas.show', compact('categoryDocMeta'));
    }

    /**
     * Show the form for editing the specified CategoryDocMeta.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $categoryDocMeta = $this->categoryDocMetaRepository->findWithoutFail($id);

        if (empty($categoryDocMeta)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.categoryDocMetas.index'));
        }

        return view('backend.category_doc_metas.edit', compact('categoryDocMeta'));
    }

    /**
     * Update the specified CategoryDocMeta in storage.
     *
     * @param  int              $id
     * @param UpdateCategoryDocMetaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryDocMetaRequest $request)
    {
        $categoryDocMeta = $this->categoryDocMetaRepository->findWithoutFail($id);

        if (empty($categoryDocMeta)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.categoryDocMetas.index'));
        }

        $this->categoryDocMetaRepository->update($request->all(), $id);

        Flash::success(__('messages.updated'));

        return redirect(route('admin.categoryDocMetas.index'));
    }

    /**
     * Remove the specified CategoryDocMeta from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        if ($id == 'MULTI') {
            if(empty($request->ids)){
                Flash::warning(__('messages.category_doc_metas_multi_delete_no_item'));
                return redirect(route('admin.categoryDocMetas.index'));
            } else {
                foreach ($request->ids as $id) {
                    $categoryDocMeta = $this->categoryDocMetaRepository->findWithoutFail($id);

                    if (empty($categoryDocMeta)) {
                        Flash::error(__('messages.not-found'));

                        return redirect(route('admin.categoryDocMetas.index'));
                    }

                    $documents = $this->documentMetaRepository->findWhere([['category_doc_meta_id','=',$id]],['*']);
                    if(count($documents) == 0){
                        $this->categoryDocMetaRepository->delete($id);
                    }else{
                        Flash::error(__('messages.category_doc_metas_undeleted'));
                        return redirect(route('admin.categoryDocMetas.index'));
                    }
                }

                Flash::success(__('messages.deleted'));
                return redirect(route('admin.categoryDocMetas.index'));
            }
        } else {
            $categoryDocMeta = $this->categoryDocMetaRepository->findWithoutFail($id);

            if (empty($categoryDocMeta)) {
                Flash::error(__('messages.not-found'));

                return redirect(route('admin.categoryDocMetas.index'));
            }

            $documents = $this->documentMetaRepository->findWhere([['category_doc_meta_id','=',$id]],['*']);
            if(count($documents) == 0){
                $this->categoryDocMetaRepository->delete($id);

                Flash::success(__('messages.deleted'));

                return redirect(route('admin.categoryDocMetas.index'));
            }else{
                Flash::error(__('messages.category_doc_metas_undeleted'));

                return redirect(route('admin.categoryDocMetas.index'));
            }
        }
    }
}
