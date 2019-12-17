<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coefficient extends Model
{

    public $table = 'coefficients';
    
    public $fillable = [
        'apply_from',
        'apply_to',
        'cost_from',
        'cost_to',
        'coefficient',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'cost_from' => 'integer',
        'cost_to' => 'integer',
        'coefficient' => 'double',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'coefficient' => 'required'
    ];


    public static function attributes() {
        return  [
            'cost_from' => trans('messages.coefficients_cost_from'),
            'cost_to' => trans('messages.coefficients_cost_to'),
            'coefficient' => trans('messages.coefficient'),
        ];
    }
}
