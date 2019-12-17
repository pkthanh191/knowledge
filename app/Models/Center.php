<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Center extends Model
{
    //use SoftDeletes;
    use Sluggable;

    public $table = 'centers';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'short_description',
        'description',
        'address',
        'phone',
        'email',
        'slug',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'image',
        'user_id'
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
        'address' => 'string',
        'phone' => 'string',
        'email' => 'string',
        'slug' => 'string',
        'meta_title' => 'string',
        'meta_keywords' => 'string',
        'meta_description' => 'string',
        'image' => 'string',
        'user_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|min:3|max:255',
        'address' => 'max:255',
        'email' => 'required|max:255|email|unique:centers',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        'phone' => array('required', 'unique:centers','regex:/^(09)[0-9]{8}$|^(03)[0-9]{8}$|^(05)[0-9]{8}$|^(07)[0-9]{8}$|^(08)[0-9]{8}$/'),
        'short_description' => 'max:30000',
        'description' => 'max:65355',
        'meta_title' => 'required|min:3|max:255',
        'meta_keywords' => 'max:255',
        'meta_description' => 'max:255',
    ];

    public static function attributes() {
        return  [
            'name' => trans('messages.center_name'),
            'address' => trans('messages.center_address'),
            'email' => trans('messages.center_email'),
            'image' => trans('messages.center_image'),
            'phone' => trans('messages.center_phone'),
            'short_description' => trans('messages.center_short_description'),
            'description' => trans('messages.center_description'),
            'meta_title' => trans('messages.meta_title'),
            'meta_keywords' => trans('messages.meta_keywords'),
            'meta_description' => trans('messages.meta_description'),
        ];
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }


    public function teachers()
    {
        return $this->hasMany(\App\Models\Teacher::class);
    }

    //Slug
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
