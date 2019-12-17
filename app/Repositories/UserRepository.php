<?php

namespace App\Repositories;

use App\User;
use InfyOm\Generator\Common\BaseRepository;

class UserRepository extends BGBaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [

    ];

    public function BGModel()
    {
        return User::class;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    public function search($condition)
    {
        $this->applyConditions($condition);
        return $this->orderBy('updated_at', 'DESC')->paginate(5);
    }

}
