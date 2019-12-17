<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryTestRequest;
use App\Http\Requests\UpdateCategoryTestRequest;
use App\Repositories\CategoryTestRepository;
use App\Repositories\TestCategoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CategoryTestController extends AppBaseController
{
    /** @var  CategoryTestRepository */
    private $categoryTestRepository;
    private $testCategoryRepository;
    public function __construct(CategoryTestRepository $categoryTestRepo,TestCategoryRepository $testCategoryRepo)
    {
        $this->categoryTestRepository = $categoryTestRepo;
        $this->testCategoryRepository = $testCategoryRepo;
    }

    /**
     * Display a listing of the CategoryTest.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $keyword = $request->search;
        if(!empty($keyword)){
            $categoryTests = $this->categoryTestRepository->findByField('name','LIKE','%'.$keyword.'%',["*"]);
        }else{
            $categoryTests = $this->categoryTestRepository->orderBy('orderSort','asc')->orderBy('updated_at','desc')->buildTree();
        }

        return view('backend.category_tests.index')
            ->with('categoryTests', $categoryTests);
    }

    /**
     * Show the form for creating a new CategoryTest.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->categoryTestRepository->buildTreeForSelectBox(['id', 'name'], $this->SEPARATOR_SPACE, null, __('messages.select_category_test'));
        return view('backend.category_tests.create', compact('parents'))->with('categories', $categories);
    }

    /**
     * Store a newly created CategoryTest in storage.
     *
     * @param CreateCategoryTestRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryTestRequest $request)
    {
        $input = $request->all();

        $categoryTest = $this->categoryTestRepository->create($input);

        Flash::success(__('messages.created'));

        return redirect(route('admin.categoryTests.index'));
    }

    /**
     * Display the specified CategoryTest.
     *
     * @param  int $id
     *
     * @return Response
     */




    public function show($id)
    {
        $categoryTest = $this->categoryTestRepository->findWithoutFail($id);

        if (empty($categoryTest)) {
            Flash::error(__('messages.no-items'));

            return redirect(route('admin.categoryTests.index'));
        }

        return view('backend.category_tests.show')->with('categoryTest', $categoryTest);
    }

    /**
     * Show the form for editing the specified CategoryTest.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $categoryTest = $this->categoryTestRepository->findWithoutFail($id);
        $categories = $this->categoryTestRepository->buildTreeForSelectBox(['id', 'name'], $this->SEPARATOR_SPACE, $id, __('messages.select_category_test'));

        if (empty($categoryTest)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.categoryTests.index'));
        }
        return view('backend.category_tests.edit', compact('parents'))->with('categoryTest', $categoryTest)->with('categories', $categories);
    }

    /**
     * Update the specified CategoryTest in storage.
     *
     * @param  int              $id
     * @param UpdateCategoryTestRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryTestRequest $request)
    {
        $this->validate($request, [
            'name' => 'max:255',
        ]);
        $categoryTest = $this->categoryTestRepository->findWithoutFail($id);
        if (empty($categoryTest)) {
            Flash::error(__('messages.no-items'));

            return redirect(route('admin.categoryTests.index'));
        }

        $categoryTest = $this->categoryTestRepository->update($request->all(), $id);

        Flash::success(__('messages.updated'));

        return redirect(route('admin.categoryTests.index'));
    }
    /**
     * Remove the specified CategoryTest from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id,Request $request)
    {
        if ($id == 'MULTI') {
            if(!is_null($request->ids)){
                $legals=[];
                $illegals=[];
                foreach ($request->ids as $id) {
                    $categoryTest = $this->categoryTestRepository->findWithoutFail($id);
                    if (empty($categoryTest)) {
                        Flash::error(__('messages.not-found'));
                        return redirect(route('admin.categoryTests.index'));
                    }
                    $children = $this->categoryTestRepository->findWhere([['parent_id','=',$id]],['*']);
                    $test = $this->testCategoryRepository->findWhere([['category_test_id','=',$id]],['*']);
                    if(count($test) == 0&&count($children)==0){
                        $legals[]=$id;

                    }else{
                        $illegals[]=$this->categoryTestRepository->findWithoutFail($id);
                        #TODO pop-up
                    }
                }
                if(count($illegals)!=0){
                    $rs='';
                    $len = count($illegals);
                    for($i = 0 ; $i < $len ; $i++){
                        if($i != $len - 1){
                            $rs .= ' '.$illegals[$i]->name.',';
                        }else{
                            $rs .= ' '.$illegals[$i]->name;
                        }
                    }
                    $contains = __('messages.contains');
                    $messages = __('messages.undeleted');
                    Flash::error($messages.': '.$rs.' '.$contains);
                    return redirect(route('admin.categoryTests.index'));
                }
                else{
                    foreach ($legals as $id){
                        $this->categoryTestRepository->delete($id);
                    }
                }
                Flash::success(__('messages.deleted'));
                return redirect(route('admin.categoryTests.index'));
            }
            else{
                Flash::error(__('messages.checkCategorys'));
                return redirect(route('admin.categoryTests.index'));
            }
        }
        else{
            $categoryTest = $this->categoryTestRepository->findWithoutFail($id);
            if (empty($categoryTest)) {
                Flash::error(__('messages.not-found'));
                return redirect(route('admin.categoryTests.index'));
            }
            $children = $this->categoryTestRepository->findWhere([['parent_id','=',$id]],['*']);
            $test = $this->testCategoryRepository->findWhere([['category_test_id','=',$id]],['*']);
            if(count($children) == 0&&count($test)==0){
                $this->categoryTestRepository->delete($id);
                Flash::success(__('messages.deleted'));
                return redirect(route('admin.categoryTests.index'));
            }else{
                if(count($children) != 0&&count($test)!=0){
                    Flash::error(__('messages.category_tests_not_empty'));
                    return redirect(route('admin.categoryTests.index'));
                }
                else{
                    if(count($children) != 0){
                        Flash::error(__('messages.haveChilds'));
                        return redirect(route('admin.categoryTests.index'));
                    }
                    else{
                        Flash::error(__('messages.haveTests'));
                        return redirect(route('admin.categoryTests.index'));
                    }
                }
            }
        }

    }

    
    public static function getNameParent($category){
        $parent = $category->parent_id;
        if($parent==0){
            return __('messages.root');
        }
        else{
            return \App\Models\CategoryTest::where('id',$parent)->pluck('name')->first();
        }
    }
}
