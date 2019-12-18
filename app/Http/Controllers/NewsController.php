<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Repositories\CategoryNewsRepository;
use App\Repositories\NewsRepository;
use App\Repositories\NewsCategoryRepository;
use App\Repositories\CommentNewsRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Response;
use App\Helpers\Helper;

class NewsController extends AppBaseController
{
    /** @var  NewsRepository */
    private $newsRepository;
    private $categoryNewsRepository;
    private $newsCategoryRepository;
    private $commentNewsRepository;

    public function __construct(NewsRepository $newsRepo, CategoryNewsRepository $categoryNewsRepo, NewsCategoryRepository $newsCategoryRepo, CommentNewsRepository $commentNewsRepo)
    {
        $this->newsRepository = $newsRepo;
        $this->categoryNewsRepository = $categoryNewsRepo;
        $this->newsCategoryRepository = $newsCategoryRepo;
        $this->commentNewsRepository = $commentNewsRepo;
    }

    /**
     * Display a listing of the News.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $categories = $this->categoryNewsRepository->buildTreeForSelectBox(['id','name'],'- ', null, __('messages.select_category_new'));

        $search = $request->search;
        $searchCondition = [];
        if(!empty($search)){
            if(!empty($search['name'])){
                array_push($searchCondition,['name','LIKE','%'.$search['name'].'%']);
            }
            if(!empty($search['category'])){
                $news = $this->newsRepository->orderBy('updated_at','desc')->search($searchCondition, $search['category']);
            }
            else {
                $news = $this->newsRepository->orderBy('updated_at','desc')->search($searchCondition);
            }
        }else{
            $news = $this->newsRepository->with('categories')->orderBy('updated_at','desc')->paginate(15);
        }

        return view('backend.news.index',compact('news', 'categories'));
    }

    /**
     * Show the form for creating a new News.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->categoryNewsRepository->buildTree(['id','name']);
        $selectedCategories = null;
        return view('backend.news.create',compact('categories', 'selectedCategories'));
    }

    /**
     * Store a newly created News in storage.
     *
     * @param CreateNewsRequest $request
     *
     * @return Response
     */
    public function store(CreateNewsRequest $request)
    {
        $input = $request->all();
        if($request->categories != null) {
            if (!empty($request->image)) {
                $imageName = time().'.'.Helper::transText($request->image->getClientOriginalName(),'-');
                $request->image->move(public_path('uploads/news'), $imageName);
                $request->image = $imageName;
                $input['image'] = '/public/uploads/news/'.$imageName;
            } else {
                $input['image'] = '/images/news/no-images-news.png';
            }
            $input["user_id"] = Auth::user()->id;
            $news = $this->newsRepository->create($input);

            Flash::success(__('messages.created'));

            return redirect(route('admin.news.index'));
        } else {
            Flash::error(__('messages.news_flash_select_category'));

            return back()->withInput();
        }
    }

    /**
     * Display the specified News.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.news.index'));
        }

        return view('backend.news.show')->with('news', $news);
    }

    /**
     * Show the form for editing the specified News.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $categories = $this->categoryNewsRepository->buildTree(['id','name']);
        $selectedCategories = $this->newsCategoryRepository->findByField('news_id', '=', $id, ['category_news_id'], false)->toArray(); #TODO:GET FULL CATEGORIES
        $arr = [];
        foreach ($selectedCategories as $selectedCategory) {
            array_push($arr, $selectedCategory['category_news_id']);
        }
        $selectedCategories = $arr;
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.news.index'));
        }

        return view('backend.news.edit',compact('news','categories','selectedCategories'));
    }

    /**
     * Update the specified News in storage.
     *
     * @param  int              $id
     * @param UpdateNewsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNewsRequest $request)
    {
        if($request->categories == null) {
            Flash::error(__('messages.news_flash_select_category'));
            return back()->withInput();
        }

        $news = $this->newsRepository->findWithoutFail($id);
        if (empty($news)) {
            Flash::error(__('messages.not-found'));
            return redirect(route('admin.news.index'));
        }

        $input = $request->all();
        if (!empty($request->image)) {
            $imageName = time().'.'.Helper::transText($request->image->getClientOriginalName(),'-');
            $request->image->move(public_path('uploads/news'), $imageName);
            $request->image = $imageName;
            $input['image'] = '/public/uploads/news/'.$imageName;
        }
        $news["user_id"] = Auth::user()->id;
        $news = $this->newsRepository->update($input, $id);

        Flash::success(__('messages.updated'));
        return redirect(route('admin.news.index'));
    }

    /**
     * Remove the specified News from storage.
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
                return back();
            }else{
                $checked = [];
                foreach ($request->ids as $id) {
                    $news = $this->newsRepository->findWithoutFail($id);
                    if (empty($news)) {
                        Flash::error(__('messages.not-found'));

                        return back();
                    }
                    if (!$news->comments->isEmpty()) {
                        Flash::warning(__('messages.alert_delete_comment'));
                        return back();
                    }
                    array_push($checked,$id);
                }
                foreach ($checked as $id){
                    $newsCategories = $this->newsCategoryRepository->findWhere([['news_id','=',$id]],['id'])->toArray()['data'];
                    foreach ($newsCategories as $newsCategory)
                    {
                        $this->newsCategoryRepository->delete($newsCategory['id']);
                    }

                    $this->newsRepository->delete($id);
                }
                Flash::success(__('messages.deleted'));

                return back();
            }
        }
        else
        {
            $news = $this->newsRepository->findWithoutFail($id);
            if (empty($news)) {
                Flash::error(__('messages.not-found'));
                return back();
            } elseif (!$news->comments->isEmpty()){
                Flash::warning(__('messages.alert_delete_comment'));
                return back();
            }
            $newsCategories = $this->newsCategoryRepository->findWhere([['news_id','=',$id]],['id'])->toArray()['data'];
            foreach ($newsCategories as $newsCategory)
            {
                $this->newsCategoryRepository->delete($newsCategory['id']);
            }

            $this->newsRepository->delete($id);

            Flash::success(__('messages.deleted'));

            return back();
        }
    }
}
