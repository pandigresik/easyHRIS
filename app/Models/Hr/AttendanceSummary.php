<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="AttendanceSummary",
 *      required={"year", "month", "total_workday", "total_in", "total_loyality", "total_absent", "total_overtime"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="type",
 *          description="type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="code",
 *          description="code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      )
 * )
 */
class AttendanceSummary extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'attendance_summaries';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'employee_id',
        'year',
        'month',
        'total_workday',
        'total_in',
        'total_loyality',
        'total_absent',
        'total_overtime'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'year' => 'integer',
        'month' => 'integer',
        'total_workday' => 'integer',
        'total_in' => 'integer',
        'total_loyality' => 'integer',
        'total_absent' => 'integer',
        'total_overtime' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'employee_id' => 'nullable',
        'year' => 'required',
        'month' => 'required',
        'total_workday' => 'required|integer',
        'total_in' => 'required|integer',
        'total_loyality' => 'required|integer',
        'total_absent' => 'required|integer',
        'total_overtime' => 'required|integer'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function employee()
    {
        return $this->belongsTo(\App\Models\Hr\Employee::class, 'employee_id');
    }
}
