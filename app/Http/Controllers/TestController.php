<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTestRequest;
use App\Http\Requests\UpdateTestRequest;
use App\Repositories\CategoryTestRepository;
use App\Repositories\TestCategoryRepository;
use App\Repositories\TestRepository;
use App\Repositories\TransactionRepository;
use function foo\func;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Response;
use Excel;
use App\Helpers\Helper;
use App\Repositories\CommentTestRepository;

class TestController extends AppBaseController
{
    /** @var  TestRepository */
    private $testRepository;
    private $categoryTestsRepository;
    private $testsCategoryRepository;
    private $img_default;
    private $commentTestRepository;
    private $transactionRepository;

    public function __construct(TestRepository $testRepo, CategoryTestRepository $categoryTestRepo, TestCategoryRepository $testCategoryRepo, CommentTestRepository $commentTestRepo, TransactionRepository $transactionRepository)
    {
        $this->testRepository = $testRepo;
        $this->categoryTestsRepository = $categoryTestRepo;
        $this->testsCategoryRepository = $testCategoryRepo;
        $this->img_default = '/public/uploads/default-image.png';
        $this->commentTestRepository = $commentTestRepo;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Display a listing of the Test.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $categories = $this->categoryTestsRepository->buildTreeForSelectBox(['id', 'name'], '- ', null, __('messages.select_category_test'));
        $search = $request->search;
        $searchCondition = [];
        if (!empty($search)) {
            if (!empty($search['name'])) {
                array_push($searchCondition, ['name', 'LIKE', '%' . $search['name'] . '%']);
            }
            if (!empty($search['category']) && $search['category'] != 0) {
                $temp = $this->testRepository->search($searchCondition, $search['category']);
                $tests_export = $temp->get(['tests.*']);
                $tests = $temp->orderBy('updated_at', 'desc')->paginate(18, ['tests.*']);;
            } else {
                $temp = $this->testRepository->search($searchCondition);
                $tests_export = $temp->get();
                $tests = $temp->orderBy('updated_at', 'desc')->paginate(18);
            }
        } else {
            $tests = $this->testRepository->with('categories')->orderBy('updated_at', 'desc')->paginate(18);
            $tests_export = [];
        }
//        dd($tests_export);
        return view('backend.tests.index', compact('tests', 'categories', 'tests_export'));
    }


    /**
     * Show the form for creating a new Test.
     *
     * @return Response
     */

    public function create()
    {
        $categories = $this->categoryTestsRepository->buildTree(['id', 'name']);
        $selectedCategories = null;
        return view('backend.tests.create', compact('categories', 'selectedCategories'));
    }

    /**
     * Store a newly created Test in storage.
     *
     * @param CreateTestRequest $request
     *
     * @return Response
     */
    public function store(CreateTestRequest $request)
    {
        $input = $request->all();
        if ($request->categories != null) {

            if (!empty($request->image)) {
                $imageName = time() . '.tests.' . Helper::transText($request->image->getClientOriginalName(), '-');
                $request->image->move(public_path('uploads/tests'), $imageName);
                $request->image = $imageName;
                $input['image'] = '/public/uploads/tests/' . $imageName;
            } else {
                $input['image'] = '/public/uploads/tests/default-image.png';
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
            $input['comment_counts'] = 0;
            $input['view_counts'] = 0;
            if ($input['duration'] == null) {
                $input['duration'] = 0;
            }
            $input["user_id"] = Auth::user()->id;
            $this->testRepository->create($input);

            Flash::success(__('messages.created'));

            return redirect(route('admin.tests.index'));
        } else {
            Flash::error(__('messages.categories_null'));

            return back()->withInput();
        }
    }

    /**
     * Display the specified Test.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $test = $this->testRepository->findWithoutFail($id);
//        dd($test->imge);
        if (empty($test)) {
            Flash::error(__('messages.no-items'));

            return redirect(route('admin.tests.index'));
        }
        return view('backend.tests.show')->with('test', $test);
    }

    /**
     * Show the form for editing the specified Test.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $categories = $this->categoryTestsRepository->buildTree(['id', 'name']);
        $selectedCategories = $this->testsCategoryRepository->findByField('test_id', '=', $id, ['category_test_id'], false)->toArray();
        $test = $this->testRepository->findWithoutFail($id);
        $arr = [];
//        $time = $test->duration;
        foreach ($selectedCategories as $selectedCategory) {
            array_push($arr, $selectedCategory['category_test_id']);
        }
        $selectedCategories = $arr;
        if (empty($test)) {
            Flash::error(__('messages.no-items'));

            return redirect(route('admin.tests.index'));
        }
        return view('backend.tests.edit', compact('test', 'categories', 'selectedCategories'));
    }

    /**
     * Update the specified Test in storage.
     *
     * @param  int $id
     * @param UpdateTestRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTestRequest $request)
    {
        if ($request->categories == null) {
            Flash::error(__('messages.categories_null'));
            return back()->withInput();
        }
        $tests = $this->testRepository->findWithoutFail($id);
        if (empty($tests)) {
            Flash::error(__('messages.not-found'));
            return redirect(route('admin.tests.index'));
        }
        $input = $request->all();
        $this->validate($request, [
            'name' => 'max:255',
        ]);
        if (!empty($request->image)) {
            $imageName = time() . '.' . Helper::transText($request->image->getClientOriginalName(), '-');
            $request->image->move(public_path('uploads/tests'), $imageName);
            $request->image = $imageName;
            $input['image'] = '/public/uploads/tests/' . $imageName;
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
        if ($input['duration'] == null) {
            $input['duration'] = 0;
        }
        $tests["user_id"] = Auth::user()->id;
        $tests = $this->testRepository->update($input, $id);

        Flash::success(__('messages.updated'));
        return redirect(route('admin.tests.index'));

    }

    /**
     * Remove the specified Test from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        if ($id == 'MULTI') {
            if (!is_null($request->ids)) {
                $checked = [];
                foreach ($request->ids as $id) {
                    $test = $this->testRepository->findWithoutFail($id);
                    if (empty($test)) {
                        Flash::error(__('messages.not-found'));

                        return back();
                    }
                    if (!$test->comments->isEmpty()) {
                        Flash::warning(__('messages.alert_delete_comment'));
                        return back();
                    }
                    array_push($checked, $id);
                }
                foreach ($checked as $id) {
                    #TODO: Xóa quan hệ với giao dịch, đưa giao dịch về với tài liệu không xác định
                    $transactions = $this->transactionRepository->findWhere(['test_id' => $id]);
                    foreach ($transactions as $tran) {
                        $tran->test_id = 0;
                        $tran->save();
                    }
                    $this->testsCategoryRepository->deleteWhere([['test_id', '=', $id]]);
                    $this->commentTestRepository->deleteWhere([['test_id', '=', $id]]);
                    $this->testRepository->delete($id);
                }
                Flash::success(__('messages.deleted'));
                return back();
            } else {
                Flash::error(__('messages.checkTest'));
                return back();
            }
        } else {
            $test = $this->testRepository->findWithoutFail($id);
            if (empty($test)) {
                Flash::error(__('messages.no-items'));
                return back();
            } elseif (!$test->comments->isEmpty()) {
                Flash::warning(__('messages.alert_delete_comment'));
                return back();
            }
            #TODO: Xóa quan hệ với giao dịch, đưa giao dịch về với tài liệu không xác định
            $transactions = $this->transactionRepository->findWhere(['test_id' => $id]);
            foreach ($transactions as $tran) {
                $tran->test_id = 0;
                $tran->save();
            }
            $this->commentTestRepository->deleteWhere([['test_id', '=', $id]]);
            $this->testsCategoryRepository->deleteWhere([['test_id', '=', $id]]);
            $this->testRepository->delete($id);
            Flash::success(__('messages.deleted'));
            return back();
        }
    }

    public function exportExcel(Request $request)
    {
        if (isset($request->searched)) {
            $tests = $this->testRepository->findWhereIn('id', $request->searched, ['*'], false);
        } else $tests = $this->testRepository->all();
        Excel::create(__('messages.test'), function ($excel) use ($tests) {
            $excel->sheet(__('messages.test'), function ($sheet) use ($tests) {
                $titleArray = [
                    __('messages.test_name'),
                    __('messages.category_test'),
                    __('messages.test_short_description'),
                    __('messages.test_description'),
                    __('messages.test_slug'),
                    __('messages.meta_title'),
                    __('messages.meta_keywords'),
                    __('messages.meta_description'),
                    __('messages.test_comment_counts'),
                    __('messages.test_view_counts'),
                    __('messages.test_duration'),
                    __('messages.image_url'),
                    __('messages.test_file'),
                    __('messages.test_short_file'),
                    __('messages.test_link_down'),
                    __('messages.test_user'),
                    __('messages.created_at'),
                    __('messages.updated_at')
                ];
                $sheet->row(1, $titleArray);
                $sheet->setWidth([
                    'A' => 40,
                    'B' => 40,
                    'C' => 80,
                    'D' => 80,
                    'E' => 30,
                    'F' => 30,
                    'G' => 30,
                    'H' => 30,
                    'I' => 10,
                    'J' => 10,
                    'K' => 10,
                    'L' => 40,
                    'M' => 40,
                    'N' => 40,
                    'O' => 40,
                    'P' => 10,
                    'Q' => 20,
                    'R' => 20,
                ]);
                foreach ($tests as $index => $test) {
                    $test->description = Helper::rip_tags($test->description);
                    $test->short_description = Helper::rip_tags($test->short_description);
                    $str = '';
                    foreach ($test->categories as $key => $category) {
                        if ($key > 0)
                            $str .= ', ' . $category->name;
                        else $str = $category->name;
                    }
                    $sheet->row($index + 2, [
                        $test->name,
                        $str,
                        $test->short_description,
                        $test->description,
                        $test->slug,
                        $test->meta_title,
                        $test->meta_keywords,
                        $test->meta_description,
                        $test->comment_counts,
                        $test->view_counts,
                        $test->duration,
                        $test->image,
                        $test->file,
                        $test->short_file,
                        $test->link_download,
                        $test->user->name,
                        $test->created_at->format('d/m/Y'),
                        $test->updated_at->format('d/m/Y'),
                    ]);
                    $sheet->getStyle('A2:' . chr(ord('A') + count($titleArray)) . $sheet->getHighestRow())
                        ->getAlignment()->setWrapText(true);
                    for ($i = 'A'; $i < chr(ord('A') + count($titleArray)); $i++) {
                        $sheet->cell($i . '1', function ($cell) {
                            $cell->setBackground('#ffff00');
                            $cell->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                        for ($j = 2; $j < count($tests) + 2; $j++) {
                            $sheet->cell($i . $j, function ($cell) {
                                $cell->setValignment('center');
                            });
                        }
                    }
                }
            });
        })->export('xlsx');
    }

    public function showImport()
    {
        return view('backend.tests.import');
    }

    public function formImport()
    {
        Excel::create(__('messages.test_form_import'), function ($excel) {
            $excel->sheet(__('messages.test'), function ($sheet) {
                $txtRequired = ' (*)';
                $titleArray = [
                    __('messages.test_name') . $txtRequired,
                    __('messages.category_test') . $txtRequired,
                    __('messages.test_short_description'),
                    __('messages.test_description'),
                    __('messages.meta_title') . $txtRequired,
                    __('messages.meta_keywords'),
                    __('messages.meta_description'),
                    __('messages.test_duration'),
                    __('messages.image_url'),
                    __('messages.test_file'),
                    __('messages.test_short_file'),
                    __('messages.test_link_down'),
                ];
                $sheet->row(1, $titleArray);
                $sheet->setWidth([
                    'A' => 40,
                    'B' => 40,
                    'C' => 50,
                    'D' => 50,
                    'E' => 30,
                    'F' => 30,
                    'G' => 30,
                    'H' => 10,
                    'I' => 40,
                    'J' => 40,
                    'K' => 40,
                    'L' => 10,
                ]);
                $sheet->row(1, function ($row) {
                    $row->setBackground('#ffff00');
                });
                $test = $this->testRepository->orderBy('updated_at','desc')->first(['*']);
                $test->description = Helper::rip_tags($test->description);
                $test->short_description = Helper::rip_tags($test->short_description);
                $str = '';
                foreach ($test->categories as $key => $category) {
                    if ($key > 0)
                        $str .= ', ' . $category->name;
                    else $str = $category->name;
                }
                $sheet->row(2, [
                        $test->name,
                        $str,
                        $test->short_description,
                        $test->description,
                        $test->meta_title,
                        $test->meta_keywords,
                        $test->meta_description,
                        $test->duration,
                        $test->image,
                        $test->file,
                        $test->short_file,
                        $test->link_download,]
                );
                $sheet->getStyle('A2:' . chr(ord('A') + count($titleArray)) . $sheet->getHighestRow())
                    ->getAlignment()->setWrapText(true);
                for ($i = 'A'; $i < chr(ord('A') + count($titleArray)); $i++) {
                    $sheet->cell($i . '1', function ($cell) {
                        $cell->setBackground('#ffff00');
                        $cell->setBorder('thin', 'thin', 'thin', 'thin');
                    });
                    $sheet->cell($i . '2', function ($cell) {
                        $cell->setValignment('center');
                    });
                }
            });
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
                });
                foreach ($this->categoryTestsRepository->all() as $index => $category) {
                    $sheet->row($index + 2, [
                        $category->id,
                        $category->name,
                    ]);
                }
            });
        })->export('xlsx');
    }

public function importExcel(Request $request)
{
    $this->validate($request, ['file' => 'required|file|mimes:xls,xlsx'], [], ['file' => 'File']);
    Excel::load($request->file, function ($reader) {
        $fail = false;
        $added = [];
        $sheet = $reader->first();
        if (isset($sheet[Helper::transText(__('messages.test_name'))]))
            $sheet = $reader;
        if ($sheet->getTitle() != __('messages.categories')) {
            foreach ($sheet as $row) {
                try {
                    $input['name'] = $row[Helper::transText(__('messages.test_name'))];
                    $input['short_description'] = $row[Helper::transText(__('messages.test_short_description'))];
                    $input['description'] = $row[Helper::transText(__('messages.test_description'))];
                    $input['meta_title'] = $row[Helper::transText(__('messages.meta_title'))];
                    $input['meta_keywords'] = $row[Helper::transText(__('messages.meta_keywords'))];
                    $input['meta_description'] = $row[Helper::transText(__('messages.meta_description'))];
                    if (empty($row[Helper::transText(__('messages.image_url'))]) || !file_exists(public_path($row[Helper::transText(__('messages.image_url'))])))
                        $input['image'] = '/public/uploads/default-image.png';
                    else
                        $input['image'] = $row[Helper::transText(__('messages.image_url'))];
                    $input['user_id'] = Auth::user()->id;
                    $input['duration'] = $row[Helper::transText(__('messages.test_duration'))];
                    $input['file'] = $row[Helper::transText(__('messages.test_file'))];
                    $input['short_file'] = $row[Helper::transText(__('messages.test_short_file'))];
                    $input['link_download'] = $row[Helper::transText(__('messages.test_link_down'))];
                    $test = $this->testRepository->create($input);
                    //Danh mục đề thi phân cách bởi dấu phẩy
                    $categoryStr = $row[Helper::transText(__('messages.category_test'))];
                    $categories = explode(', ', $categoryStr);
                    $not_cate = true;
                    foreach ($categories as $str) {
                        $category = $this->categoryTestsRepository->findByField('name', 'LIKE', $str, ['*'], false)->first();
                        if (isset($category)) {
                            $not_cate = false;
                            $inc['test_id'] = $test->id;
                            $inc['category_test_id'] = $category->id;
                            $this->testsCategoryRepository->create($inc);
                        }
                    }
                    if ($not_cate){
                        $this->testRepository->delete($test->id);
                        throw new \ErrorException();
                    }
                    array_push($added, $test);
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
        if ($fail) {
            foreach ($added as $test) {
                if (empty($test)) {
                    Flash::error(__('messages.no-items'));
                    return redirect(route('admin.tests.index'));
                }
                $this->testsCategoryRepository->deleteWhere([['test_id', '=', $test->id]]);
                $this->testRepository->delete($test->id);
                Flash::success(__('messages.deleted'));
                return redirect(route('admin.tests.index'));
            }
        } else
            Flash::success(__('messages.imported'));
    });
    return redirect(route('admin.tests.import'));
}
}