<?php

namespace App\Repositories;

use App\Models\TestCategory;

class TestCategoryRepository extends BGBaseRepository
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
        return TestCategory::class;
    }
}
