<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\CreateCommentNewsRequest;
use App\Repositories\CategoryDocRepository;
use App\Repositories\CategoryTestRepository;
use App\Repositories\CommentNewsRepository;
use App\Repositories\NewsRepository;
use App\Repositories\CategoryNewsRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\BannerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Helpers\Helper;

class NewsController extends FrontendBaseController
{
    private $categoryNewsRepository;
    private $newsRepository;
    private $commentNewsRepository;
    private $bannerRepository;

    public function __construct(CategoryDocRepository $categoryDocRepo, CategoryTestRepository $categoryTestRepo, CategoryNewsRepository $categoryNewsRepo, NewsRepository $newsRepo, CommentNewsRepository $commentNewsRepo, BannerRepository $bannerRepo)
    {
        parent::__construct($categoryDocRepo, $categoryTestRepo);

        $this->categoryNewsRepository = $categoryNewsRepo;
        $this->newsRepository = $newsRepo;
        $this->commentNewsRepository = $commentNewsRepo;
        $this->bannerRepository = $bannerRepo;
    }
    public function index(Request $request)
    {
        $docCategories = $this->getDocCategories();
        $testCategories = $this->getTestCategories();
        $banners = $this->bannerRepository->getbyChecked();

        $newsCategories = $this->categoryNewsRepository->buildTree(['*'],$this->SEPARATOR_SPACE);
        $allNews = $this->newsRepository->all();

        $categorySlug = $request['danh-muc'];
        $parentArrayDoc= [];
        $parentArrayNews= $categorySlug? $this->categoryNewsRepository->getParentBySlug($categorySlug) : [];

        $mode = $request['mode'];

        /*SEARCH BY CATEGORY & NAME*/
        $search = $request['search'];
        if ($search!= null) $search = $search['name'];

        $type = 'news';
        $currentCategory = $this->categoryNewsRepository->findWhere([['slug','=',$categorySlug]],['*'],false)->first();

        $news = $this->newsRepository->orderBy('updated_at','desc')->getNewsByCategorySlug($categorySlug, $search, 10);
        return view('frontend.news.index', compact('meta_title','meta_keywords','meta_description','docCategories', 'testCategories', 'newsCategories', 'news', 'mode', 'search', 'categorySlug', 'type','allNews', 'newsIndex', 'currentCategory','parentArrayDoc','parentArrayNews', 'banners'));
    }

    public function show($slug, Request $request) {
        $newsIndex = $this->newsRepository->findByField('slug', '=', $slug, ['*'], false)->first();
        $newsRelatives = $this->newsRepository->getRelatives($newsIndex);
        $newsRecent = $this->newsRepository->orderBy('created_at','desc')->paginate(6);
        $newsCategories = $this->categoryNewsRepository->buildTree(['*'],$this->SEPARATOR_SPACE);
        $allNews = $this->newsRepository->all();

        $banners = $this->bannerRepository->getbyChecked();
        $categorySlug = $request['danh-muc'];
//        $parentArrayDoc= [];
        $parentArrayNews= $categorySlug? $this->categoryNewsRepository->getParentBySlug($categorySlug) : [];
        $mode = $request['mode'];
        /*SEARCH BY CATEGORY & NAME*/
        $search = $request['search'];
        if ($search!= null) $search = $search['name'];
        $type = 'news';
        $news = $this->newsRepository->getNewsByCategorySlug($categorySlug, $search, 10);

        $commentCount = count($newsIndex->comments);
        foreach ($newsIndex->comments as $commentChild) {
            $commentCount += count($commentChild->child);
        }

        $newsIndex->view_counts += 1;
        $newsIndex->timestamps = false;
        $newsIndex->save();

        return view('frontend.news.show', compact('meta_title','meta_keywords','meta_description','newsIndex', 'news', 'mode', 'newsRelatives', 'newsRecent', 'search', 'newsCategories', 'categorySlug', 'type','allNews', 'commentCount','parentArrayNews', 'banners'));
    }

    public function comment(CreateCommentNewsRequest $request)
    {
        if ($request->ajax()) {
            if (Auth::check()) {
                $user = Auth::user();
                $input = $request->all();
                $news = $this->newsRepository->findByField('slug', '=', $input['slug'], ['*'], false)->first();
                    $input['user_id'] = $user->id;
                    $input['news_id'] = $news->id;
                    $comment = $this->commentNewsRepository->create($input);
                    $news->comment_counts = count($this->commentNewsRepository->findByField('news_id', '=', $news->id, ['*'], false));
                    $result = array(
                        'content' => Helper::makeLinks($comment->content, null, $news->slug),
                        'comment_id' => $comment->id,
                        'updated_at' => $comment->updated_at->format('Y-m-d H:i:s'),
                        'user' => $comment->user->name,
                        'avatar' =>  (!empty($comment->user->avatar) && file_exists(public_path($comment->user->avatar)))?$comment->user->avatar:'/public/uploads/default-avatar.png',
                        'comment_counts' => $news->comment_counts,
                        'view_counts' => $news->view_counts,
                        'account_balanced' => $user->account_balance);
                    $news->timestamps = false;
                    $news->save();
                    return Response::json($result);
            }
        }
    }
}
