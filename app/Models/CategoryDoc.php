<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class CategoryDoc extends Model
{
    //use SoftDeletes;
    use Sluggable;

    public $table = 'category_docs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'orderSort',
        'description',
        'parent_id',
        'slug',
        'meta_title',
        'meta_keywords',
        'meta_description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'orderSort' => 'integer',
        'description' => 'string',
        'parent_id' => 'integer',
        'slug' => 'string',
        'meta_title' => 'string',
        'meta_keywords' => 'string',
        'meta_description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:255',
        'slug' => 'max:255',
        'orderSort' => 'required|numeric|min:0',
        'meta_title' => 'required|max:255',
        'meta_keywords' => 'max:255',
        'meta_description' => 'max:255',
        'description' => 'max:64000'
    ];

    public static function attributes() {
        return  [
            'name' => trans('messages.category_doc_name'),
            'orderSort' => trans('messages.category_doc_orderSort'),
            'meta_title' => trans('messages.meta_title'),
            'meta_keywords' => trans('messages.meta_keywords'),
            'meta_description' => trans('messages.meta_description'),
            'description' => trans('messages.category_doc_description'),
        ];
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => ['source' => 'name']
        ];
    }

    public function parent() {
        return $this->belongsTo('App\Models\CategoryDoc', 'parent_id');
    }

    public function children($columns = ['*'])
    {
        return $this->hasMany('App\Models\CategoryDoc', 'parent_id')->orderBy('orderSort','asc')->orderBy('updated_at','desc')->get($columns);
    }

    public function documents()
    {
        return $this->belongsToMany('App\Models\Document', 'document_categories', 'category_id', 'document_id');
    }

}
