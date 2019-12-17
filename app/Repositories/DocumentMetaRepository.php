<?php

namespace App\Repositories;

use App\Models\DocumentMeta;

class DocumentMetaRepository extends BGBaseRepository
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
        return DocumentMeta::class;
    }

}
