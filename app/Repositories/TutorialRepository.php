<?php

namespace App\Repositories;

use App\Models\Tutorial;

class TutorialRepository extends BGBaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Configure the Model
     **/
    public function BGModel()
    {
        return Tutorial::class;
    }

    public function search($where, $compare = null, $isFrontend = false) {
//        $this->applyConditions($where);
        if(!empty($where)){
            $this->model->where($where[0][0],$where[0][1],$where[0][2]);
            $this->model->orWhere($where[1][0],$where[1][1],$where[1][2]);
        }
        if(!empty($compare)){
            if($isFrontend == true) {
                array_push($compare, ['active', '=', 1,], ['confirm', '=', '1']);
            }
            $tutorials = $this->model->with('grades')->join('grade_tutorials', function ($join) {
                $join->on('tutorials.id', '=', 'grade_tutorials.tutorial_id');
            })->with('subjects')->join('subject_tutorials', function ($join){
                $join->on('tutorials.id', '=', 'subject_tutorials.tutorial_id');
            })->with('district')->join('districts', function ($join){
                $join->on('tutorials.district_id', '=', 'districts.id');
            })->join('cities', function ($join){
                $join->on('districts.code_city', '=', 'cities.code');
            })->where($compare)->whereNull('grade_tutorials.deleted_at')->paginate(18, ['tutorials.*']);
        }else{
            $tutorials = $this->model->with('grades')->paginate(18);
        }

        $this->resetModel();
        return $tutorials;
    }

    public function getByGrades($level) {
        if($level == 1) {
            $lv = [1,2,3,4,5];
        } elseif ($level == 2) {
            $lv = [6,7,8,9];
        } elseif ($level == 3) {
            $lv = [10,11,12];
        } else {
            $lv = [13];
        }
        $tutorials = $this->model->join('grade_tutorials', function ($join) {
            $join->on('tutorials.id', '=', 'grade_tutorials.tutorial_id');
        })->where([['active', '=', 1,], ['confirm', '=', '0']])->whereIn('grade_tutorials.grade_id', $lv)->distinct('grade_tutorials.grade_id')->orderBy('grade_tutorials.grade_id', 'asc')->get(['tutorials.*','grade_tutorials.grade_id']);

        $this->resetModel();
        return $tutorials;
    }
}
