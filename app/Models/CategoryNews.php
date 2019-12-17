<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class CategoryNews extends Model
{
    //use SoftDeletes;
    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return ['slug' => ['source' => 'name']];
    }

    public $table = 'category_news';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'description',
        'slug',
        'orderSort',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'parent_id',
        'user_id'
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
        'slug' => 'string',
        'meta_title' => 'string',
        'meta_keywords' => 'string',
        'meta_description' => 'string',
        'parent_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:100|min:3',
        'orderSort' => 'required|numeric|min:0',
        'description' => 'max:5000',
        'meta_title' => 'required|max:100|min:3',
        'meta_keywords' => 'max:50',
        'meta_description' => 'max:100',
    ];

    public static function attributes() {
        return  [
            'name' => trans('messages.category_news'),
            'orderSort' => trans('messages.category_news_orderSort'),
            'description' => trans('messages.category_news_description'),
            'meta_title' => trans('messages.meta_title'),
            'meta_keywords' => trans('messages.meta_keywords'),
            'meta_description' => trans('messages.meta_description')
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    public function news()
    {
        return $this->belongsToMany('App\Models\News', 'news_categories', 'category_news_id', 'news_id');
    }

    public function parent() {
        return $this->belongsTo('App\Models\CategoryNews', 'parent_id');
    }

    public function children($columns = ['*'])
    {
        return $this->hasMany('App\Models\CategoryNews', 'parent_id')->orderBy('orderSort','asc')->orderBy('updated_at','desc')->get($columns);
    }
}
