<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Hash;
use Response;
use App\Repositories\DocumentRepository;
use App\Repositories\UserRepository;
use App\Repositories\CategoryDocRepository;

class CommentController extends AppBaseController
{
    /** @var  CommentRepository */
    private $commentRepository;
    private $documentRepository;
    private $userRepository;
    private $categoryDocRepository;

    public function __construct(CommentRepository $commentRepo, DocumentRepository $documentRepository, UserRepository $userRepository, CategoryDocRepository $categoryDocRepository)
    {
        $this->commentRepository = $commentRepo;
        $this->documentRepository = $documentRepository;
        $this->userRepository = $userRepository;
        $this->categoryDocRepository = $categoryDocRepository;
    }

    /**
     * Display a listing of the Comment.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $categories = $this->categoryDocRepository->buildTreeForSelectBox(['id', 'name'],$this->SEPARATOR_SPACE,null,__('messages.select_category_document'));
        $search = $request->search;
        $searchConditions = [];
        if (!empty($search)) {
            if (!empty($search['category']) && $search['category'] != 0) {
                $documents = $this->documentRepository->getDocumentByComment($search['category']);
            }
            else{
                if ($search['document_id'] == 0) {
                    $documents = $this->documentRepository->getDocumentByComment();
                }
            }
            if ($search['document_id'] != 0) {
                array_push($searchConditions, ['id', '=', $search['document_id']]);
                $documents = $this->documentRepository->findWhere($searchConditions);
            }

        } else {
            $documents = $this->documentRepository->getDocumentByComment();
        }
        $documentsSearch = $this->documentRepository->getAllDocumentByCategoryForSelectBox(['documents.*'], null, true, __('messages.document_choose_name'), $search['category']);
        $index = 1;
        return view('backend.comments.index', compact('documentsSearch', 'documents', 'index', 'categories'));
    }

    /**
     * Show the form for creating a new Comment.
     *
     * @return Response
     */
    public function create()
    {
        $documents = $this->documentRepository->getAllForSelectBox(['id', 'name'], null, true, __('messages.document_choose_name'));
        $comments = ['0' => "-- ".__('messages.select_comment_document')." --"];
        $users = $this->userRepository->getAllForSelectBox(['id', 'name'], null, true,__('messages.select_user'));
        $comment = new Comment();
        return view('backend.comments.create', compact('comment', 'documents', 'comments', 'users'));
    }

    /**
     * Store a newly created Comment in storage.
     *
     * @param CreateCommentRequest $request
     *
     * @return Response
     */
    public function store(CreateCommentRequest $request)
    {
        $input = $request->all();

        $this->commentRepository->create($input);

        Flash::success(__('messages.created'));

        return redirect(route('admin.comments.index'));
    }

    /**
     * Display the specified Comment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $document = $this->documentRepository->findByField('id', '=', $id, ['*'], false)->first();
        $commentCount = count($document->comments);
        foreach ($document->comments as $commentChild) {
            $commentCount += count($commentChild->child);
        }

        if (empty($document)) {
            Flash::error(__('messages.no-items'));

            return redirect(route('admin.comments.index'));
        }

        return view('backend.comments.show', compact('document','commentCount'));
    }

    /**
     * Show the form for editing the specified Comment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $comment = $this->commentRepository->findWithoutFail($id);
        if (empty($comment)) {
            Flash::error(__('messages.no-items'));

            return redirect(route('admin.comments.index'));
        }
        // get comments for select box
        $comments = Helper::formatSelectBoxForComment($comment->document->comments);
        if ($comment->parent_id == 0) {
            $comments = Helper::formatSelectBoxForComment($comment->document->comments, $comment->document->id);
        }
        // get documents for select box
        $documents = $this->documentRepository->getAllForSelectBox(['id', 'name'], null, true, __('messages.document_choose_name'));
        $users = $this->userRepository->getAllForSelectBox(['id', 'name'], null, true, __('messages.select_user'));

        return view('backend.comments.edit', compact('comment', 'documents', 'users', 'comments'));
    }

    /**
     * Update the specified Comment in storage.
     *
     * @param  int $id
     * @param UpdateCommentRequest $request
     *
     * @return Response
     */
    public function update(UpdateCommentRequest $request)
    {
        $comment = $this->commentRepository->update($request->all(), $request['id']);
        $result = array(
            'comment_id' => $comment->id,
            'user' => $comment->user->name,
            'content' => $comment->content,
            'updated_at' => $comment->updated_at->format('Y-m-d H:i:s'));
        return Response::json($result);
    }

    /**
     * Remove the specified Comment from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        $comment = $this->commentRepository->findWithoutFail($request['parent_id']);
        $document = $this->documentRepository->findByField('slug', '=', $request['slug'], ['*'], false)->first();
        $replies = $comment->children();
        if (count($replies) > 0) {
           foreach ($replies as $reply){
               $this->commentRepository->delete($reply->id);
           }
        }
        $this->commentRepository->delete($request['parent_id']);
        $document->comment_counts = count($this->commentRepository->findByField('document_id', '=', $document->id, ['*'], false));
        $result = array(
            'comment_id' => $comment->id,
            'user' => $comment->user->name,
            'comment_counts' => $document->comment_counts);
        $document->save();
        return Response::json($result);
//        if ($id == 'MULTI') {
//            if (!is_null($request->ids)) {
//                foreach ($request->ids as $id) {
//                    $comment = $this->commentRepository->findWithoutFail($id);
//
//                    if (empty($comment)) {
//                        Flash::error(__('messages.no-items'));
//
//                        return redirect(route('admin.comments.index'));
//                    }
//                    $replies = $comment->children();
//                    if (count($replies) > 0) {
//                        Flash::error(__('messages.comments_cannot_delete_have_replies'));
//                        return redirect(route('admin.comments.index'));
//                    }
//
//                    $this->commentRepository->delete($id);
//                }
//                Flash::success(__('messages.deleted'));
//                return redirect(route('admin.comments.index'));
//            } else {
//                Flash::warning(__('messages.comments_multi_delete_no_item'));
//                return redirect(route('admin.comments.index'));
//            }
//        } else {
//            $comment = $this->commentRepository->findWithoutFail($id);
//            if (empty($comment)) {
//                Flash::error(__('messages.no-items'));
//
//                return redirect(route('admin.comments.index'));
//            }
//            $replies = $comment->children();
//            if (count($replies) > 0) {
//                Flash::error(__('messages.comments_cannot_delete_have_replies'));
//                return redirect(route('admin.comments.index'));
//            }
//            $this->commentRepository->delete($id);
//
//            Flash::success(__('messages.deleted'));
//
//            return redirect(route('admin.comments.index'));
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

        $parent_id = $this->commentRepository->findByField('id', '=', $input['id'], ['*'], false)[0]['parent_id'];
        $comment['parent_id'] = ($parent_id == 0) ? $input['id'] : $parent_id;
        $comment['user_id'] = ($acc != null) ? $acc->id : $users[$index]['id'];
        $comment['document_id'] = $this->commentRepository->findByField('id', '=', $input['id'], ['*'], false)[0]['document_id'];
        $this->commentRepository->create($comment);

        Flash::success(__('messages.created'));
        return redirect(route('admin.comments.index'));
    }

    public function comment(CreateCommentRequest $request)
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

            $document = $this->documentRepository->findByField('slug', '=', $input['slug'], ['*'], false)->first();
            $input['document_id'] = $document->id;
            $input['content'] = strip_tags($input['content']);
            $comment = $this->commentRepository->create($input);
            $document->comment_counts = count($this->commentRepository->findByField('document_id', '=', $document->id, ['*'], false));
            $result = array('content' => Helper::makeLinks($comment->content, null, $document->slug), 'comment_id' => $comment->id, 'updated_at' => $comment->updated_at->format('Y-m-d H:i:s'), 'user' => $comment->user->name, 'avatar' => $comment->user->avatar, 'comment_counts' => $document->comment_counts, 'view_counts' => $document->view_counts);
            $document->save();
            return Response::json($result);

        }
    }

}
