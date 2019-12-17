<?php

namespace App\Repositories;

use App\Models\CategoryDocMeta;

class CategoryDocMetaRepository extends BGBaseRepository
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
        return CategoryDocMeta::class;
    }

    public function getAllCategoryHasDocMeta() {
        $categoryList = $this->model->has('metas')->get();

        $categories = array();
        $categories[0] = '-- '.__('messages.select_category_document_meta').' --';
        foreach ($categoryList as $category) {
            $categories[$category->id] = $category->name;
        }

        $this->resetModel();

        return $categories;
    }
}
