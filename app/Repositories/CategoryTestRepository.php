<?php

namespace App\Repositories;

use App\Models\CategoryTest;

class CategoryTestRepository extends BGBaseRepository
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
        return CategoryTest::class;
    }

    protected $arrayCategoryTest = [];

    public function getParentBySlug($categorySlug)
    {
        $category = $this->model->where('slug', '=', $categorySlug)->get()->first();
        if (!empty($category)) {
            $this->resetModel();
            return [];
        }

        $parent = $category->parent()->first();
        if (isset($parent)) {
            $this->arrayCategoryTest[] = $parent->slug;
            $this->getParentBySlug($parent->slug);
        }
        $this->resetModel();
        return $this->arrayCategoryTest;
    }
}
