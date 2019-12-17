<?php

namespace App\Repositories;

use App\Models\District;
use InfyOm\Generator\Common\BaseRepository;

class DistrictRepository extends BGBaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'name',
        'type',
        'code_city'
    ];

    /**
     * Configure the Model
     **/
    public function BGModel()
    {
        return District::class;
    }
}
