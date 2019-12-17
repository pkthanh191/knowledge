<?php

namespace App\Repositories;

use App\Models\Document;
use Illuminate\Support\Facades\DB;

class DocumentRepository extends BGBaseRepository
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
        return Document::class;
    }

    public function result($pageSize) {
        $documents = $this->model->inRandomOrder()->paginate($pageSize);
        $this->resetModel();
        return $documents;
    }

    public function search($where, $categoryId = null)
    {
        $this->applyConditions($where);
        if (!empty($categoryId)) {
            $documents = $this->model->with('categories')->join('document_categories', function ($join) {
                $join->on('documents.id', '=', 'document_categories.document_id');
            })->where('document_categories.category_id', $categoryId)->whereNull('document_categories.deleted_at');
        } else {
            $documents = $this->model->with('categories');
        }

        $this->resetModel();
        return $documents;
    }

    public function getDocumentsByCategorySlug($categorySlug = null, $name = null)
    {
        $documents = null;
        if (empty($categorySlug)) {
            $documents = $this->model->where('name', 'LIKE', '%' . $name . '%')->whereHas('categories')->inRandomOrder()->paginate(18);
        } else {
            $documents = $this->model->with('categories')->join('document_categories', function ($join) {
                $join->on('documents.id', '=', 'document_categories.document_id');
            })->join('category_docs', function ($join) {
                $join->on('category_docs.id', '=', 'document_categories.category_id');
            })->where(function ($q) use ($name) {
                $q->where('documents.name', 'LIKE', '%' . $name . '%');
            })->where('category_docs.slug', $categorySlug)->whereNull('document_categories.deleted_at')->paginate(18, ['documents.*']);
        }

        $this->resetModel();
        return $documents;
    }

    public function getRelatives($document)
    {
        $documents = $this->model->with('categories')->join('document_categories', function ($join) {
            $join->on('documents.id', '=', 'document_categories.document_id');
        })->where('documents.id', '!=', $document->id)->limit(10)->get(['documents.*']);

        $this->resetModel();
        return $documents;
    }

    public function getByDocMeta($docMeta)
    {
        $documents = $this->model->join('document_meta_values', function ($join) {
            $join->on('documents.id', '=', 'document_meta_values.doc_id');
        })->where('document_meta_values.doc_meta_id', '=', $docMeta->id);

        $this->resetModel();
        return $documents;
    }

    public function getDocumentByUser($user)
    {
        $documents = $this->model->join('comments', function ($join) {
            $join->on('documents.id', '=', 'comments.document_id');
        })->where('comments.user_id', '=', $user)->distinct()->get(['documents.*']);
        $this->resetModel();
        return $documents;
    }

    public function getDocumentByComment($category_id = null)
    {
        if ($category_id == null) {
            $documents = $this->model->join('comments', function ($join) {
                $join->on('documents.id', '=', 'comments.document_id');
            })->distinct()->orderBy('updated_at', 'desc')->get(['documents.*']);
        } else {
            $documents = $this->model->join('comments', function ($join) {
                $join->on('documents.id', '=', 'comments.document_id');
            })->join('document_categories', function ($join) {
                $join->on('documents.id', '=', 'document_categories.document_id');
            })->where('document_categories.category_id', '=', $category_id)->distinct()->orderBy('updated_at', 'desc')->get(['documents.*']);
        }

        $this->resetModel();
        return $documents;
    }

    public function getDocUndefinedMeta()
    {
        $documents = $this->model->whereNotIn('id', function ($q){
            $q->select('documents.id')->from('documents')->distinct()->join('document_meta_values', 'documents.id','document_meta_values.doc_id');
        })->get();
        return $documents;
    }
}
