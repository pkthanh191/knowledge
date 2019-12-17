<?php

namespace App\Repositories;

use App\Models\Center;

class CenterRepository extends BGBaseRepository
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
        return Center::class;
    }

    public function getCenters($name = null){
        $centers = $this->model->where('id', '<>', '0')->where('name', 'LIKE', '%'.$name.'%')->orWhere('description', 'LIKE', '%'.$name.'%')->paginate(18);
        $this->resetModel();
        return $centers;
    }

    public function getWithout0()
    {
        $centers = $this->model->where('id', '<>', '0')->get();
        $this->resetModel();
        return $centers;
    }
//    public function getRelatives($center) {
//        $centers = $this->model->with('categories')->join('document_categories', function ($join) {
//            $join->on('documents.id', '=', 'document_categories.document_id');
//        })->where('documents.id', '!=', $center->id)->limit(10)->get(['documents.*']);
//
//        return $centers;
//    }

}
