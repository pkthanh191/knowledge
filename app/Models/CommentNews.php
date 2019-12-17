<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentNews extends Model
{
//    use SoftDeletes;

    public $table = 'comment_news';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'content',
        'parent_id',
        'user_id',
        'news_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'content' => 'string',
        'parent_id' => 'integer',
        'user_id' => 'integer',
        'news_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'content' => 'required'
    ];

    public static function attributes() {
        return  [
            'content' => trans('messages.comment_news_content')
        ];
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function news()
    {
        return $this->belongsTo(\App\Models\News::class, 'news_id', 'id');
    }

    public function children($columns = ['*'])
    {
        return $this->hasMany('App\Models\CommentNews', 'parent_id')->get($columns);
    }

    public function child()
    {
        return $this->hasMany('App\Models\CommentNews', 'parent_id');
    }

    public function parent() {
        return $this->belongsTo('App\Models\CommentNews', 'parent_id');
    }
}
