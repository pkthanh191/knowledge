<?php

namespace App\Repositories;

use App\Models\Coefficient;
use InfyOm\Generator\Common\BaseRepository;

class CoefficientRepository extends BaseRepository
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
        return Coefficient::class;
    }
}
