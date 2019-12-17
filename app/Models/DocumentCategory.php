<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentCategory extends Model
{
    //use SoftDeletes;

    public $table = 'document_categories';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'category_id',
        'document_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'category_id' => 'integer',
        'document_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     **/
//    public function categoryDoc()
//    {
//        return $this->belongsTo(\App\Models\CategoryDoc::class, 'category_id', 'id');
//    }
//
//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     **/
//    public function document()
//    {
//        return $this->belongsTo(\App\Models\Document::class, 'document_id', 'id');
//    }
}
