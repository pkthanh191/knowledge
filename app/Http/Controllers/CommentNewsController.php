<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\CreateCommentNewsRequest;
use App\Http\Requests\UpdateCommentNewsRequest;
use App\Repositories\CommentNewsRepository;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Repositories\NewsRepository;
use App\Repositories\UserRepository;
use App\Repositories\CategoryNewsRepository;

class CommentNewsController extends AppBaseController
{
    /** @var  CommentNewsRepository */
    private $commentNewRepository;
    private $newsRepository;
    private $userRepository;
    private $categoryNewsRepository;

    public function __construct(CommentNewsRepository $commentNewRepo, NewsRepository $newsRepo,UserRepository $userRepo, CategoryNewsRepository $categoryNewsRepo)
    {
        $this->commentNewRepository = $commentNewRepo;
        $this->newsRepository = $newsRepo;
        $this->userRepository = $userRepo;
        $this->categoryNewsRepository = $categoryNewsRepo;
    }

    /**
     * Display a listing of the CommentTest.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $categories = $this->categoryNewsRepository->buildTreeForSelectBox(['id', 'name'],$this->SEPARATOR_SPACE,null,__('messages.select_category_new'));
        $search = $request->search;
        $searchConditions = [];
        if (!empty($search)) {
            if (!empty($search['category']) && $search['category'] != 0) {
                $news = $this->newsRepository->getNewsByComment($search['category']);
            }
            else{
                if ($search['news_id'] == 0) {
                    $news = $this->newsRepository->getNewsByComment();
                }
            }
            if ($search['news_id'] != 0) {
                array_push($searchConditions, ['id', '=', $search['news_id']]);
                $news = $this->newsRepository->findWhere($searchConditions);
            }

        } else {
            $news = $this->newsRepository->getNewsByComment();
        }
        $index = 1;
        $newsSearch = $this->newsRepository->getAllNewsByCategoryForSelectBox(['news.*'], null, true, __('messages.news_choose_name'), $search['category']);
        return view('backend.comment_news.index', compact('newsSearch', 'news', 'categories','index'));
    }

    /**
     * Show the form for creating a new CommentTest.
     *
     * @return Response
     */
    public function create()
    {
        $news = $this->newsRepository->getAllForSelectBox(['*'],null, true, __('messages.news_choose_name'));
        $commentNews = ['0'=>"-- ".__('messages.select_comment_new')." --"];
        $users = $this->userRepository->getAllForSelectBox(['id' , 'name'], null, true,__('messages.select_user'));
        return view('backend.comment_news.create',compact('news','commentNews','users'));
    }

    /**
     * Store a newly created CommentTest in storage.
     *
     * @param CreateCommentTestRequest $request
     *
     * @return Response
     */
    public function store(CreateCommentNewsRequest $request)
    {
        $input = $request->all();

        $commentNews = $this->commentNewRepository->create($input);

        Flash::success(__('messages.created'));

        return redirect(route('admin.commentNews.index'));
    }

    /**
     * Display the specified CommentTest.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $new = $this->newsRepository->findByField('id', '=', $id, ['*'], false)->first();
        $commentCount = count($new->comments);
        foreach ($new->comments as $commentChild) {
            $commentCount += count($commentChild->child);
        }
        if (empty($new)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.commentNews.index'));
        }

        return view('backend.comment_news.show', compact('new','commentCount'));
    }

    /**
     * Show the form for editing the specified CommentTest.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $commentNew = $this->commentNewRepository->findWithoutFail($id);

        if (empty($commentNew)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.commentNews.index'));
        }
        $news = $this->newsRepository->getAllForSelectBox(['*'],null, true,__('messages.select_comment_new'));
        // get comments for select box
        $commentNews = Helper::formatSelectBoxForComment($commentNew->news->comments);
        if($commentNew->parent_id == 0){
            $commentNews = Helper::formatSelectBoxForComment($commentNew->news->comments,$commentNew->news->id);
        }
        $users = $this->userRepository->getAllForSelectBox(['id' , 'name'], null, true, __('messages.select_user'));
        return view('backend.comment_news.edit',compact('commentNew','commentNews','users','news'));
    }

    /**
     * Update the specified CommentTest in storage.
     *
     * @param  int              $id
     * @param UpdateCommentTestRequest $request
     *
     * @return Response
     */
    public function update(UpdateCommentNewsRequest $request)
    {
        $commentNew = $this->commentNewRepository->update($request->all(), $request['id']);
        $result = array(
            'comment_id' => $commentNew->id,
            'user' => $commentNew->user->name,
            'content' => $commentNew->content,
            'updated_at' => $commentNew->updated_at->format('Y-m-d H:i:s'));
        return Response::json($result);
    }

    /**
     * Remove the specified CommentTest from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id,Request $request)
    {
        $commentNews = $this->commentNewRepository->findWithoutFail($request['parent_id']);
        $news = $this->newsRepository->findByField('slug', '=', $request['slug'], ['*'], false)->first();
        $replies = $commentNews->children();
        if (count($replies) > 0) {
            foreach ($replies as $reply){
                $this->commentNewRepository->delete($reply->id);
            }
        }
        $this->commentNewRepository->delete($request['parent_id']);
        $news->comment_counts = count($this->commentNewRepository->findByField('news_id', '=', $news->id, ['*'], false));
        $result = array(
            'comment_id' => $commentNews->id,
            'user' => $commentNews->user->name,
            'comment_counts' => $news->comment_counts);
        $news->save();
        return Response::json($result);
//        if ($id == 'MULTI') {
//            if(!is_null($request->ids )){
//                foreach ($request->ids as $id) {
//                    $comment = $this->commentNewRepository->findWithoutFail($id);
//
//                    if (empty($comment)) {
//                        Flash::error(__('messages.no-items'));
//
//                        return redirect(route('admin.commentNews.index'));
//                    }
//                    $replies = $comment->children();
//                    if(count($replies) >0){
//                        Flash::error(__('messages.comments_cannot_delete_have_replies'));
//                        return redirect(route('admin.commentNews.index'));
//                    }
//
//                    $this->commentNewRepository->delete($id);
//                }
//                Flash::success(__('messages.deleted'));
//                return redirect(route('admin.commentNews.index'));
//            }else{
//                Flash::error(__('messages.comments_please_choose_categories'));
//                return redirect(route('admin.commentNews.index'));
//            }
//        }else{
//            $commentNew = $this->commentNewRepository->findWithoutFail($id);
//
//            if (empty($commentNew)) {
//                Flash::error(__('messages.not-found'));
//
//                return redirect(route('admin.commentNews.index'));
//            }
//
//            $replies = $commentNew->children();
//            if(count($replies) >0){
//                Flash::error(__('messages.comments_cannot_delete_have_replies'));
//                return redirect(route('admin.commentNews.index'));
//            }
//
//            $this->commentNewRepository->delete($id);
//
//            Flash::success(__('messages.deleted'));
//
//            return redirect(route('admin.commentNews.index'));
//        }
    }

    public function autoComment(Request $request)
    {
        $input = $request->all();
        #TODO: Tìm người dùng chuyên để auto-comment
        $users = $this->userRepository->findByField('group_id', '=', 4, ['*'], false);
        $acc = null;
        if (count($users) < 10) {
            $user['name'] = Helper::generateName();
            $user['avatar'] = '/public/uploads/default-image.png';
            $user['email'] = Helper::generateRandomString() . '@gmail.com';
            $user['password'] = Hash::make($user['email']);
            $user['group_id'] = 4;
            $user['phone'] = Helper::generateTel(11);
            $acc = $this->userRepository->create($user);
        } else {
            #TODO: Random id user auto-comment
            $index = rand(0, count($users) - 1);
        }

        $comment['content'] = $input['content'];

        $parent_id = $this->commentNewRepository->findByField('id', '=', $input['id'], ['*'], false)[0]['parent_id'];
        $comment['parent_id'] = ($parent_id == 0) ? $input['id'] : $parent_id;
        $comment['user_id'] = ($acc != null) ? $acc->id : $users[$index]['id'];
        $comment['news_id'] = $this->commentNewRepository->findByField('id', '=', $input['id'], ['*'], false)[0]['news_id'];
        $this->commentNewRepository->create($comment);

        Flash::success(__('messages.created'));
        return redirect(route('admin.commentNews.index'));
    }

    public function comment(CreateCommentNewsRequest $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $users = $this->userRepository->findByField('group_id', '=', 4, ['*'], false);
            $acc = null;
            if (count($users) < 10) {
                $user['name'] = Helper::generateName();
                $user['avatar'] = '/public/uploads/default-avatar.png';
                $user['email'] = Helper::generateRandomString() . '@gmail.com';
                $user['password'] = Hash::make($user['email']);
                $user['group_id'] = 4;
                $user['phone'] = Helper::generateTel(11);
                $acc = $this->userRepository->create($user);
            } else {
                #TODO: Random id user auto-comment
                $index = rand(0, count($users) - 1);
            }

            $input['user_id'] = ($acc != null) ? $acc->id : $users[$index]['id'];

            $news = $this->newsRepository->findByField('slug', '=', $input['slug'], ['*'], false)->first();
            $input['news_id'] = $news->id;
            $input['content'] = strip_tags($input['content']);
            $comment = $this->commentNewRepository->create($input);
            $news->comment_counts = count($this->commentNewRepository->findByField('news_id', '=', $news->id, ['*'], false));
            $result = array('content' => Helper::makeLinks($comment->content, null, $news->slug), 'comment_id' => $comment->id, 'updated_at' => $comment->updated_at->format('Y-m-d H:i:s'), 'user' => $comment->user->name, 'avatar' => $comment->user->avatar, 'comment_counts' => $news->comment_counts, 'view_counts' => $news->view_counts);
            $news->save();
            return Response::json($result);
        }
    }
}
