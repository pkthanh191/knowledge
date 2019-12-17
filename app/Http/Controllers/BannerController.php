<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\CreateBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Repositories\BannerRepository;
use Illuminate\Http\Request;
use Flash;
use Response;

class BannerController extends AppBaseController
{
    /** @var  BannerRepository */
    private $bannerRepository;

    public function __construct(BannerRepository $bannerRepo)
    {
        $this->bannerRepository = $bannerRepo;
    }

    /**
     * Display a listing of the Banner.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $searchCondition = [];
        if (!empty($search)) {
            if (!empty($search['name'])) {
                array_push($searchCondition, ['name', 'LIKE', '%' . $search['name'] . '%']);
            }
            $banners = $this->bannerRepository->orderBy('updated_at','desc')->search($searchCondition);
        } else
            $banners = $this->bannerRepository->orderBy('updated_at','desc')->paginate(15);
        return view('backend.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new Banner.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.banners.create');
    }

    /**
     * Store a newly created Banner in storage.
     *
     * @param CreateBannerRequest $request
     *
     * @return Response
     */
    public function store(CreateBannerRequest $request)
    {
        $input = $request->all();
        if (!empty($request->image)) {
            $imageName = time() . '.' . Helper::transText($request->image->getClientOriginalName(),'-');
            $request->image->move(public_path('uploads/banners/'), $imageName);
            $request->image = $imageName;
            $input['image'] = '/uploads/banners/'.$imageName;
        } else {
            $input['image'] = '/uploads/default-image.png';
        }

        $banner = $this->bannerRepository->create($input);

        Flash::success(__('messages.updated'));

        return redirect(route('admin.banners.index'));
    }

    /**
     * Display the specified Banner.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $banner = $this->bannerRepository->findWithoutFail($id);

        if (empty($banner)) {
            Flash::error('messages.no-items');

            return redirect(route('admin.banners.index'));
        }

        return view('backend.banners.show')->with('banner', $banner);
    }

    /**
     * Show the form for editing the specified Banner.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $banner = $this->bannerRepository->findWithoutFail($id);

        if (empty($banner)) {
            Flash::error('messages.no-items');

            return redirect(route('admin.banners.index'));
        }

        return view('backend.banners.edit')->with('banner', $banner);
    }

    /**
     * Update the specified Banner in storage.
     *
     * @param  int              $id
     * @param UpdateBannerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBannerRequest $request)
    {
        $banner = $this->bannerRepository->findWithoutFail($id);

        if (empty($banner)) {
            Flash::error('messages.no-items');

            return redirect(route('admin.banners.index'));
        }

        $input = $request->all();
        if (!empty($request->image)) {
            $imageName = time() . '.' . Helper::transText($request->image->getClientOriginalName(),'-');
            $request->image->move(public_path('uploads/banners/'), $imageName);
            $request->image = $imageName;
            $input['image'] = '/uploads/banners/'.$imageName;
        }
        else{
            $input['image'] = $banner->image;
        }

        $banner = $this->bannerRepository->update($input, $id);

        Flash::success(__('messages.updated'));

        return redirect(route('admin.banners.index'));
    }

    /**
     * Remove the specified Banner from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        if ($id == 'MULTI') {
            if (!is_null($request->ids)) {
                foreach ($request->ids as $id) {
                    $banner = $this->bannerRepository->findWithoutFail($id);
                    $this->bannerRepository->delete($id);
                }
                Flash::success(__('messages.deleted'));
                return redirect(route('admin.banners.index'));
            } else {
                Flash::error(__('messages.checkBanner'));
                return redirect(route('admin.banners.index'));
            }
        } else {
            $banner = $this->bannerRepository->findWithoutFail($id);
            if (empty($banner)) {
                Flash::error(__('messages.no-items'));
                return redirect(route('admin.banners.index'));
            }
            $this->bannerRepository->delete($id);
            Flash::success(__('messages.deleted'));
            return redirect(route('admin.banners.index'));
        }
    }
}
