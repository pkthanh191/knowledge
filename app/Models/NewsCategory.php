<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsCategory extends Model
{
    //use SoftDeletes;

    public $table = 'news_categories';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'category_news_id',
        'news_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'category_news_id' => 'integer',
        'news_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
}
