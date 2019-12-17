<?php

namespace App\Repositories;

use App\Models\DocumentMetaValue;

class DocumentMetaValueRepository extends BGBaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'value'
    ];

    /**
     * Configure the Model
     **/
    public function BGModel()
    {
        return DocumentMetaValue::class;
    }

}
