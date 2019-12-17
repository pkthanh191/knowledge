<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class News extends Model
{
//    use SoftDeletes;
    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public $table = 'news';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'short_description',
        'description',
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
        'slug' => 'string',
        'image' => 'string',
        'user_id' => 'integer',
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
        'name' => 'required|max:500|min:3',
        'meta_title' => 'required|max:255|min:3',
        'meta_keywords' => 'max:255',
        'meta_description' => 'max:255',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
    ];

    public static function attributes() {
        return  [
            'image' => trans('messages.news_image'),
            'name' => trans('messages.news'),
            'meta_title' => trans('messages.meta_title'),
            'description' => trans('messages.news_description'),
            'meta_keywords' => trans('messages.meta_keywords'),
            'meta_description' => trans('messages.meta_description')
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\CategoryNews', 'news_categories', 'news_id', 'category_news_id');
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\CommentNews::class)->where('parent_id', '=', '0');
    }

    public function commentsByUpdated()
    {
        return $this->hasMany(\App\Models\CommentNews::class)->where('parent_id', '=', '0')->orderBy('updated_at', 'desc');
    }

    public function lastestComment()
    {
        return $this->hasOne(\App\Models\CommentNews::class,'news_id', 'id')->orderBy('created_at','desc');
    }
}
