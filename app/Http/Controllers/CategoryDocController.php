<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryDocRequest;
use App\Http\Requests\UpdateCategoryDocRequest;
use App\Repositories\CategoryDocRepository;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Repositories\DocumentCategoryRepository;

class CategoryDocController extends AppBaseController
{
    /** @var  CategoryDocRepository */
    private $categoryDocRepository;
    private $documentCategoryRepository;

    public function __construct(CategoryDocRepository $categoryDocRepository,DocumentCategoryRepository $documentCategoryRepository)
    {
        $this->categoryDocRepository = $categoryDocRepository;
        $this->documentCategoryRepository = $documentCategoryRepository;
    }

    /**
     * Display a listing of the CategoryDoc.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $keyword = $request->search;
        if(!empty($keyword)){
            $categoryDocs = $this->categoryDocRepository->findByField('name','LIKE','%'.$keyword.'%',["*"]);
        }else{
            $categoryDocs = $this->categoryDocRepository->orderBy('orderSort','asc')->orderBy('updated_at','desc')->buildTree();
        }

        return view('backend.category_docs.index', compact('categoryDocs'));
    }

    /**
     * Show the form for creating a new CategoryDoc.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->categoryDocRepository->buildTreeForSelectBox(['id', 'name'], $this->SEPARATOR_SPACE, null, __('messages.select_category_document'));
        return view('backend.category_docs.create', compact('categories'));
    }

    /**
     * Store a newly created CategoryDoc in storage.
     *
     * @param CreateCategoryDocRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryDocRequest $request)
    {
        $input = $request->all();

        $this->categoryDocRepository->create($input);

        Flash::success(__('messages.created'));

        return redirect(route('admin.categoryDocs.index'));
    }

    /**
     * Display the specified CategoryDoc.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $categoryDoc = $this->categoryDocRepository->findWithoutFail($id);

        if (empty($categoryDoc)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.categoryDocs.index'));
        }

        return view('backend.category_docs.show', compact('categoryDoc'));
    }

    /**
     * Show the form for editing the specified CategoryDoc.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $categoryDoc = $this->categoryDocRepository->findWithoutFail($id);
        $categories = $this->categoryDocRepository->buildTreeForSelectBox(['id', 'name'], $this->SEPARATOR_SPACE, $id, __('messages.select_category_document'));
        if (empty($categoryDoc)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.categoryDocs.index'));
        }
        return view('backend.category_docs.edit', compact('categoryDoc', 'categories'));
    }

    /**
     * Update the specified CategoryDoc in storage.
     *
     * @param  int              $id
     * @param UpdateCategoryDocRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryDocRequest $request)
    {

        $categoryDoc = $this->categoryDocRepository->findWithoutFail($id);
        if (empty($categoryDoc)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.categoryDocs.index'));
        }

        $this->categoryDocRepository->update($request->all(), $id);

        Flash::success(__('messages.updated'));

        return redirect(route('admin.categoryDocs.index'));
    }

    /**
     * Remove the specified CategoryDoc from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        if ($id == 'MULTI') {
            if(empty($request->ids)){
                Flash::warning(__('messages.category_doc_multi_delete_no_item'));
                return redirect(route('admin.categoryDocs.index'));
            } else{
                $legals=[];
                $illegals=[];
                foreach ($request->ids as $id) {
                    $categoryDoc = $this->categoryDocRepository->findWithoutFail($id);
                    if (empty($categoryDoc)) {
                        Flash::error(__('messages.not-found'));
                        return redirect(route('admin.categoryDocs.index'));
                    }
                    $children = $this->categoryDocRepository->findWhere([['parent_id','=',$id]],['*']);
                    $documents = $this->documentCategoryRepository->findWhere([['category_id','=',$id]],['*']);
                    if(count($children) == 0 && count($documents) == 0){
                        $legals[]=$id;
                    }else{
                        $illegals[]=$this->categoryDocRepository->findWithoutFail($id);
                    }
                }
                if(count($illegals)!=0){
                    $rs='';
                    $len = count($illegals);
                    for($i = 0 ; $i < $len ; $i++){
                        if($i != $len - 1){
                            $rs .= ' '.$illegals[$i]->name.',';
                        }else{
                            $rs .= ' '.$illegals[$i]->name;
                        }
                    }
                    $contains = __('messages.contains');
                    $messages = __('messages.undeleted');
                    Flash::error($messages.': '.$rs.' '.$contains);
                    return redirect(route('admin.categoryDocs.index'));
                } else {
                    foreach ($legals as $id){
                        $this->categoryDocRepository->delete($id);
                    }
                }
                Flash::success(__('messages.deleted'));
                return redirect(route('admin.categoryDocs.index'));
            }

        } else {
            $categoryDoc = $this->categoryDocRepository->findWithoutFail($id);
            if (empty($categoryDoc)) {
                Flash::error(__('messages.not-found'));
                return redirect(route('admin.categoryDocs.index'));
            }
            $children = $this->categoryDocRepository->findWhere([['parent_id','=',$id]],['*']);
            $documents = $this->documentCategoryRepository->findWhere([['category_id','=',$id]],['*']);
            if(count($children) == 0 && count($documents) == 0){
                $this->categoryDocRepository->delete($id);

                Flash::success(__('messages.deleted'));

                return redirect(route('admin.categoryDocs.index'));
            } else {
                Flash::error(__('messages.undeleted'));

                return redirect(route('admin.categoryDocs.index'));
            }
        }
    }
}
