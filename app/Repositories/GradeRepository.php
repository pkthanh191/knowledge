<?php

namespace App\Repositories;

use App\Models\Grade;

class GradeRepository extends BGBaseRepository
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
        return Grade::class;
    }
}
