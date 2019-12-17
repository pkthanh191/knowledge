<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'group_id','avatar','age','sex','phone','address', 'account_balance', 'actived', 'social_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static $rules = [
        'name' => 'required|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'phone' => array('required', 'regex:/^(09)[0-9]{8}$|^(03)[0-9]{8}$|^(05)[0-9]{8}$|^(07)[0-9]{8}$|^(08)[0-9]{8}$/', 'unique:users'),
        'password'=>'required|min:6',
        'group_id'=>'required|not_in:0',
        'account_balance'=>'required|numeric|min:0',
        'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        'age'=>'max:100',
    ];

    public static $rules_update = [
        'name' => 'required|max:255',
        'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        'age'=>'nullable|numeric|min:1|max:200',
    ];

    public static function attributes() {
        return  [
            'name' => __('messages.user_name'),
            'phone' => __('messages.user_phone'),
            'email' => __('messages.user_email'),
            'password' => __('messages.user_password'),
            'group_id' => __('messages.user_group'),
            'account_balance' => __('messages.user_account_balance'),
            'age' => __('messages.user_age'),
            'sex' => __('messages.user_sex'),
            'avatar' => __('messages.user_avatar'),
        ];
    }
}
