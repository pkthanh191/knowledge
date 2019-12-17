<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentTest extends Model
{
    //use SoftDeletes;

    public $table = 'comment_tests';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'content',
        'parent_id',
        'user_id',
        'test_id'
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
        'test_id' => 'integer'
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
            'content' => trans('messages.comment_tests_content')
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
    public function test()
    {
        return $this->belongsTo(\App\Models\Test::class, 'test_id', 'id');
    }

    public function parent() {
        return $this->belongsTo('App\Models\CommentTest', 'parent_id');
    }

    public function children($columns = ['*'])
    {
        return $this->hasMany('App\Models\CommentTest', 'parent_id')->get($columns);
    }

    public function child()
    {
        return $this->hasMany('App\Models\CommentTest', 'parent_id');
    }
}
