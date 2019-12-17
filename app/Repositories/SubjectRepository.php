<?php

namespace App\Repositories;

use App\Models\Subject;

class SubjectRepository extends BGBaseRepository
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
        return Subject::class;
    }
}
