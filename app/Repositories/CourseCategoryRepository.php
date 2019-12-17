<?php

namespace App\Repositories;

use App\Models\CourseCategory;

class CourseCategoryRepository extends BGBaseRepository
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
        return CourseCategory::class;
    }
}
