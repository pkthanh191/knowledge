<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentMetaValue extends Model
{
    //use SoftDeletes;

    public $table = 'document_meta_values';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'doc_id',
        'doc_meta_id',
        'value'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'doc_id' => 'integer',
        'doc_meta_id' => 'integer',
        'value' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'value' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function document()
    {
        return $this->belongsTo(\App\Models\Document::class, 'doc_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function documentMeta()
    {
        return $this->belongsTo(\App\Models\DocumentMeta::class, 'doc_meta_id', 'id');
    }
}
