<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\CreateCoefficientRequest;
use App\Http\Requests\UpdateCoefficientRequest;
use App\Models\Coefficient;
use App\Repositories\CoefficientRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CoefficientController extends AppBaseController
{
    /** @var  CoefficientRepository */
    private $coefficientRepository;

    public function __construct(CoefficientRepository $coefficientRepo)
    {
        $this->coefficientRepository = $coefficientRepo;
    }

    /**
     * Display a listing of the Coefficient.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $coefficients = $this->coefficientRepository->orderBy('cost_from','asc')->paginate(15);

        return view('backend.coefficients.index')
            ->with('coefficients', $coefficients);
    }

    /**
     * Show the form for creating a new Coefficient.
     *
     * @return Response
     */
    public function create()
    {
        $max_from = $this->coefficientRepository->orderBy('cost_to','desc')->first()->cost_to;
        return view('backend.coefficients.create', compact('max_from'));
    }

    /**
     * Store a newly created Coefficient in storage.
     *
     * @param CreateCoefficientRequest $request
     *
     * @return Response
     */
    public function store(CreateCoefficientRequest $request)
    {
        if($request->cost_from)
            $request['cost_from'] = preg_replace('/^\D+|\./','',$request->cost_from);
        else
            $request['cost_from'] = 0;
        if($request->cost_to)
            $request['cost_to'] = preg_replace('/^\D+|\./','',$request->cost_to);
        else
            $request['cost_to'] = 999999999;
        if($request->apply_from && $request->apply_to) {
            $request['apply_from'] = date("Y-m-d H:i:s", strtotime($request->apply_from));
            $request['apply_to'] = date("Y-m-d H:i:s", strtotime($request->apply_to));
        } else{
            $request['apply_from'] = null;
            $request['apply_to'] = null;
//            if($this->alreadyContains($request['cost_from']))
//                return 'break';
        }
        $input = $request->all();

        $coefficient = $this->coefficientRepository->create($input);

        Flash::success(__('messages.created'));

        return redirect(route('admin.coefficients.index'));
    }

    /**
     * Display the specified Coefficient.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $coefficient = $this->coefficientRepository->findWithoutFail($id);

        if (empty($coefficient)) {
            Flash::error('Coefficient not found');

            return redirect(route('admin.coefficients.index'));
        }

        return view('backend.coefficients.show')->with('coefficient', $coefficient);
    }

    /**
     * Show the form for editing the specified Coefficient.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $coefficient = $this->coefficientRepository->findWithoutFail($id);
        if (empty($coefficient)) {
            Flash::error('Coefficient not found');

            return redirect(route('admin.coefficients.index'));
        }
        return view('backend.coefficients.edit',compact('coefficient','coe_front','coe_below'));
    }

    /**
     * Update the specified Coefficient in storage.
     *
     * @param  int              $id
     * @param UpdateCoefficientRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCoefficientRequest $request)
    {
        $coefficient = $this->coefficientRepository->findWithoutFail($id);

        if (empty($coefficient)) {
            Flash::error('Coefficient not found');

            return redirect(route('admin.coefficients.index'));
        }
        if($request->apply_from && $request->apply_to) {
            $request['apply_from'] = date("Y-m-d H:i:s", strtotime($request->apply_from));
            $request['apply_to'] = date("Y-m-d H:i:s", strtotime($request->apply_to));
        } else{
            $request['apply_from'] = null;
            $request['apply_to'] = null;
        }
        if($request->cost_from)
            $request['cost_from'] = preg_replace('/^\D+|\./','',$request->cost_from);
        else
            $request['cost_from'] = $coefficient->cost_from;
        if($request->cost_to)
            $request['cost_to'] = preg_replace('/^\D+|\./','',$request->cost_to);
        else
            $request['cost_to'] = $coefficient->cost_to;
        $coe_front = $this->coefficientRepository->orderBy('cost_to','desc')->findWhere([['cost_to','=',$coefficient->cost_from]])->first();
        $coe_below = $this->coefficientRepository->orderBy('cost_from','desc')->findWhere([['cost_from','=',$coefficient->cost_to]])->first();
        $min = $coe_front? $coe_front->cost_from : 0;
        $max = $coe_below? $coe_below->cost_to : 999999999;
        #TODO: Kiểm tra đầu cuối của 2 hệ số gần nhất xem sửa có hợp lệ không
        Validator::make($request->all(), array(
            'cost_from' => 'numeric|min:'.strval($min).'|max:'.strval($max),
            'cost_to' => 'numeric|max:'.strval($max).'|min:'.$request['cost_from'],
        ),[],Coefficient::attributes())->validate();
        $coefficient = $this->coefficientRepository->update($request->all(), $id);
        if($coe_front) {
            $coe_front->cost_to = $coefficient->cost_from;
            $coe_front->save();
        }
        if($coe_below) {
            $coe_below->cost_from = $coefficient->cost_to;
            $coe_below->save();
        }
        Flash::success(__('messages.updated'));

        return redirect(route('admin.coefficients.index'));
    }

    /**
     * Remove the specified Coefficient from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $coefficient = $this->coefficientRepository->findWithoutFail($id);

        if (empty($coefficient)) {
            Flash::error('Coefficient not found');

            return redirect(route('admin.coefficients.index'));
        }

        $coe_front = $this->coefficientRepository->orderBy('cost_to','desc')->findWhere([['cost_to','=',$coefficient->cost_from]])->first();
        if($coe_front) {
            $coe_front->cost_to = $coefficient->cost_to;
            $coe_front->save();
        }
        $this->coefficientRepository->delete($id);
        Flash::success(__('messages.deleted'));

        return redirect(route('admin.coefficients.index'));
    }

    function getCoefficient(Request $request){
        return $this->coefficientRepository->all();
    }

    function alreadyContains($cost){
        $coefficients = $this->coefficientRepository->findWhere([['apply_from','=',null],['apply_to','=',null]],['*']);
        return true;
    }
}
