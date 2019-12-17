<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryNewsRequest;
use App\Http\Requests\UpdateCategoryNewsRequest;
use App\Repositories\CategoryNewsRepository;
use App\Repositories\NewsCategoryRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Response;

class CategoryNewsController extends AppBaseController
{
    /** @var  CategoryNewsRepository */
    private $categoryNewsRepository;
    private $newsCategoryRepository;

    public function __construct(CategoryNewsRepository $categoryNewsRepo, NewsCategoryRepository $newsCategoryRepo)
    {
        $this->categoryNewsRepository = $categoryNewsRepo;
        $this->newsCategoryRepository = $newsCategoryRepo;
    }

    /**
     * Display a listing of the CategoryNews.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $searchCondition = [];
        if(!empty($search)){
            if(!empty($search['name'])){
                array_push($searchCondition,['name','LIKE','%'.$search['name'].'%']);
            }
            $categoryNews = $this->categoryNewsRepository->findWhere($searchCondition);
        }else{
            $categoryNews = $this->categoryNewsRepository->orderBy('orderSort','asc')->orderBy('updated_at','desc')->buildTree();
        }

        return view('backend.category_news.index',compact('categoryNews'));
    }

    /**
     * Show the form for creating a new CategoryNews.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->categoryNewsRepository->buildTreeForSelectBox(['id', 'name'], $this->SEPARATOR_SPACE, null,__('messages.select_category_new'));
        return view('backend.category_news.create', compact('categories'));
    }

    /**
     * Store a newly created CategoryNews in storage.
     *
     * @param CreateCategoryNewsRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryNewsRequest $request)
    {
        $input = $request->all();
        $input["user_id"] = Auth::user()->id;
        $categoryNews = $this->categoryNewsRepository->create($input);

        Flash::success(__('messages.created'));

        return redirect(route('admin.categoryNews.index'));
    }

    /**
     * Display the specified CategoryNews.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $categoryNews = $this->categoryNewsRepository->findWithoutFail($id);

        if (empty($categoryNews)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.categoryNews.index'));
        }

        return view('backend.category_news.show',compact('categoryNews'));
    }

    /**
     * Show the form for editing the specified CategoryNews.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $categoryNews = $this->categoryNewsRepository->findWithoutFail($id);
        $categories = $this->categoryNewsRepository->buildTreeForSelectBox(['id', 'name'], $this->SEPARATOR_SPACE, $id,__('messages.select_category_new'));

        if (empty($categoryNews)) {
            Flash::error('Category News not found');

            return redirect(route('admin.categoryNews.index'));
        }
        return view('backend.category_news.edit', compact('categories','categoryNews'));
    }

    /**
     * Update the specified CategoryNews in storage.
     *
     * @param  int $id
     * @param UpdateCategoryNewsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryNewsRequest $request)
    {
        $categoryNews = $this->categoryNewsRepository->findWithoutFail($id);

        if (empty($categoryNews)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.categoryNews.index'));
        }

        $categoryNews = $this->categoryNewsRepository->update($request->all(), $id);

        Flash::success(__('messages.updated'));

        return redirect(route('admin.categoryNews.index'));
    }

    /**
     * Remove the specified CategoryNews from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        if($id == 'MULTI')
        {
            if (empty($request->ids)){
                Flash::warning(__('messages.not-found'));
                return redirect(route('admin.news.index'));
            }else{
                foreach ($request->ids as $id){
                    $categoryNews = $this->categoryNewsRepository->findWithoutFail($id);

                    if (empty($categoryNews)) {
                        Flash::error(__('messages.not-found'));

                        return redirect(route('admin.categoryNews.index'));
                    }

                    $children = $this->categoryNewsRepository->findWhere([['parent_id','=',$id]],['*']);
                    $documents = $this->newsCategoryRepository->findWhere([['category_news_id','=',$id]],['*']);
                    if(count($children) == 0 && count($documents) == 0){
                        $this->categoryNewsRepository->delete($id);
                    }else{
                        Flash::error(__('messages.undeleted'));

                        return redirect(route('admin.categoryNews.index'));
                    }
                }
                Flash::success(__('messages.deleted'));

                return redirect(route('admin.categoryNews.index'));
            }
        } else {
            $categoryNews = $this->categoryNewsRepository->findWithoutFail($id);

            if (empty($categoryNews)) {
                Flash::error(__('messages.not-found'));

                return redirect(route('admin.categoryNews.index'));
            }

            $children = $this->categoryNewsRepository->findWhere([['parent_id','=',$id]],['*']);
            $documents = $this->newsCategoryRepository->findWhere([['category_news_id','=',$id]],['*']);
            if(count($children) == 0 && count($documents) == 0){
                $this->categoryNewsRepository->delete($id);

                Flash::success(__('messages.deleted'));

                return redirect(route('admin.categoryNews.index'));
            }else{
                Flash::error(__('messages.undeleted'));

                return redirect(route('admin.categoryNews.index'));
            }
        }
    }
}
