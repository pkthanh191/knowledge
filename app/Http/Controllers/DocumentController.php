<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\CreateDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Repositories\CategoryDocMetaRepository;
use App\Repositories\CategoryDocRepository;
use App\Repositories\CommentRepository;
use App\Repositories\DocumentCategoryRepository;
use App\Repositories\DocumentMetaValueRepository;
use App\Repositories\DocumentRepository;
use App\Repositories\DocumentMetaRepository;
use App\Repositories\TransactionRepository;
use function foo\func;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Response;

class DocumentController extends AppBaseController
{
    /** @var  DocumentRepository */
    private $documentRepository;
    private $categoryDocRepository;
    private $documentCategoryRepository;
    private $categoryDocMetaRepository;
    private $documentMetaRepository;
    private $documentMetaValueRepository;
    private $commentRepository;
    private $transactionRepository;

    public function __construct(DocumentRepository $documentRepo, CategoryDocRepository $categoryDocRepo, DocumentCategoryRepository $documentCategoryRepo, CategoryDocMetaRepository $categoryDocMetaRepo, DocumentMetaRepository $documentMetaRepo, DocumentMetaValueRepository $documentMetaValueRepo, CommentRepository $commentRepo, TransactionRepository $transactionRepository)
    {
        $this->documentRepository = $documentRepo;
        $this->categoryDocRepository = $categoryDocRepo;
        $this->documentCategoryRepository = $documentCategoryRepo;
        $this->categoryDocMetaRepository = $categoryDocMetaRepo;
        $this->documentMetaRepository = $documentMetaRepo;
        $this->documentMetaValueRepository = $documentMetaValueRepo;
        $this->commentRepository = $commentRepo;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Display a listing of the Document.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $categories = $this->categoryDocRepository->buildTreeForSelectBox(['id', 'name'], '- ', null, __('messages.select_category_document'));
        $search = $request->search;
        $searchCondition = [];
        if (!empty($search)) {
            if (!empty($search['name'])) {
                array_push($searchCondition, ['name', 'LIKE', '%' . $search['name'] . '%']);
            }
            if (!empty($search['category']) && $search['category'] != 0) {
                $temp = $this->documentRepository->search($searchCondition, $search['category']);
                $documents_export = $temp->get(['documents.*']);
                $documents = $temp->orderBy('documents.updated_at', 'desc')->paginate(18, ['documents.*']);
            } else {
                $temp = $this->documentRepository->search($searchCondition);
                $documents_export = $temp->get(['documents.*']);
                $documents = $temp->orderBy('documents.updated_at', 'desc')->paginate(18, ['documents.*']);
            }
        } else {
            $documents = $this->documentRepository->with('categories')->orderBy('updated_at', 'desc')->paginate(18);
            $documents_export = $this->documentRepository->all();
        }

        return view('backend.documents.index', compact('documents', 'categories', 'documents_export'));
    }

    /**
     * Show the form for creating a new Document.
     *
     * @return Response
     */
    public function create()
    {
        $categoryDocMetas = $this->categoryDocMetaRepository->getAllCategoryHasDocMeta();

        $categoryMetas = $this->categoryDocMetaRepository->all();
        $categories = $this->categoryDocRepository->buildTree(['id', 'name']);
        $selectedCategories = null;
        $on_create = true;
        return view('backend.documents.create', compact('categoryDocMetas', 'categories', 'selectedCategories', 'back', 'on_create', 'categoryMetas'));
    }

    /**
     * Store a newly created Document in storage.
     *
     * @param CreateDocumentRequest $request
     *
     * @return Response
     */
    public function store(CreateDocumentRequest $request)
    {
        $input = $request->all();
        if ($request->categories == null) {
            Flash::error(__('messages.document_flash_select_category'));
            return back()->withInput();
        }

        if (!empty($request->image)) {
            $imageName = time() . '.' . Helper::transText($request->image->getClientOriginalName(), '-');
            $request->image->move(public_path('uploads/documents'), $imageName);
            $request->image = $imageName;
            $input['image'] = '/uploads/documents/' . $imageName;
        } else {
            $input['image'] = '/uploads/documents/default-avatar.png';
        }
        if (!empty($request->file)) {
            $file = time() . '.' . Helper::transText($request->file->getClientOriginalName(), '-');;
            $request->file->move(public_path('files'), $file);
            $input['file'] = '/files/' . $file;
        }
        if (!empty($request->short_file)) {
            $short_file = time() . '.' . Helper::transText($request->short_file->getClientOriginalName(), '-');
            $request->short_file->move(public_path('files'), $short_file);
            $input['short_file'] = '/files/' . $short_file;
        }
        $input["user_id"] = Auth::user()->id;
        $document = $this->documentRepository->create($input);

        if (!empty($input['document_meta'])) {
            foreach ($input['document_meta'] as $doc_meta_id => $doc_meta_value) {
                $in['doc_id'] = $document->id;
                $in['doc_meta_id'] = $doc_meta_id;
                $in['value'] = $doc_meta_value;
                $this->documentMetaValueRepository->create($in);
            }
        }

        Flash::success(__('messages.created'));

        return redirect(route('admin.documents.index'));
    }

    /**
     * Display the specified Document.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $document = $this->documentRepository->findWithoutFail($id);
        $documentMetaValues = $this->documentMetaValueRepository->findByField('doc_id', '=', $id, ['*'], false);

        if (empty($document)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.documents.index'));
        }

        return view('backend.documents.show', compact('document', 'documentMetaValues', 'back'));
    }

    /**
     * Show the form for editing the specified Document.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $categoryDocMetas = $this->categoryDocMetaRepository->getAllCategoryHasDocMeta();

        $categoryMetas = $this->categoryDocMetaRepository->all();
        $categories = $this->categoryDocRepository->buildTree(['id', 'name']);
        $selectedCategories = $this->documentCategoryRepository->findByField('document_id', '=', $id, ['category_id'], false)->toArray();
        $arr = [];
        foreach ($selectedCategories as $selectedCategory) {
            array_push($arr, $selectedCategory['category_id']);
        }
        $selectedCategories = $arr;

        $document = $this->documentRepository->findWithoutFail($id);

        if (empty($document)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.documents.index'));
        }

        $documentMetaValues = $this->documentMetaValueRepository->findByField('doc_id', '=', $id, ['*'], false);

        $selectedCategoryDocMeta = [];
        if (!empty($documentMetaValues) && count($documentMetaValues) > 0) {
            $meta_values_id = $documentMetaValues->pluck('doc_meta_id')->toArray();
            if (!empty($meta_values_id)) {
                $documentMetas = $documentMetaValues->first()->documentMeta()->first()->categoryDocMeta()->first()->metas;
                foreach ($documentMetas as $meta) {
                    if (!in_array($meta->id, $meta_values_id)) {
                        $need = $this->documentMetaValueRepository->create(['doc_id' => $id, 'doc_meta_id' => $meta->id]);
                        $documentMetaValues->put(count($documentMetaValues), $need);
                    }
                }
            }
            $docMetaId = $documentMetaValues->first()->toArray()['doc_meta_id'];
            $selectedCategoryDocMeta = $this->documentMetaRepository->findByField('id', '=', $docMetaId, ['*'], false)->first()->toArray()['category_doc_meta_id'];
        }

        return view('backend.documents.edit', compact('document', 'categoryDocMetas', 'categories', 'selectedCategories', 'documentMetaValues', 'selectedCategoryDocMeta', 'categoryMetas'));
    }

    /**
     * Update the specified Document in storage.
     *
     * @param  int $id
     * @param UpdateDocumentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDocumentRequest $request)
    {
        if ($request->categories == null) {
            Flash::error(__('messages.document_flash_select_category'));
            return back()->withInput();
        }

        /*if ($request->document_meta == null) {
            Flash::error(__('messages.document_flash_select_category_document_meta'));
            return back()->withInput();
        }*/

        $document = $this->documentRepository->findWithoutFail($id);
        if (empty($document)) {
            Flash::error(__('messages.not-found'));
            return redirect(route('admin.documents.index'));
        }

        $input = $request->all();
        if (!empty($request->image)) {
            $imageName = time() . '.' . Helper::transText($request->image->getClientOriginalName(), '-');
            $request->image->move(public_path('uploads/documents'), $imageName);
            $request->image = $imageName;
            $input['image'] = '/uploads/documents/' . $imageName;
        }
        if (!empty($request->file)) {
            $file = time() . '.' . Helper::transText($request->file->getClientOriginalName(), '-');
            $request->file->move(public_path('files'), $file);
            $input['file'] = '/files/' . $file;
        }
        if (!empty($request->short_file)) {
            $short_file = time() . '.' . Helper::transText($request->short_file->getClientOriginalName(), '-');
            $request->short_file->move(public_path('files'), $short_file);
            $input['short_file'] = '/files/' . $short_file;
        }
        $document["user_id"] = Auth::user()->id;
        $this->documentRepository->update($input, $id);


        #Xóa giá trị trong Document Meta Value.
        $doc_meta_ids = $this->documentMetaValueRepository->findByField('doc_id', '=', $id, ['*'], false)->toArray();
        foreach ($doc_meta_ids as $doc_meta_id) {
            $this->documentMetaValueRepository->delete($doc_meta_id['id']);
        }

        if (!empty($input['document_meta'])) {
            #Lưu lại giá trị vào Document Meta Value.
            foreach ($input['document_meta'] as $doc_meta_id => $doc_meta_value) {
                $in['doc_id'] = $document->id;
                $in['doc_meta_id'] = $doc_meta_id;
                $in['value'] = $doc_meta_value;
                $this->documentMetaValueRepository->create($in);
            }
        }

        Flash::success(__('messages.updated'));
        return redirect(route('admin.documents.index'));
    }

    /**
     * Remove the specified Document from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        if ($id == 'MULTI') {
            if (empty($request->ids)) {
                Flash::warning(__('messages.not-found'));
                return back();
            } else {
                $checked = [];
                foreach ($request->ids as $id) {
                    $document = $this->documentRepository->findWithoutFail($id);
                    if (empty($document)) {
                        Flash::error(__('messages.not-found'));
                        return back();
                    }
                    if (!$document->comments->isEmpty()) {
                        Flash::warning(__('messages.alert_delete_comment'));
                        return back();
                    }
                    array_push($checked, $id);
                }
                foreach ($checked as $id) {
//                  TODO:  Xóa các ràng buộc với danh mục
                    $documentCategories = $this->documentCategoryRepository->findWhere([['document_id', '=', $id]], ['id'])->toArray()['data'];
                    foreach ($documentCategories as $documentCategory) {
                        $this->documentCategoryRepository->delete($documentCategory['id']);
                    }
//                  TODO:  Xóa các trường dữ liệu của loại tài liệu
                    $docMetaValues = $this->documentMetaValueRepository->findWhere([['doc_id', '=', $id]], ['id'])->toArray()['data'];
                    foreach ($docMetaValues as $docMetaValue) {
                        $this->documentMetaValueRepository->delete($docMetaValue['id']);
                    }
                    $this->documentRepository->delete($id);
                }
            }
            Flash::success(__('messages.deleted'));
            return back();

        } else {
            $document = $this->documentRepository->findWithoutFail($id);
            if (empty($document)) {
                Flash::error(__('messages.not-found'));

                return back();
            } elseif (!$document->comments->isEmpty()) {
                Flash::warning(__('messages.alert_delete_comment'));
                return back();
            }
            #TODO: Xóa quan hệ với giao dịch, đưa giao dịch về với tài liệu không xác định
            $transactions = $this->transactionRepository->findWhere(['document_id' => $id]);
            foreach ($transactions as $tran) {
                $tran->document_id = 0;
                $tran->save();
            }
//          TODO:  Xóa các ràng buộc với danh mục
            $documentCategories = $this->documentCategoryRepository->findWhere([['document_id', '=', $id]], ['id'])->toArray()['data'];
            foreach ($documentCategories as $documentCategory) {
                $this->documentCategoryRepository->delete($documentCategory['id']);
            }
//          TODO:  Xóa các trường dữ liệu của loại tài liệu
            $docMetaValues = $this->documentMetaValueRepository->findWhere([['doc_id', '=', $id]], ['id'])->toArray()['data'];
            foreach ($docMetaValues as $docMetaValue) {
                $this->documentMetaValueRepository->delete($docMetaValue['id']);
            }

            $this->documentRepository->delete($id);

            Flash::success(__('messages.deleted'));

            return back();
        }
    }

    public function exportExcel(Request $request)
    {
        Excel::create(__('messages.document'), function ($excel) use ($request) {
            foreach ($this->categoryDocMetaRepository->all() as $categoryMeta) {
//                    Nếu có trường của loại tài liệu
                $documents = [];
                $metas = $categoryMeta->metas;
                if ($metas->first() != null)
//                        Nếu có giới hạn tìm từ request, export những tài liệu có trong mảng đã truyền vào
                    if (isset($request->searched))
                        $documents = $this->documentRepository->getByDocMeta($metas->first())->whereIn('documents.id', $request->searched)->orderBy('updated_at', 'desc')->get(['documents.*']);
                    else $documents = $this->documentRepository->getByDocMeta($metas->first())->orderBy('updated_at', 'desc')->get(['documents.*']);
                if (!empty($documents)) {
                    $excel->sheet($categoryMeta->name, function ($sheet) use ($categoryMeta, $request, $documents, $metas) {
                        //each sheet has header
                        $sheet->setWidth([
                            'A' => 50,
                            'B' => 50,
                            'C' => 100,
                            'D' => 400,
                            'E' => 50,
                            'F' => 50,
                            'G' => 50,
                            'H' => 50,
                            'I' => 10,
                            'J' => 10,
                            'K' => 50,
                            'L' => 30,
                            'M' => 20,
                            'N' => 20,
                            'O' => 20,
                            'P' => 30,
                            'Q' => 30,
                            'R' => 30,
                            'S' => 10,
                            'T' => 30,
                            'U' => 30,
                        ]);

                        $metaArr = [];
                        foreach ($metas as $meta)
                            array_push($metaArr, $meta->name);
                        $defaultArr = array(
                            __('messages.document_name'),
                            __('messages.document_category'),
                            __('messages.document_short_description'),
                            __('messages.document_description'),
                            __('messages.document_slug'),
                            __('messages.meta_title'),
                            __('messages.meta_keywords'),
                            __('messages.meta_description'),
                            __('messages.document_comment_counts'),
                            __('messages.document_view_counts'),
                            __('messages.image_url'),
                            __('messages.document_file'),
                            __('messages.document_short_file'),
                            __('messages.document_link_download'),
                            __('messages.document_user'),
                            __('messages.created_at'),
                            __('messages.updated_at'),
                        );
                        $total = array_merge($defaultArr, $metaArr);
                        $sheet->row(1, $total);
                        $sheet->row(1, function ($row) {
                            $row->setBackground('#ffff00');
                        });
                        $c_end = chr(ord('A') + count($total));
                        for ($i = 'A'; $i <= $c_end; $i++) {
                            $sheet->cell($i . '1', function ($cell) {
                                $cell->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            for ($j = 2; $j < count($documents) + 2; $j++) {
                                $sheet->cell($i . $j, function ($cell) {
                                    $cell->setValignment('center');
                                });
                            }
                        }
                        foreach ($documents as $index => $document) {
                            $defaultValueArr = [
                                $document->name,
                                Helper::formatCategories($document->categories),
                                Helper::rip_tags($document->short_description),
                                Helper::rip_tags($document->description),
                                $document->slug,
                                $document->meta_title,
                                $document->meta_keywords,
                                $document->meta_description,
                                $document->comment_counts,
                                $document->view_counts,
                                $document->image,
                                $document->file,
                                $document->short_file,
                                $document->link_download,
                                $document->user->name,
                                $document->created_at->format('d/m/Y'),
                                $document->updated_at->format('d/m/Y'),
                            ];
                            $documentMetaValues = $this->documentMetaValueRepository->findByField('doc_id', '=', $document->id, ['*'], false);
                            $metaValueArr = [];
                            foreach ($documentMetaValues as $value) {
                                array_push($metaValueArr, $value->value);
                            }
                            $sheet->row($index + 2, array_merge($defaultValueArr, $metaValueArr));
                            $sheet->getStyle('A2:' . chr(ord('A') + count($total)) . $sheet->getHighestRow())
                                ->getAlignment()->setWrapText(true);
                        }
                    });
                }
            }
            $documents = $this->documentRepository->getDocUndefinedMeta();
            if (!empty($documents)) {
                $excel->sheet(__('messages.document_undefined_meta'), function ($sheet) use ($documents) {
                    $sheet->setWidth([
                        'A' => 50,
                        'B' => 50,
                        'C' => 100,
                        'D' => 400,
                        'E' => 50,
                        'F' => 50,
                        'G' => 50,
                        'H' => 50,
                        'I' => 10,
                        'J' => 10,
                        'K' => 50,
                        'L' => 30,
                        'M' => 20,
                        'N' => 20,
                        'O' => 20,
                        'P' => 30,
                        'Q' => 30,
                        'R' => 30,
                    ]);

                    $defaultArr = array(
                        __('messages.document_name'),
                        __('messages.document_category'),
                        __('messages.document_short_description'),
                        __('messages.document_description'),
                        __('messages.document_slug'),
                        __('messages.meta_title'),
                        __('messages.meta_keywords'),
                        __('messages.meta_description'),
                        __('messages.document_comment_counts'),
                        __('messages.document_view_counts'),
                        __('messages.image_url'),
                        __('messages.document_file'),
                        __('messages.document_short_file'),
                        __('messages.document_link_download'),
                        __('messages.document_user'),
                        __('messages.created_at'),
                        __('messages.updated_at'),
                    );
                    $sheet->row(1, $defaultArr);
                    $sheet->row(1, function ($row) {
                        $row->setBackground('#ffff00');
                    });
                    $c_end = chr(ord('A') + count($defaultArr));
                    for ($i = 'A'; $i <= $c_end; $i++) {
                        $sheet->cell($i . '1', function ($cell) {
                            $cell->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                        for ($j = 2; $j < count($documents) + 2; $j++) {
                            $sheet->cell($i . $j, function ($cell) {
                                $cell->setValignment('center');
                            });
                        }
                    }
                    foreach ($documents as $index => $document) {
                        $defaultValueArr = [
                            $document->name,
                            Helper::formatCategories($document->categories),
                            Helper::rip_tags($document->short_description),
                            Helper::rip_tags($document->description),
                            $document->slug,
                            $document->meta_title,
                            $document->meta_keywords,
                            $document->meta_description,
                            $document->comment_counts,
                            $document->view_counts,
                            $document->image,
                            $document->file,
                            $document->short_file,
                            $document->link_download,
                            $document->user->name,
                            $document->created_at->format('d/m/Y'),
                            $document->updated_at->format('d/m/Y'),
                        ];
                        $sheet->row($index + 2, $defaultValueArr);
                        $sheet->getStyle('A2:' . chr(ord('A') + count($defaultValueArr)) . $sheet->getHighestRow())
                            ->getAlignment()->setWrapText(true);
                    }
                });
            }
        })->export('xlsx');
    }

    public
    function showImport()
    {
        return view('backend.documents.import');
    }

    public
    function importExcel(Request $request)
    {
        $this->validate($request, ['file' => 'required|file|mimes:xls,xlsx'], [], ['file' => 'File']);
        Excel::load($request->file, function ($reader) {
            $fail = false;
            $added = [];
            foreach ($reader->get() as $sheet) {
                if ($sheet->getTitle() != __('messages.categories') && !$fail) {
                    foreach ($sheet as $row) {
                        try {
                            $input['name'] = $row[str_slug(__('messages.document_name'), '_')];
                            $input['short_description'] = $row[str_slug(__('messages.document_short_description'), '_')];
                            $input['description'] = $row[str_slug(__('messages.document_description'), '_')];
                            $input['meta_title'] = $row[str_slug(__('messages.meta_title'), '_')];
                            $input['meta_keywords'] = $row[str_slug(__('messages.meta_keywords'), '_')];
                            $input['meta_description'] = $row[str_slug(__('messages.meta_description'), '_')];
                            if (empty($row[str_slug(__('messages.image_url'), '_')]) || !file_exists(public_path($row[str_slug(__('messages.image_url'), '_')])))
                                $input['image'] = '/public/uploads/default-avatar.png';
                            else
                                $input['image'] = $row[str_slug(__('messages.image_url'), '_')];
                            $input['file'] = $row[str_slug(__('messages.document_file'), '_')];
                            $input['short_file'] = $row[str_slug(__('messages.document_short_file'), '_')];
                            $input['link_download'] = $row[str_slug(__('messages.document_link_download'), '_')];
                            $input['user_id'] = Auth::user()->id;
                            //Danh mục tài liệu phân cách bởi dấu phẩy
                            $categoryStr = $row[str_slug(__('messages.document_category'), '_')];
                            if ($categoryStr == null) throw new \ErrorException();
                            $document = $this->documentRepository->create($input);
                            $categories = explode(', ', $categoryStr);
                            $not_cate = true;
                            foreach ($categories as $str) {
                                $category = $this->categoryDocRepository->findByFieldWithLike('name', $str, ['*'])->first();
                                if (isset($category)) {
                                    $not_cate = false;
                                    $inc = [];
                                    $inc['document_id'] = $document->id;
                                    $inc['category_id'] = $category->id;
                                    $this->documentCategoryRepository->create($inc);
                                }
                            }
//                            Nếu không thấy danh mục nào thì hủy dữ liệu
                            if ($not_cate) {
                                $document->delete();
                                throw new \ErrorException();
                            }
                            $categoryMeta = $this->categoryDocMetaRepository->findWhere(['name' => $sheet->getTitle()])->first();
                            //Thực hiện thêm dữ liệu của loại tài liệu
                            if ($categoryMeta) {
                                $metas = $categoryMeta->metas;
                                if (isset($row[str_slug($metas->first()->name, '_')]))
                                    foreach ($metas as $meta) {
                                        $inv['doc_id'] = $document->id;
                                        $inv['doc_meta_id'] = $meta->id;
                                        $inv['value'] = $row[str_slug($meta->name, '_')];
                                        $this->documentMetaValueRepository->create($inv);
                                    }
                            }
                            array_push($added, $document);
                        } catch (QueryException $exception) {
                            Flash::error('Sheet "' . $sheet->getTitle() . '" ' . __('messages.incorrect_data_import'));
                            $fail = true;
                            break;
                        } catch (\ErrorException $exception) {
                            Flash::error('Sheet "' . $sheet->getTitle() . '" ' . __('messages.incorrect_data_import'));
                            $fail = true;
                            break;
                        } catch (\Exception $exception) {
                            Flash::error('Sheet "' . $sheet->getTitle() . '" ' . __('messages.incorrect_form_import'));
                            $fail = true;
                            break;
                        }
                    }
                }
            }
//            Nếu xảy ra lỗi thì xóa các dữ liệu đã thêm
            if (!$fail) {
                Flash::success(__('messages.imported'));
            } else {
                foreach ($added as $document) {
                    $documentCategories = $this->documentCategoryRepository->findWhere([['document_id', '=', $document->id]], ['id'])->toArray()['data'];
                    foreach ($documentCategories as $documentCategory) {
                        $this->documentCategoryRepository->delete($documentCategory['id']);
                    }

                    $docMetaValues = $this->documentMetaValueRepository->findWhere([['doc_id', '=', $document->id]], ['id'])->toArray()['data'];
                    foreach ($docMetaValues as $docMetaValue) {
                        $this->documentMetaValueRepository->delete($docMetaValue['id']);
                    }

                    $this->documentRepository->delete($document->id);
                }
            }
        });
        return redirect(route('admin.documents.import'));
    }

    public
    function formImport()
    {
        Excel::create(__('messages.document_form_import'), function ($excel) {
            foreach ($this->categoryDocMetaRepository->all() as $categoryMeta) {
                if ($categoryMeta->metas->first() != null) {
                    $excel->sheet($categoryMeta->name, function ($sheet) use ($categoryMeta) {
                        //each sheet has header
                        if ($categoryMeta->metas->isEmpty()) return;
                        $sheet->setWidth([
                            'A' => 30,
                            'B' => 50,
                            'C' => 50,
                            'D' => 50,
                            'E' => 30,
                            'F' => 30,
                            'G' => 30,
                            'H' => 30,
                            'I' => 30,
                            'J' => 30,
                            'K' => 30,
                            'L' => 30,
                            'M' => 30,
                            'N' => 30,
                            'O' => 30,
                        ]);

                        $metas = $categoryMeta->metas;
                        $metaArr = [];
                        foreach ($metas as $meta)
                            array_push($metaArr, $meta->name);
                        $txtRequired = ' (*)';
                        $defaultArr = array(
                            __('messages.document_name') . $txtRequired,
                            __('messages.document_category') . $txtRequired,
                            __('messages.document_short_description'),
                            __('messages.document_description'),
                            __('messages.meta_title') . $txtRequired,
                            __('messages.meta_keywords'),
                            __('messages.meta_description'),
                            __('messages.image_url'),
                            __('messages.document_file'),
                            __('messages.document_short_file'),
                            __('messages.document_link_download'),
                        );
                        $total = array_merge($defaultArr, $metaArr);
                        $sheet->row(1, $total);
                        for ($i = 'A'; $i < chr(ord('A') + count($total)); $i++) {
                            $sheet->cell($i . '1', function ($cell) {
                                $cell->setBackground('#ffff00');
                                $cell->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell($i . '2', function ($cell) {
                                $cell->setValignment('center');
                            });
                        }
                        //append first document when have an meta
                        $document = $this->documentRepository->getByDocMeta($metas->first())->orderBy('updated_at', 'desc')->get(['documents.*'])->first();
                        if (isset($document)) {
                            $defaultValueArr = [
                                $document->name,
                                Helper::formatCategories($document->categories),
                                Helper::rip_tags($document->short_description),
                                Helper::rip_tags($document->description),
                                $document->meta_title,
                                $document->meta_keywords,
                                $document->meta_description,
                                $document->image,
                                $document->file,
                                $document->short_file,
                                $document->link_download,
                            ];
                            $documentMetaValues = $this->documentMetaValueRepository->findByField('doc_id', '=', $document->id, ['*'], false);
                            $metaValueArr = [];
                            foreach ($documentMetaValues as $value) {
                                array_push($metaValueArr, $value->value);
                            }
                            $sheet->row(2, array_merge($defaultValueArr, $metaValueArr));
                            $sheet->getStyle('A2:I' . $sheet->getHighestRow())
                                ->getAlignment()->setWrapText(true);
                        }
                    });
                }
            }
            $excel->sheet(__('messages.categories'), function ($sheet) {
                $sheet->setWidth([
                    'A' => 10,
                    'B' => 50,
                ]);
                $sheet->row(1, [
                    'ID', __('messages.categories'),
                ]);
                $sheet->row(1, function ($row) {
                    $row->setBackground('#ffff00');
                    $row->setBorder('thin', 'thin', 'thin', 'thin');
                });
                foreach ($this->categoryDocRepository->all() as $index => $category) {
                    $sheet->row($index + 2, [
                        $category->id,
                        $category->name,
                    ]);
                }
            });
        })->export('xlsx');
    }
}
