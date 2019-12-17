<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class CategoryCourse extends Model
{
//    use SoftDeletes;
    use Sluggable;

    public $table = 'category_courses';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'orderSort',
        'description',
        'category_course_type',
        'slug',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'user_id',
        'parent_id'
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
        'category_course_type' => 'integer',
        'slug' => 'string',
        'user_id' => 'integer',
        'parent_id' => 'integer',
        'meta_title' => 'string',
        'meta_keywords' => 'string',
        'meta_description' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:255',
        'orderSort' => 'required|numeric|min:0',
//        'description' => 'max:20000',
        'category_course_type' => 'required|not_in:0',
        'meta_title' => 'required|max:255',
        'meta_keywords' => 'max:255',
        'meta_description' => 'max:255',
    ];

    public static function attributes() {
        return  [
            'name' => trans('messages.category_course_name'),
            'orderSort' => trans('messages.category_course_orderSort'),
            'description' => trans('messages.news_description'),
            'category_course_type' => trans('messages.category_course_type'),
            'meta_title' => trans('messages.meta_title'),
            'meta_keywords' => trans('messages.meta_keywords'),
            'meta_description' => trans('messages.meta_description')
        ];
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];

    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    public function parent() {
        return $this->belongsTo('App\Models\CategoryCourse', 'parent_id');
    }

    public function children($columns = ['*'])
    {
        return $this->hasMany('App\Models\CategoryCourse', 'parent_id')->orderBy('orderSort','asc')->orderBy('updated_at','desc')->get($columns);
    }

    public function courses()
    {
        return $this->belongsToMany('App\Models\Course', 'course_categories', 'category_course_id', 'course_id');
    }
}
