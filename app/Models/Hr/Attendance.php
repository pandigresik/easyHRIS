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
 *          property="employee_id",
 *          description="employee_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="shiftment_id",
 *          description="shiftment_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="reason_id",
 *          description="reason_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="attendance_date",
 *          description="attendance_date",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="check_in_schedule",
 *          description="check_in_schedule",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="check_out_schedule",
 *          description="check_out_schedule",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="check_in",
 *          description="check_in",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="check_out",
 *          description="check_out",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="early_in",
 *          description="early_in",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="early_out",
 *          description="early_out",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="late_in",
 *          description="late_in",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="late_out",
 *          description="late_out",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="absent",
 *          description="absent",
 *          type="boolean"
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
    const STATE = [
        'OK' => 'OK',
        'INVALID' => 'INVALID',
        'EARLYOUT' => 'EARLYOUT',
        'LATEIN' => 'LATEIN',
        'ABSENT' => 'ABSENT'
    ];

    protected $dates = ['deleted_at'];



    public $fillable = [
        'employee_id',
        'shiftment_id',
        'reason_id',
        'attendance_date',
        'description',
        'check_in_schedule',
        'check_out_schedule',
        'check_in',
        'check_out',
        'early_in',
        'early_out',
        'late_in',
        'late_out',
        'absent',
        'state'
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
        'check_in_schedule' => 'datetime',
        'check_out_schedule' => 'datetime',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'early_in' => 'integer',
        'early_out' => 'integer',
        'late_in' => 'integer',
        'late_out' => 'integer',
        'absent' => 'boolean',
        'state' => 'string'
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
        'check_in_schedule' => 'nullable',
        'check_out_schedule' => 'nullable',
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

    public function getAttendanceDateAttribute($value){
        return localFormatDate($value);
    }

    public function getCheckInAttribute($value){
        return localFormatDateTime($value);
    }

    public function getCheckOutAttribute($value){
        return localFormatDateTime($value);
    }

    public function scopeInvalid($query){
        return $query->where(['state' => 'INVALID']);
    }

    public function scopeAbsentLeaveLate($query){
        return $query->where(function($q){
            return $q->whereIn('state',['PC', 'DT', 'LATEIN', 'EARLYOUT', 'INVALID'])->orWhere('absent',0);
        });
    }

    public function scopeLuarKota($query){
        return $query->where('state', 'LK');
    }
}
