<?php
namespace App\Models;

use Eloquent as Model;
class Config extends Model
{
    protected $fillable = [
        'code',
        'value'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'value' => 'required'
    ];
}