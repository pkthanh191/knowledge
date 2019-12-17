<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    //use SoftDeletes;

    public $table = 'transactions';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'money_transfer',
        'content',
        'status',
        'user_id',
        'trans_id',
        'trans_type',
        'trans_status',
        'trans_email',
        'trans_phone',
        'trans_payment_name',
        'trans_fee',
        'trans_card_type',
        'real_value',
        'document_id',
        'test_id',
        'tutorial_id',
        'description',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'money_transfer' => 'string',
        'content' => 'integer',
        'status' => 'integer',
        'user_id' => 'integer',
        'trans_id' => 'integer',
        'trans_type' => 'integer',
        'trans_status' => 'integer',
        'trans_email' => 'string',
        'trans_phone' => 'string',
        'trans_payment_name' => 'string',
        'trans_fee' => 'integer',
        'trans_card_type' => 'string',
        'real_value' => 'integer',
        'document_id' => 'integer',
        'test_id' => 'integer',
        'tutorial_id' => 'integer',
        'description' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'money_transfer' => 'required|numeric|min:0',
        'status' => 'required: not_in:0',
        'content' => 'required|not_in:0',
    ];

    /**
     * Validation attributes
     *
     * @return  array attributes
     */
    public static function attributes() {
        return  [
            'user_id' => __('messages.transactions_user'),
            'money_transfer' => trans('messages.transactions_money'),
            'status' => __('messages.transactions_status'),
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    public function document(){
        return $this->hasOne(\App\Models\Document::class, 'id', 'document_id');
    }
    public function test(){
        return $this->hasOne(\App\Models\Test::class, 'id', 'test_id');
    }
    public function tutorial(){
        return $this->hasOne(\App\Models\Tutorial::class, 'id', 'tutorial_id');
    }
}
