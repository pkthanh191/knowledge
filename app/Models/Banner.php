<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Banner",
 *      required={"name"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="image",
 *          description="image",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="url",
 *          description="url",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="position",
 *          description="position",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          description="status",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Banner extends Model
{
    //use SoftDeletes;

    public $table = 'banners';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'image',
        'url',
        'description',
        'position',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'url' => 'string',
        'description' => 'string',
        'position' => 'integer',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'url'=>'nullable|url',
        'image'=>'required|image',
        'description' => 'max:65355'

    ];

    public static $rulesUpdate = [
        'name' => 'required',
        'url'=>'nullable|url',
        'description' => 'max:65355',
        'image' => 'image',
    ];

    public static function attributes() {
        return  [
            'image' => trans('messages.banner_image'),
            'name' => trans('messages.banner_name'),
            'url' => trans('messages.banner_url'),
            'description' => trans('messages.banner_description')
        ];
    }
}
