<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use SoftDeletes;

    public $table = 'grades';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    public static function attributes() {
        return  [
            'name' => trans('messages.grades_name'),
        ];
    }

    public function tutorials()
    {
        return $this->belongsToMany('App\Models\Tutorial', 'grade_tutorials', 'grade_id', 'tutorial_id');
    }
}
