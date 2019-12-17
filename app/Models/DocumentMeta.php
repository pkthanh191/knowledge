<?php

namespace App\Models;

use App\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentMeta extends Model
{
    //use SoftDeletes;

    public $table = 'document_metas';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'description',
        'user_id',
        'category_doc_meta_id',
        'orderSort'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'user_id' => 'integer',
        'category_doc_meta_id' => 'integer',
        'orderSort' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'description' => 'max:65535',
        'orderSort' => 'required|numeric|min:0',
    ];

    public static function attributes() {
        return  [
            'name' => trans('messages.document_meta_name'),
            'description' => trans('messages.document_meta_description'),
            'orderSort' => trans('messages.document_metas_orderSort'),
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function categoryDocMeta()
    {
        return $this->belongsTo(CategoryDocMeta::class, 'category_doc_meta_id', 'id');
    }
}
