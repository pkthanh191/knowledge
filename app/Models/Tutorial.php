<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Tutorial extends Model
{
//    use SoftDeletes;

    use Sluggable;

    public $table = 'tutorials';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'phone',
        'email',
        'requirement',
        'period',
        'frequency',
        'salary',
        'active',
        'confirm',
        'slug',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'address',
        'district_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'phone' => 'string',
        'email' => 'string',
        'requirement' => 'string',
        'period' => 'string',
        'frequency' => 'integer',
        'salary' => 'string',
        'active' => 'integer',
        'confirm' => 'integer',
        'slug' => 'string',
        'meta_title' => 'string',
        'meta_keywords' => 'string',
        'meta_description' => 'string',
        'address' => 'string',
        'district_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'email' => 'nullable|max:255|email',
        'phone' => array('required', 'regex:/^(09)[0-9]{8}$|^(03)[0-9]{8}$|^(05)[0-9]{8}$|^(07)[0-9]{8}$|^(08)[0-9]{8}$/'),
        'active' => 'digits_between:0,1',
        'district_id' => 'required|not_in:0',
        'city_id' => 'required|not_in:0',
        'grades' => 'required|not_in:0',
        'subjects' => 'required:not_in:0',
        'frequency' => 'nullable|numeric|min:0',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function attributes()
    {
        return [
            'title' => __('messages.tutorials_title'),
            'phone' => __('messages.tutorials_phone'),
            'district_id' => __('messages.tutorials_district'),
            'city_id' => __('messages.tutorials_city'),
            'grades' => __('messages.tutorials_grade'),
            'subjects' => __('messages.tutorials_subject'),
            'meta_title' => __('messages.meta_title'),
            'frequency' => __('messages.tutorials_frequency'),
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function district()
    {
        return $this->belongsTo(\App\Models\District::class, 'district_id', 'id');
    }

    public function grades()
    {
        return $this->belongsToMany('App\Models\Grade', 'grade_tutorials', 'tutorial_id', 'grade_id')->withTimestamps();
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Models\Subject', 'subject_tutorials', 'tutorial_id', 'subject_id')->withTimestamps();
    }
}
