<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    //use SoftDeletes;

    public $table = 'comments';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'content',
        'parent_id',
        'user_id',
        'document_id'
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
        'document_id' => 'integer'
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
            'content' => trans('messages.comments_content')
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
    public function document()
    {
        return $this->belongsTo(\App\Models\Document::class, 'document_id', 'id');
    }

    public function parent() {
        return $this->belongsTo('App\Models\Comment', 'parent_id');
    }

    public function children($columns = ['*'])
    {
        return $this->hasMany('App\Models\Comment', 'parent_id')->get($columns);
    }

    public function child()
    {
        return $this->hasMany('App\Models\Comment', 'parent_id');
    }
}
