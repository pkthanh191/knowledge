<?php

namespace App\Models;

use App\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Document extends Model
{
    //use SoftDeletes;
    use Sluggable;

    public $table = 'documents';


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
        'image',
        'file',
        'link_download',
        'user_id',
        'short_file',
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
        'image' => 'string',
        'file' => 'string',
        'link_download' => 'string',
        'user_id' => 'integer',
        'short_file' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'meta_title' => 'required',
        'meta_description' => 'max:255',
        'meta_keywords' => 'max:255',
        'description' => 'max:65535',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        'file' => 'file',
        'short_file' => 'file',
        'link_download' => 'nullable|url',
    ];

    public static function attributes() {
        return  [
            'name' => trans('messages.document_name'),
            'meta_title' => trans('messages.meta_title'),
            'meta_keywords' => trans('messages.meta_keywords'),
            'meta_description' => trans('messages.meta_description'),
            'image' => trans('messages.document_image'),
            'file' => trans('messages.document_file'),
            'short_file' => trans('messages.document_short_file'),
            'link_download' => trans('messages.document_link_download'),
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => ['source' => 'name']
        ];
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class)->where('comments.parent_id', '=', '0');
    }

    public function commentsByUpdated()
    {
        return $this->hasMany(\App\Models\Comment::class)->where('comments.parent_id', '=', '0')->orderBy('updated_at', 'desc');
    }

    public function lastestComment()
    {
        return $this->hasOne(\App\Models\Comment::class,'document_id', 'id')->orderBy('created_at','desc');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\CategoryDoc', 'document_categories', 'document_id', 'category_id');
    }
}
