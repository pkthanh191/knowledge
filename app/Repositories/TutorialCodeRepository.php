<?php

namespace App\Repositories;

use App\Models\TutorialCode;
use InfyOm\Generator\Common\BaseRepository;

class TutorialCodeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [

    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TutorialCode::class;
    }

}
