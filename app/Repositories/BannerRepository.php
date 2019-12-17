<?php

namespace App\Repositories;

use App\Models\Banner;
use InfyOm\Generator\Common\BaseRepository;

class BannerRepository extends BaseRepository
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
    public function model()
    {
        return Banner::class;
    }

    public function search($condition)
    {
        $this->applyConditions($condition);
        return $this->paginate(5);
    }

    public function getByPosition($position){
        $banner = $this->model->where('position','=',$position)->where('status','=',1)->get()->first();
        $this->resetModel();
        return $banner;
    }

    public function  getbyChecked(){
        $banners = $this->model->where('status','=',1)->limit(10)->orderBy('updated_at','desc')->get();
        $this->resetModel();
        return $banners;
    }
}
