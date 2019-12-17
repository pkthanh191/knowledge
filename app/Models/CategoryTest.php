<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class CategoryTest extends Model
{
    //use SoftDeletes;

    public $table = 'category_tests';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'description',
        'parent_id',
        'orderSort',
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
        'description' => 'string',
        'parent_id' => 'integer',
        'orderSort' => 'integer',
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

    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public static $rules = [
        'name' => 'required|min:3|max:255',
        'orderSort' => 'required|numeric|min:0',
        'meta_description'=>'max:255',
        'meta_title'=>'required|min:3|max:255',
        'meta_keywords'=>'max:255',
    ];

    public static function attributes() {
        return  [
            'name' => trans('messages.category_test_name'),
            'orderSort' => trans('messages.category_test_orderSort'),
            'meta_title' => trans('messages.meta_title'),
            'meta_description' => trans('messages.meta_description'),
            'meta_keywords' => trans('messages.meta_keywords')
        ];
    }

    public function parent() {
        return $this->belongsTo('App\Models\CategoryTest', 'parent_id');
    }

    public function children($columns = ['*'])
    {
        return $this->hasMany('App\Models\CategoryTest', 'parent_id')->orderBy('orderSort','asc')->orderBy('updated_at','desc')->get($columns);
    }

    public function user(){
        return $this->belongsTo(\App\User::class,'user_id','id');
    }

    public function test()
    {
        return $this->belongsToMany('App\Models\Test', 'test_categories', 'category_test_id', 'test_id');
    }

}
