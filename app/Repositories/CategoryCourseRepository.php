<?php

namespace App\Repositories;

use App\Models\CategoryCourse;

class CategoryCourseRepository extends BGBaseRepository
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
        return CategoryCourse::class;
    }

    public function findByFieldWithLike($field, $value = null, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->where($field, 'LIKE', '%'.$value.'%')->get($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

}
