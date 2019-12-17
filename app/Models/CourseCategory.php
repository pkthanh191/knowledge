<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseCategory extends Model
{
    //use SoftDeletes;

    public $table = 'course_categories';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'category_course_id',
        'course_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'category_course_id' => 'integer',
        'course_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function categoryCourse()
    {
        return $this->belongsTo(\App\Models\CategoryCourse::class, 'category_course_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function course()
    {
        return $this->belongsTo(\App\Models\Course::class, 'course_id', 'id');
    }
}
