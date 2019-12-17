<?php

namespace App\Repositories;

use App\Models\City;
use InfyOm\Generator\Common\BaseRepository;

class CityRepository extends BGBaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'name',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function BGModel()
    {
        return City::class;
    }
}
