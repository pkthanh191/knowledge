<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCourseOrderRequest;
use App\Http\Requests\UpdateCourseOrderRequest;
use App\Repositories\CourseOrderRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CourseOrderController extends AppBaseController
{
    /** @var  CourseOrderRepository */
    private $courseOrderRepository;

    public function __construct(CourseOrderRepository $courseOrderRepo)
    {
        $this->courseOrderRepository = $courseOrderRepo;
    }

    /**
     * Display a listing of the CourseOrder.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->courseOrderRepository->pushCriteria(new RequestCriteria($request));
        $courseOrders = $this->courseOrderRepository->all();

        return view('backend.course_orders.index')
            ->with('courseOrders', $courseOrders);
    }

    /**
     * Show the form for creating a new CourseOrder.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.course_orders.create');
    }

    /**
     * Store a newly created CourseOrder in storage.
     *
     * @param CreateCourseOrderRequest $request
     *
     * @return Response
     */
    public function store(CreateCourseOrderRequest $request)
    {
        $input = $request->all();

        $courseOrder = $this->courseOrderRepository->create($input);

        Flash::success('Course Order saved successfully.');

        return redirect(route('admin.courseOrders.index'));
    }

    /**
     * Display the specified CourseOrder.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $courseOrder = $this->courseOrderRepository->findWithoutFail($id);

        if (empty($courseOrder)) {
            Flash::error('Course Order not found');

            return redirect(route('admin.courseOrders.index'));
        }

        return view('backend.course_orders.show')->with('courseOrder', $courseOrder);
    }

    /**
     * Show the form for editing the specified CourseOrder.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $courseOrder = $this->courseOrderRepository->findWithoutFail($id);

        if (empty($courseOrder)) {
            Flash::error('Course Order not found');

            return redirect(route('admin.courseOrders.index'));
        }

        return view('backend.course_orders.edit')->with('courseOrder', $courseOrder);
    }

    /**
     * Update the specified CourseOrder in storage.
     *
     * @param  int              $id
     * @param UpdateCourseOrderRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCourseOrderRequest $request)
    {
        $courseOrder = $this->courseOrderRepository->findWithoutFail($id);

        if (empty($courseOrder)) {
            Flash::error('Course Order not found');

            return redirect(route('admin.courseOrders.index'));
        }

        $courseOrder = $this->courseOrderRepository->update($request->all(), $id);

        Flash::success('Course Order updated successfully.');

        return redirect(route('admin.courseOrders.index'));
    }

    /**
     * Remove the specified CourseOrder from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $courseOrder = $this->courseOrderRepository->findWithoutFail($id);

        if (empty($courseOrder)) {
            Flash::error('Course Order not found');

            return redirect(route('admin.courseOrders.index'));
        }

        $this->courseOrderRepository->delete($id);

        Flash::success('Course Order deleted successfully.');

        return redirect(route('admin.courseOrders.index'));
    }
}
