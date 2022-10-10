<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Attendance",
 *      required={"attendance_date", "early_in", "early_out", "late_in", "late_out", "absent"},
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
class Attendance extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'attendances';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'employee_id',
        'shiftment_id',
        'reason_id',
        'attendance_date',
        'description',
        'check_in',
        'check_out',
        'early_in',
        'early_out',
        'late_in',
        'late_out',
        'absent'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'shiftment_id' => 'integer',
        'reason_id' => 'integer',
        'attendance_date' => 'date',
        'description' => 'string',
        'early_in' => 'integer',
        'early_out' => 'integer',
        'late_in' => 'integer',
        'late_out' => 'integer',
        'absent' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'employee_id' => 'nullable',
        'shiftment_id' => 'nullable',
        'reason_id' => 'nullable',
        'attendance_date' => 'required',
        'description' => 'nullable|string|max:255',
        'check_in' => 'nullable',
        'check_out' => 'nullable',
        'early_in' => 'required|integer',
        'early_out' => 'required|integer',
        'late_in' => 'required|integer',
        'late_out' => 'required|integer',
        'absent' => 'required|boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function shiftment()
    {
        return $this->belongsTo(\App\Models\Hr\Shiftment::class, 'shiftment_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function reason()
    {
        return $this->belongsTo(\App\Models\Hr\AbsentReason::class, 'reason_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function employee()
    {
        return $this->belongsTo(\App\Models\Hr\Employee::class, 'employee_id');
    }
}
