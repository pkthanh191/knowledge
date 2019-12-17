<?php

namespace App\Repositories;

use App\Models\GradeTutorial;
use InfyOm\Generator\Common\BaseRepository;

class GradeTutorialRepository extends BGBaseRepository
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
        return GradeTutorial::class;
    }
}
