<?php

namespace App\Repositories;

use App\Models\NewsCategory;

class NewsCategoryRepository extends BGBaseRepository
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
        return NewsCategory::class;
    }
}
