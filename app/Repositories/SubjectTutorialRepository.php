<?php

namespace App\Repositories;

use App\Models\SubjectTutorial;
use InfyOm\Generator\Common\BaseRepository;

class SubjectTutorialRepository extends BGBaseRepository
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
        return SubjectTutorial::class;
    }
}
