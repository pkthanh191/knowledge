<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Repositories\PageRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PageController extends AppBaseController
{
    /** @var  PageRepository */
    private $pageRepository;

    public function __construct(PageRepository $pageRepo)
    {
        $this->pageRepository = $pageRepo;
    }

    /**
     * Display a listing of the Page.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $searchConditions = [];
        if(!empty($search)){
            if(!(empty($search['name']))){
                array_push($searchConditions,['name','LIKE','%'.$search['name'].'%']);
            }
            if(!(empty($search['description']))){
                array_push($searchConditions,['description','LIKE','%'.$search['description'].'%']);
            }
            $pages = $this->pageRepository->findWhere($searchConditions);
        }else{
            $pages = $this->pageRepository->paginate(15);
        }

        return view('backend.pages.index')
            ->with('pages', $pages);
    }

    /**
     * Show the form for creating a new Page.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.pages.create');
    }

    /**
     * Store a newly created Page in storage.
     *
     * @param CreatePageRequest $request
     *
     * @return Response
     */
    public function store(CreatePageRequest $request)
    {
        $input = $request->all();

        $page = $this->pageRepository->create($input);

        Flash::success(__('messages.created'));

        return redirect(route('admin.pages.index'));
    }

    /**
     * Display the specified Page.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.pages.index'));
        }

        return view('backend.pages.show')->with('page', $page);
    }

    /**
     * Show the form for editing the specified Page.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.pages.index'));
        }

        return view('backend.pages.edit')->with('page', $page);
    }

    /**
     * Update the specified Page in storage.
     *
     * @param  int              $id
     * @param UpdatePageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePageRequest $request)
    {
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            Flash::error(__('messages.not-found'));

            return redirect(route('admin.pages.index'));
        }

        $page = $this->pageRepository->update($request->all(), $id);

        Flash::success(__('messages.updated'));

        return redirect(route('admin.pages.index'));
    }

    /**
     * Remove the specified Page from storage.
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
                return redirect(route('admin.pages.index'));
            }else{
                foreach ($request->ids as $id) {
                    $page = $this->pageRepository->findWithoutFail($id);
                    if (empty($page)) {
                        Flash::error(__('messages.not-found'));

                        return redirect(route('admin.pages.index'));
                    }

                    $this->pageRepository->delete($id);
                }
                Flash::success(__('messages.deleted'));

                return redirect(route('admin.pages.index'));
            }
        }else{
            $page = $this->pageRepository->findWithoutFail($id);

            if (empty($page)) {
                Flash::error(__('messages.not-found'));

                return redirect(route('admin.pages.index'));
            }

            $this->pageRepository->delete($id);

            Flash::success(__('messages.deleted'));

            return redirect(route('admin.pages.index'));
        }
    }
}
