<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

/**
 * @SWG\Definition(
 *      definition="Page",
 *      required={"name", "slug"},
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
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="slug",
 *          description="slug",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="meta_title",
 *          description="meta_title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="meta_keywords",
 *          description="meta_keywords",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="meta_description",
 *          description="meta_description",
 *          type="string"
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
class Page extends Model
{
//    use SoftDeletes;
    use Sluggable;
    public $table = 'pages';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'description',
        'slug',
        'meta_title',
        'meta_keywords',
        'meta_description'
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
        'meta_title' => 'string',
        'meta_keywords' => 'string',
        'meta_description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:255',
        'meta_title'=>'required|max:255',
    ];

    public static function attributes() {
        return  [
            'name' => trans('messages.static_pages_name'),
            'meta_title' => trans('messages.meta_title'),
            'meta_keywords' => trans('messages.meta_keywords'),
            'meta_description' => trans('messages.meta_description'),
        ];
    }


    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

}
