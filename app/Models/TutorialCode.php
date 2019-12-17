<?php

namespace App\Models;

use Eloquent as Model;

class TutorialCode extends Model
{
    public $table = 'tutorial_codes';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'code',
        'start_date',
        'end_date',
        'tutorial_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'code' => 'string',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'tutorial_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'required',
        'start_date'=>'required',
        'end_date'=>'required'
    ];

    public function tutorial()
    {
        return $this->belongsTo(\App\Models\Tutorial::class, 'tutorial_id', 'id');
    }

//    public static function attributes() {
//        return  [
//            'code' => trans('messages.banner_image'),
//            'start_date' => trans('messages.banner_name'),
//            'end_date' => trans('messages.banner_url'),
//        ];
//    }
}
