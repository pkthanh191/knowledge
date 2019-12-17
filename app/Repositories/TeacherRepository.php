<?php

namespace App\Repositories;

use App\Models\Teacher;

class TeacherRepository extends BGBaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function BGModel()
    {
        return Teacher::class;
    }

    public function search($condition) {
        $this->applyConditions($condition);
        return $this->model->paginate(15);

//        $teachers = $this->applyConditions($where);
//        if(!empty($keyCenter)){
//            $teachers = $this->model->whereHas('center', function ($query) use($keyCenter) {
//                $query->where('name', 'like', '%'.$keyCenter.'%');
//            })->paginate(15);
//        }else{
//            $teachers = $this->model->paginate(15);
//        }
//
//        $this->resetModel();
//        return $teachers;
    }

    public function getTeachers($name = null){
        $teachers = $this->model->where('id', '<>', '0')->where('name', 'LIKE', '%'.$name.'%')->paginate(18);

        $this->resetModel();
        return $teachers;
    }
    public function getWithout0(){
        $teachers = $this->model->where('id', '<>', '0')->get();
        return $teachers;
    }
}
