<?php

namespace App\Repositories;

use App\Models\CategoryDoc;

class CategoryDocRepository extends BGBaseRepository
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
        return CategoryDoc::class;
    }


    public function findByFieldWithLike($field, $value = null, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->where($field, 'LIKE', '%' . $value . '%')->get($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    protected $arrayCategory = [];

    public function getParentBySlug($categorySlug)
    {
        $category = $this->model->where('slug', '=', $categorySlug)->get()->first();

        if (!empty($category)) {
            $parent = $category->parent()->first();
            if (isset($parent)) {
                $this->arrayCategory[] = $parent->slug;
                $this->getParentBySlug($parent->slug);
            }
            $this->resetModel();
            return $this->arrayCategory;
        }

        $this->resetModel();
        return [];
    }
}
