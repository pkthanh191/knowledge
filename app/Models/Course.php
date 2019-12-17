<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Course extends Model
{
//    use SoftDeletes;
    use Sluggable;

    public $table = 'courses';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'short_description',
        'description',
        'start_date',
        'end_date',
        'duration',
        'cost',
        'slug',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'user_id',
        'center_id',
        'image',
        'teacher_id',
        'comment_counts',
        'view_counts'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'short_description' => 'string',
        'description' => 'string',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'duration' => 'string',
        'cost' => 'integer',
        'slug' => 'string',
        'meta_title' => 'string',
        'meta_keywords' => 'string',
        'meta_description' => 'string',
        'user_id' => 'integer',
        'center_id' => 'integer',
        'image' => 'string',
        'teacher_id' => 'integer',
        'comment_counts'=>'integer',
        'view_counts'=>'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:255|min:3',
        'meta_title' => 'required|max:255|min:3',
        'short_description' => 'max:255',
        'description' => 'max:22248',
        'meta_keywords' => 'max:255',
        'meta_description' => 'max:255',
        'teacher_id'=> 'required',
        'center_id' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        'duration' => 'nullable|numeric|min:0',
    ];

    public static function attributes() {
        return  [
            'name' => trans('messages.course_name'),
            'meta_title' => trans('messages.meta_title'),
            'short_description' => trans('messages.course_short_description'),
            'description' => trans('messages.course_description'),
            'meta_keywords' => trans('messages.meta_title'),
            'teacher_id' => trans('messages.course_teacher'),
            'center_id' => trans('messages.course_center'),
            'image' => trans('messages.course_image'),
            'duration' => trans('messages.course_duration'),
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function center()
    {
        return $this->belongsTo(\App\Models\Center::class, 'center_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function teacher()
    {
        return $this->belongsTo(\App\Models\Teacher::class, 'teacher_id', 'id');
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
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     **/
    public function categories()
    {
        return $this->belongsToMany('App\Models\CategoryCourse','course_categories','course_id','category_course_id');
    }

}
