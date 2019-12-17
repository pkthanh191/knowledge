<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Validation\Rule;

class Teacher extends Model
{
//    use SoftDeletes;
    use Sluggable;



    public $table = 'teachers';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'description',
        'address',
        'phone',
        'email',
        'slug',
        'feature',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'image',
        'user_id',
        'center_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'address' => 'string',
        'phone' => 'string',
        'email' => 'string',
        'slug' => 'string',
        'feature' => 'integer',
        'meta_title' => 'string',
        'meta_keywords' => 'string',
        'meta_description' => 'string',
        'image' => 'string',
        'user_id' => 'integer',
        'center_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:255',
        'email' =>  'required|email|unique:teachers',
        'address' => 'max:255',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        'phone' => array('required', 'unique:teachers', 'regex:/^(09)[0-9]{8}$|^(03)[0-9]{8}$|^(05)[0-9]{8}$|^(07)[0-9]{8}$|^(08)[0-9]{8}$/'),
        'meta_title' => 'required|max:255',
        'meta_keywords' => 'max:255',
        'meta_description' => 'max:255',
    ];

    public static function attributes() {
        return  [
            'name' => trans('messages.teacher_name'),
            'address' => trans('messages.teacher_address'),
            'image' => trans('messages.teacher_image'),
            'phone' => trans('messages.teacher_phone'),
            'email' => trans('messages.teacher_email'),
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

    public function center()
    {
        return $this->belongsTo(\App\Models\Center::class, 'center_id', 'id');
    }

    public function courses()
    {
        return $this->hasMany(\App\Models\Course::class);
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
