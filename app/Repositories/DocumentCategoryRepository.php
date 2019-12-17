<?php

namespace App\Repositories;

use App\Models\DocumentCategory;
use InfyOm\Generator\Common\BaseRepository;

class DocumentCategoryRepository extends BGBaseRepository
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
        return DocumentCategory::class;
    }
}
