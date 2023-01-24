<?php

namespace App\Models\Utility;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="Job",
 *      required={"queue", "payload", "attempts", "available_at"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="queue",
 *          description="queue",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="payload",
 *          description="payload",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="attempts",
 *          description="attempts",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="reserved_at",
 *          description="reserved_at",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="available_at",
 *          description="available_at",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class Job extends Model
{
    use HasFactory;        

    protected $isCachable = false;
    public $table = 'jobs';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'queue',
        'payload',
        'attempts',
        'reserved_at',
        'available_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'queue' => 'string',
        'payload' => 'string',
        'attempts' => 'boolean',
        'reserved_at' => 'integer',
        'available_at' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'queue' => 'required|string|max:255',
        'payload' => 'required|string',
        'attempts' => 'required|boolean',
        'reserved_at' => 'nullable|integer',
        'available_at' => 'required|integer'
    ];

    
}
