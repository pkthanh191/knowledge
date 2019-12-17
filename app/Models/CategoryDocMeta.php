<?php

namespace App\Models;

use App\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryDocMeta extends Model
{
    //use SoftDeletes;

    public $table = 'category_doc_metas';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'description',
        'slug',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'slug' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'description' => 'max:65535'
    ];

    public static function attributes() {
        return  [
            'name' => trans('messages.category_doc_metas_name'),
            'description' => trans('messages.category_doc_metas_description'),
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    use Sluggable;

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

    public function metas()
    {
        return $this->hasMany(\App\Models\DocumentMeta::class, 'category_doc_meta_id', 'id');
    }
}
