<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Helper;
use App\Http\Requests\CreateCommentTestRequest;
use App\Repositories\CategoryDocRepository;
use App\Repositories\CategoryTestRepository;
use App\Repositories\CommentTestRepository;
use App\Repositories\BannerRepository;
use App\Repositories\TestRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Flash;

class TestController extends FrontendBaseController
{
    private $testRepository;
    private $commentTestRepository;
    private $transactionRepository;
    private $bannerRepository;


    public function __construct(CategoryDocRepository $categoryDocRepo, CategoryTestRepository $categoryTestRepo, TestRepository $testRepo, CommentTestRepository $commentTestRepo, TransactionRepository $transactionRepository, BannerRepository $bannerRepo)
    {
        parent::__construct($categoryDocRepo, $categoryTestRepo);
        $this->testRepository = $testRepo;
        $this->commentTestRepository = $commentTestRepo;
        $this->transactionRepository = $transactionRepository;
        $this->bannerRepository = $bannerRepo;
    }

    public function index(Request $request)
    {
        $testCategories = $this->getTestCategories();
        $docCategories = $this->getDocCategories();
        $banners = $this->bannerRepository->getbyChecked();
        $categorySlug = $request['danh-muc'];
        $parentArrayTest = $categorySlug ? $this->categoryTestRepository->getParentBySlug($categorySlug) : [];

        $mode = $request['mode'];

        $currentCategory = $this->categoryTestRepository->findWhere([['slug', '=', $categorySlug]], ['*'], false)->first();

        /*SEARCH BY CATEGORY & NAME*/
        $search = $request['search'];
        if ($search != null) $search = $search['name'];

        $type = 'tests';

        $tests = $this->testRepository->getTestsByCategorySlug($categorySlug, $search);
        return view('frontend.tests.index', compact('meta_title', 'meta_keywords', 'meta_description', 'docCategories', 'testCategories', 'tests', 'mode', 'search', 'categorySlug', 'type', 'currentCategory', 'parentArrayTest', 'banners'));
    }

    public function show($slug)
    {
        $categoryTests = $this->categoryTestRepository->buildTree(['*'], $this->SEPARATOR_SPACE);
        $categorySlug = '';
        $test = $this->testRepository->findByField('slug', '=', $slug, ['*'], false)->first();
        $test->view_counts += 1;
        $test->timestamps = false;
        $test->save();
        $testRelatives = $this->testRepository->getRelatives($test);
        $testRecent = $this->testRepository->orderBy('created_at', 'desc')->paginate(6);
        $testComments = $this->testRepository->orderBy('comment_counts', 'desc')->paginate(6);
        $testViews = $this->testRepository->orderBy('view_counts', 'desc')->paginate(6);

        #TODO: Lấy phần liên quan khác phục vụ cho phần chi tiết.

        if (empty($test)) {
            #TODO: Xử lý
        }

        $commentCount = count($test->comments);
        foreach ($test->comments as $commentChild) {
            $commentCount += count($commentChild->child);
        }

        $type = 'tests';

        return view('frontend.tests.show', compact('meta_title', 'meta_keywords', 'meta_description', 'test', 'testRelatives', 'testRecent', 'testViews', 'testComments', 'categoryTests', 'type', 'commentCount', 'categorySlug'));
    }

    public function comment(CreateCommentTestRequest $request)
    {
        if ($request->ajax()) {
            if (Auth::check()) {
                $user = Auth::user();
                $input = $request->all();
                $test = $this->testRepository->findByField('slug', '=', $input['slug'], ['*'], false)->first();
                $input['user_id'] = $user->id;
                $input['test_id'] = $test->id;
                $comment = $this->commentTestRepository->create($input);
                $test->comment_counts = count($this->commentTestRepository->findByField('test_id', '=', $test->id, ['*'], false));
                $result = array(
                    'content' => Helper::makeLinks($comment->content,$comment->id, null, $test->slug),
                    'comment_id' => $comment->id,
                    'updated_at' => $comment->updated_at->format('Y-m-d H:i:s'),
                    'user' => $comment->user->name,
                    'avatar' => (!empty($comment->user->avatar) && file_exists(public_path($comment->user->avatar)))?$comment->user->avatar:'/public/uploads/default-avatar.png',
                    'comment_counts' => $test->comment_counts,
                    'view_counts' => $test->view_counts,
                    'account_balance' => $user->account_balance
                );
                $test->timestamps = false;
                $test->save();
                return Response::json($result);
            }
        }
    }

    public function link_download(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::check()) {
                $input = $request->all();
                $test = $this->testRepository->findByField('slug', '=', $input['slug'], ['*'], false)->first();
                $user = Auth::user();
                if ($user->account_balance >= Helper::rip_tags(config('system.minus-knows-download.value'))) {
                    $user->account_balance -= Helper::rip_tags(config('system.minus-knows-download.value'));
                    $user->save();
                    if($request['comment_id']){
                        $comment = $this->commentTestRepository->find($request['comment_id']);
                        $content = $comment->content;
                        preg_match_all('#\b(http|https|ftp|ftps)?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $content, $match);
//                        return Response::json(['ok'=>$match[0]]);
                        return Response::json([
                            'comment' =>true,
                            'link_download' => $match[0][0] ,
                            'account_balance' => $user->account_balance,
                        ]);
                    }
                    $this->transactionRepository->create([
                        'content' => Helper::$TRANS_DOWNLOAD_TEST,
                        'money_transfer' => Helper::rip_tags(config('system.minus-knows-download.value')),
                        'status' => 1,
                        'user_id' => $user->id,
                        'test_id' => $test->id,
                    ]);

                    $result = array(
                        'user' => $user->name,
                        'link_download' => $test->link_download,
                        'account_balance' => $user->account_balance,
                        'know_link_download' => Helper::rip_tags(config('system.minus-knows-download.value'))
                    );
                    return Response::json($result);
                }
                return Response::json(['account_balance' => $user->account_balance,
                    'know_link_download' => Helper::rip_tags(config('system.minus-knows-download.value'))
                ]);
            }
        }
    }

    public function download(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::check()) {
                $input = $request->all();
                $test = $this->testRepository->findByField('slug', '=', $input['slug'], ['*'], false)->first();
                $user = Auth::user();
                if ($user->account_balance >= Helper::rip_tags(config('system.minus-knows-download.value'))) {
                    $link = $test->file;
                    $file = url('/') . '/public/' . $link;
                    $user->account_balance -= Helper::rip_tags(config('system.minus-knows-download.value'));
                    $user->save();
                    $this->transactionRepository->create([
                        'content' => Helper::$TRANS_DOWNLOAD_TEST,
                        'money_transfer' => Helper::rip_tags(config('system.minus-knows-download.value')),
                        'status' => 1,
                        'user_id' => $user->id,
                        'test_id' => $test->id,
                    ]);
                    $result = array(
                        'user' => $user->name,
                        'file' => $file,
                        'account_balance' => $user->account_balance,
                        'know_download' => Helper::rip_tags(config('system.minus-knows-download.value'))
                    );
                    return Response::json($result);
                }
                return Response::json(['account_balance' => $user->account_balance,
                    'know_download' => Helper::rip_tags(config('system.minus-knows-download.value'))
                ]);
            }
        }
    }
}
