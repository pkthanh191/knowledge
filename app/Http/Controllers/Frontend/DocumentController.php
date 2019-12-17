<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Helper;
use App\Http\Requests\CreateCommentRequest;
use App\Repositories\CategoryDocRepository;
use App\Repositories\CategoryTestRepository;
use App\Repositories\CommentRepository;
use App\Repositories\DocumentRepository;
use App\Repositories\CategoryDocMetaRepository;
use App\Repositories\DocumentMetaRepository;
use App\Repositories\DocumentMetaValueRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\BannerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class DocumentController extends FrontendBaseController
{
    private $documentRepository;
    private $categoryDocMetaRepository;
    private $documentMetaRepository;
    private $documentMetaValueRepository;
    private $commentRepository;
    protected $categoryDocRepository;
    protected $categoryTestRepository;
    protected $transactionRepository;
    private $bannerRepository;

    public function __construct(CategoryDocRepository $categoryDocRepo, CategoryTestRepository $categoryTestRepo, DocumentRepository $documentRepo, CategoryDocMetaRepository $categoryDocMetaRepo, DocumentMetaRepository $documentMetaRepo, DocumentMetaValueRepository $documentMetaValueRepo, CommentRepository $commentRepo, TransactionRepository $transactionRepo, BannerRepository $bannerRepo)
    {
        parent::__construct($categoryDocRepo, $categoryTestRepo, $documentRepo);

        $this->documentRepository = $documentRepo;
        $this->categoryDocMetaRepository = $categoryDocMetaRepo;
        $this->documentMetaRepository = $documentMetaRepo;
        $this->documentMetaValueRepository = $documentMetaValueRepo;
        $this->commentRepository = $commentRepo;
        $this->categoryDocRepository = $categoryDocRepo;
        $this->categoryTestRepository = $categoryTestRepo;
        $this->transactionRepository = $transactionRepo;
        $this->bannerRepository = $bannerRepo;
    }

    public function index(Request $request)
    {
        $docCategories = $this->getDocCategories();
        $testCategories = $this->getTestCategories();
        $banners = $this->bannerRepository->getbyChecked();

        $categorySlug = $request['danh-muc'];
        $parentArrayDoc= $categorySlug? $this->categoryDocRepository->getParentBySlug($categorySlug) : [];

        $mode = $request['mode'];

        /*SEARCH BY CATEGORY & NAME*/
        $search = $request['search'];
        if ($search != null) $search = $search['name'];

        $type = 'documents';
        $currentCategory = $this->categoryDocRepository->findWhere([['slug', '=', $categorySlug]], ['*'], false)->first();
        $documents = $this->documentRepository->getDocumentsByCategorySlug($categorySlug, $search);

        return view('frontend.documents.index', compact('meta_title', 'meta_keywords', 'meta_description', 'docCategories', 'testCategories', 'documents', 'mode', 'search', 'categorySlug', 'type', 'documentCount', 'testCount', 'teacherCount', 'centerCount', 'courseCount', 'currentCategory', 'parentArrayDoc','banners'));
    }

    public function show($slug)
    {
        $categorySlug = '';
        $categoryDocs = $this->categoryDocRepository->orderBy('orderSort')->orderBy('updated_at','desc')->buildTree(['*'], $this->SEPARATOR_SPACE);
        $document = $this->documentRepository->findByField('slug', '=', $slug, ['*'], false)->first();
        $document->view_counts += 1;
        $document->timestamps = false;
        $document->save();
        $documentMetaValues = $this->documentMetaValueRepository->findByField('doc_id', '=', $document->id, ['*'], false);

        $documentRelatives = $this->documentRepository->getRelatives($document);

        $documentRecent = $this->documentRepository->orderBy('created_at', 'desc')->paginate(6);
        $documentComments = $this->documentRepository->orderBy('comment_counts', 'desc')->paginate(6);
        $documentViews = $this->documentRepository->orderBy('view_counts', 'desc')->paginate(6);

        #TODO: Lấy phần liên quan khác phục vụ cho phần chi tiết.

        if (empty($document)) {
            #TODO: Xử lý
        }

        $commentCount = count($document->comments);
        foreach ($document->comments as $commentChild) {
            $commentCount += count($commentChild->child);
        }

        $type = 'documents';

        return view('frontend.documents.show', compact('meta_title', 'meta_keywords', 'meta_description', 'categoryDocs', 'document', 'documentMetaValues', 'documentRelatives', 'documentRecent', 'documentViews', 'documentComments', 'commentCount', 'type', 'categorySlug'));
    }

    public function comment(CreateCommentRequest $request)
    {
        if ($request->ajax()) {
            if (Auth::check()) {
                $user = Auth::user();
                $input = $request->all();
                $document = $this->documentRepository->findByField('slug', '=', $input['slug'], ['*'], false)->first();
                if($user->account_balance >= Helper::rip_tags(config('system.minus-knows-download.value'))){
                    $user->account_balance -= Helper::rip_tags(config('system.minus-knows-download.value'));
                    $user->save();
                    $input['user_id'] = $user->id;
                    $input['document_id'] = $document->id;
                    $comment = $this->commentRepository->create($input);
                    $this->transactionRepository->create([
                        'money_transfer' => Helper::rip_tags(config('system.minus-knows-download.value')),
                        'content' => Helper::$TRANS_COMMENT_DOC,
                        'status' => 1,
                        'user_id' => $user->id,
                        'document_id' => $document->id,
                    ]);
                    $document->comment_counts = count($this->commentRepository->findByField('document_id', '=', $document->id, ['*'], false));
                    $result = array(
                        'content' => Helper::makeLinks($comment->content, $comment->id, $document->slug),
                        'comment_id' => $comment->id,
                        'updated_at' => $comment->updated_at->format('Y-m-d H:i:s'),
                        'user' => $comment->user->name,
                        'comment_counts' => $document->comment_counts,
                        'view_counts' => $document->view_counts,
                        'account_balanced' => $user->account_balance,
                        'know_comment' => Helper::rip_tags(config('system.minus-knows-comment.value')),
                    );
                    $document->timestamps = false;
                    $document->save();
                    if(!empty($user->avatar) && (file_exists(public_path($user->avatar))))
                        $result['avatar'] = $comment->user->avatar;
                    else
                        $result['avatar'] = '/uploads/default-avatar.png';
                    return Response::json($result);
                }
                return Response::json(['account_balance'=>$user->account_balance,
                    'know_comment' => Helper::rip_tags(config('system.minus-knows-comment.value')),
                ]);
            }
        }
    }

    public function link_download(Request $request){
        if ($request->ajax()) {
            if (Auth::check()) {
                $document = $this->documentRepository->findByField('slug', '=', $request['slug'], ['*'], false)->first();
                $user = Auth::user();
                if ($user->account_balance >= Helper::rip_tags(config('system.minus-knows-download.value'))) {
                    $user->account_balance -= Helper::rip_tags(config('system.minus-knows-download.value'));
                    $user->save();
                    $this->transactionRepository->create([
                        'money_transfer' => Helper::rip_tags(config('system.minus-knows-download.value')),
                        'content' => Helper::$TRANS_DOWNLOAD_DOC,
                        'status' => 1,
                        'user_id' => $user->id,
                        'document_id' => $document->id,
                    ]);

                    if($request['comment_id']){
                        $comment = $this->commentRepository->find($request['comment_id']);
                        $content = $comment->content;
                        preg_match_all('#\b(http|https|ftp|ftps)?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $content, $match);
//                        return Response::json(['ok'=>$match[0]]);
                        return Response::json([
                            'comment' =>true,
                            'link_download' => $match[0][0] ,
                            'account_balance' => $user->account_balance,
                        ]);
                    }
                    $result = array(
                        'user' => $user->name,
                        'link_download' => $document->link_download ,
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
                $document = $this->documentRepository->findByField('slug', '=', $request['slug'], ['*'], false)->first();
                $user = Auth::user();
                if ($user->account_balance >= Helper::rip_tags(config('system.minus-knows-download.value'))) {
                    $link = $document->file;
                    $file = url('/') . $link;
                    $user->account_balance -= Helper::rip_tags(config('system.minus-knows-download.value'));
                    $user->save();
                    $this->transactionRepository->create([
                        'money_transfer' => Helper::rip_tags(config('system.minus-knows-download.value')),
                        'content' => Helper::$TRANS_DOWNLOAD_DOC,
                        'status' => 1,
                        'user_id' => $user->id,
                        'document_id' => $document->id,
                    ]);
                    $result = array(
                        'user' => $user->name,
                        'file' => $file ,
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
