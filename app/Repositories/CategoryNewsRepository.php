<?php

namespace App\Repositories;

use App\Models\CategoryNews;

class CategoryNewsRepository extends BGBaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [];

    /**
     * Configure the Model
     **/
    public function BGModel()
    {
        return CategoryNews::class;
    }

    protected $arrayCategoryNews = [];

    public function getParentBySlug($categorySlug)
    {
        $category = $this->model->where('slug', '=', $categorySlug)->get()->first();
        if (!empty($category)) {
            $this->resetModel();
            return [];
        }
        $parent = $category->parent()->first();
        if (isset($parent)) {
            $this->arrayCategoryNews[] = $parent->slug;
            $this->getParentBySlug($parent->slug);
        }
        $this->resetModel();
        return $this->arrayCategoryNews;
    }
}
