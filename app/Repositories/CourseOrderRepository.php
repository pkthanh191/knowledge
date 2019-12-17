<?php

namespace App\Repositories;

use App\Models\CourseOrder;

class CourseOrderRepository extends BGBaseRepository
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
        return CourseOrder::class;
    }
}
