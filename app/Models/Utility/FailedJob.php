<?php

namespace App\Models\Utility;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="FailedJob",
 *      required={"connection", "queue", "payload", "exception", "failed_at"},
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
class FailedJob extends Model
{
    use HasFactory;        

    public $table = 'failed_jobs';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'connection',
        'queue',
        'payload',
        'exception',
        'failed_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'connection' => 'string',
        'queue' => 'string',
        'payload' => 'string',
        'exception' => 'string',
        'failed_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'connection' => 'required|string',
        'queue' => 'required|string',
        'payload' => 'required|string',
        'exception' => 'required|string',
        'failed_at' => 'required'
    ];

    
}
