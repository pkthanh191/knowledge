<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\CreateCommentTestRequest;
use App\Http\Requests\UpdateCommentTestRequest;
use App\Repositories\CommentTestRepository;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Repositories\TestRepository;
use App\Repositories\UserRepository;
use App\Repositories\CategoryTestRepository;

class CommentTestController extends AppBaseController
{
    /** @var  CommentTestRepository */
    private $commentTestRepository;
    private $testRepository;
    private $userRepository;
    private $categoryTestRepository;

    public function __construct(CommentTestRepository $commentTestRepo, TestRepository $testRepository, UserRepository $userRepository, CategoryTestRepository $categoryTestRepo)
    {
        $this->commentTestRepository = $commentTestRepo;
        $this->testRepository = $testRepository;
        $this->userRepository = $userRepository;
        $this->categoryTestRepository = $categoryTestRepo;
    }

    /**
     * Display a listing of the CommentTest.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $categories = $this->categoryTestRepository->buildTreeForSelectBox(['id', 'name'],$this->SEPARATOR_SPACE, null,__('messages.select_category_test'));
        $search = $request->search;
        $searchConditions = [];
        if (!empty($search)) {
            if (!empty($search['category']) && $search['category'] != 0) {
                $tests = $this->testRepository->getTestByComment($search['category']);
            }
            else{
                if ($search['test_id'] == 0) {
                    $tests = $this->testRepository->getTestByComment();
                }
            }
            if ($search['test_id'] != 0) {
                array_push($searchConditions, ['id', '=', $search['test_id']]);
                $tests = $this->testRepository->findWhere($searchConditions);
            }

        } else {
            $tests = $this->testRepository->getTestByComment();
        }
        $index = 1;
        $testsSearch = $this->testRepository->getAllTestsByCategoryForSelectBox(['tests.*'], null, true, __('messages.test_choose_name'), $search['category']);
        return view('backend.comment_tests.index', compact('testsSearch', 'tests', 'categories', 'index'));
//        echo "ll";
    }

    /**
     * Show the form for creating a new CommentTest.
     *
     * @return Response
     */
    public function create()
    {
        $tests = $this->testRepository->getAllForSelectBox(['*'],null, true, __('messages.test_choose_name'));
        $commentTests = ['0' => "-- ".__('messages.select_comment_test')." --"];
        $users = $this->userRepository->getAllForSelectBox(['id', 'name'], null, true, __('messages.select_user'));
        return view('backend.comment_tests.create', compact('tests', 'commentTests', 'users'));
    }

    /**
     * Store a newly created CommentTest in storage.
     *
     * @param CreateCommentTestRequest $request
     *
     * @return Response
     */
    public function store(CreateCommentTestRequest $request)
    {
        $input = $request->all();

        $commentTest = $this->commentTestRepository->create($input);

        Flash::success(__('messages.created'));

        return redirect(route('admin.commentTests.index'));
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
        $test = $this->testRepository->findByField('id', '=', $id, ['*'], false)->first();
        $commentCount = count($test->comments);
        foreach ($test->comments as $commentChild) {
            $commentCount += count($commentChild->child);
        }
        if (empty($test)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.commentTests.index'));
        }

        return view('backend.comment_tests.show', compact('test', 'commentCount'));
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
        $commentTest = $this->commentTestRepository->findWithoutFail($id);

        if (empty($commentTest)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.commentTests.index'));
        }
        $tests = $this->testRepository->getAllForSelectBox(['*'],null,true,__('messages.select_comment_test'));
        // get comments for select box
        $commentTests = Helper::formatSelectBoxForComment($commentTest->test->comments);
        if ($commentTest->parent_id == 0) {
            $commentTests = Helper::formatSelectBoxForComment($commentTest->test->comments, $commentTest->test->id);
        }
        $users = $this->userRepository->getAllForSelectBox(['id', 'name'], null, true,__('messages.select_user'));
        return view('backend.comment_tests.edit', compact('commentTest', 'commentTests', 'users', 'tests'));
    }

    /**
     * Update the specified CommentTest in storage.
     *
     * @param  int $id
     * @param UpdateCommentTestRequest $request
     *
     * @return Response
     */
    public function update(UpdateCommentTestRequest $request)
    {
        $commentTest = $this->commentTestRepository->update($request->all(), $request['id']);
        $result = array(
            'comment_id' => $commentTest->id,
            'user' => $commentTest->user->name,
            'content' => $commentTest->content,
            'updated_at' => $commentTest->updated_at->format('Y-m-d H:i:s'));
        return Response::json($result);
    }

    /**
     * Remove the specified CommentTest from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        $commentTest = $this->commentTestRepository->findWithoutFail($request['parent_id']);
        $test = $this->testRepository->findByField('slug', '=', $request['slug'], ['*'], false)->first();
        $replies = $commentTest->children();
        if (count($replies) > 0) {
            foreach ($replies as $reply){
                $this->commentTestRepository->delete($reply->id);
            }
        }
        $this->commentTestRepository->delete($request['parent_id']);
        $test->comment_counts = count($this->commentTestRepository->findByField('test_id', '=', $test->id, ['*'], false));
        $result = array(
            'comment_id' => $commentTest->id,
            'user' => $commentTest->user->name,
            'comment_counts' => $test->comment_counts);
        $test->save();
        return Response::json($result);
//        if ($id == 'MULTI') {
//            if (!is_null($request->ids)) {
//                foreach ($request->ids as $id) {
//                    $comment = $this->commentTestRepository->findWithoutFail($id);
//
//                    if (empty($comment)) {
//                        Flash::error(__('messages.no-items'));
//
//                        return redirect(route('admin.commentTests.index'));
//                    }
//                    $replies = $comment->children();
//                    if (count($replies) > 0) {
//                        Flash::error(__('messages.comments_cannot_delete_have_replies'));
//                        return redirect(route('admin.commentTests.index'));
//                    }
//
//                    $this->commentTestRepository->delete($id);
//                }
//                Flash::success(__('messages.deleted'));
//                return redirect(route('admin.commentTests.index'));
//            } else {
//                Flash::error(__('messages.comments_please_choose_categories'));
//                return redirect(route('admin.commentTests.index'));
//            }
//        } else {
//            $commentTest = $this->commentTestRepository->findWithoutFail($id);
//
//            if (empty($commentTest)) {
//                Flash::error(__('messages.not-found'));
//
//                return redirect(route('admin.commentTests.index'));
//            }
//
//            $replies = $commentTest->children();
//            if (count($replies) > 0) {
//                Flash::error(__('messages.comments_cannot_delete_have_replies'));
//                return redirect(route('admin.commentTests.index'));
//            }
//
//            $this->commentTestRepository->delete($id);
//
//            Flash::success(__('messages.deleted'));
//
//            return redirect(route('admin.commentTests.index'));
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
            $user['avatar'] = '/uploads/default-image.png';
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

        $parent_id = $this->commentTestRepository->findByField('id', '=', $input['id'], ['*'], false)[0]['parent_id'];
        $comment['parent_id'] = ($parent_id == 0) ? $input['id'] : $parent_id;
        $comment['user_id'] = ($acc != null) ? $acc->id : $users[$index]['id'];
        $comment['test_id'] = $this->commentTestRepository->findByField('id', '=', $input['id'], ['*'], false)[0]['test_id'];
        $this->commentTestRepository->create($comment);

        Flash::success(__('messages.created'));
        return redirect(route('admin.commentTests.index'));
    }

    public function comment(CreateCommentTestRequest $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $users = $this->userRepository->findByField('group_id', '=', 4, ['*'], false);
            $acc = null;
            if (count($users) < 10) {
                $user['name'] = Helper::generateName();
                $user['avatar'] = '/uploads/default-image.png';
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

            $test = $this->testRepository->findByField('slug', '=', $input['slug'], ['*'], false)->first();
            $input['test_id'] = $test->id;
            $input['content'] = strip_tags($input['content']);
            $comment = $this->commentTestRepository->create($input);
            $test->comment_counts = count($this->commentTestRepository->findByField('test_id', '=', $test->id, ['*'], false));
            $result = array('content' => Helper::makeLinks($comment->content, null, $test->slug), 'comment_id' => $comment->id, 'updated_at' => $comment->updated_at->format('Y-m-d H:i:s'), 'user' => $comment->user->name, 'avatar' => $comment->user->avatar, 'comment_counts' => $test->comment_counts, 'view_counts' => $test->view_counts);
            $test->save();
            return Response::json($result);

        }
    }
}
