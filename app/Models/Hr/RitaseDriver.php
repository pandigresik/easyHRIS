<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="RitaseDriver",
 *      required={"employee_id", "work_date", "km", "double_rit"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="employee_id",
 *          description="employee_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="work_date",
 *          description="work_date",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="km",
 *          description="km",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="double_rit",
 *          description="double_rit",
 *          type="boolean"
 *      )
 * )
 */
class RitaseDriver extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'ritase_drivers';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'employee_id',
        'work_date',
        'km',
        'double_rit'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'work_date' => 'date:Y-m-d',
        'km' => 'integer',
        'double_rit' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'employee_id' => 'required',
        'work_date' => 'required',
        'km' => 'required',
        'double_rit' => 'required|numeric'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function employee()
    {
        return $this->belongsTo(\App\Models\Hr\Employee::class, 'employee_id');
    }

    public function getWorkDateAttribute($value){
        return localFormatDate($value);
    }
}
