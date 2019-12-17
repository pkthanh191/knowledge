<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Test extends Model
{
//    use SoftDeletes;
    use Sluggable;

    public $table = 'tests';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'short_description',
        'description',
        'slug',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'comment_counts',
        'view_counts',
        'duration',
        'image',
        'file',
        'short_file',
        'link_download',
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
        'slug' => 'string',
        'meta_title' => 'string',
        'meta_keywords' => 'string',
        'meta_description' => 'string',
        'comment_counts' => 'integer',
        'view_counts' => 'integer',
        'duration' => 'integer',
        'image' => 'string',
        'file' => 'string',
        'short_file' => 'string',
        'link_download' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|min:3|max:255',
        'meta_description'=>'max:255',
        'meta_title'=>'required|min:3|max:255',
        'meta_keywords'=>'max:255',
        'duration' => 'min:0',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        'file' => 'file',
        'short_file' => 'file',
        'link_download' => 'nullable|url'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    public static function attributes() {
        return  [
            'image' => trans('messages.test_image'),
            'name' => trans('messages.test_name'),
            'meta_title' => trans('messages.meta_title'),
            'meta_description' => trans('messages.meta_description'),
            'meta_keywords' => trans('messages.meta_keywords'),
            'image' => trans('messages.test_image'),
            'file' => trans('messages.test_file'),
            'short_file' => trans('messages.test_short_file'),
            'link_download' => trans('messages.test_link_down')
        ];
    }


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

//    public function parent() {
//        return $this->belongsTo('App\Models\CategoryTest', 'parent_id');
//    }
//
//    public function children($columns = ['*'])
//    {
//        return $this->hasMany('App\Models\CategoryTest', 'parent_id')->get($columns);
//    }
    public function categories()
    {
        return $this->belongsToMany('App\Models\CategoryTest', 'test_categories', 'test_id', 'category_test_id');
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\CommentTest::class)->where('comment_tests.parent_id', '=', '0');
    }

    public function commentsByUpdated()
    {
        return $this->hasMany(\App\Models\CommentTest::class)->where('parent_id', '=', '0')->orderBy('updated_at', 'desc');
    }

    public function lastestComment()
    {
        return $this->hasOne(\App\Models\CommentTest::class,'test_id', 'id')->orderBy('created_at','desc');
    }
}
