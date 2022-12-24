<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Overtime",
 *      required={"employee_id", "shiftment_id", "overtime_date", "start_hour", "end_hour", "raw_value", "calculated_value", "holiday", "overday"},
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
class Overtime extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'overtimes';
    protected $hidden = ['raw_calculated_value'];
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];
    private $startValidOvertimeDate;
    private $endValidOvertimeDate;

    public $fillable = [
        'employee_id',
        'shiftment_id',
        'approved_by_id',
        'overtime_date',
        'start_hour',
        'end_hour',
        'breaktime_value',
        'start_hour_real',
        'end_hour_real',
        'raw_value',
        'calculated_value',
        'holiday',
        'overday',
        'amount',
        'description'
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
        'approved_by_id' => 'integer',
        'overtime_date' => 'date:Y-m-d',
        'raw_value' => 'float',
        'calculated_value' => 'float',
        'holiday' => 'boolean',
        'overday' => 'boolean',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'employee_id' => 'required',
        'shiftment_id' => 'nullable',
        'approved_by_id' => 'nullable',
        'overtime_date' => 'required',
        'start_hour' => 'required',
        'end_hour' => 'required',
        'start_hour_real' => 'nullable',
        'end_hour_real' => 'nullable',
        // 'raw_value' => 'required|numeric',
        // 'calculated_value' => 'required|numeric',
        'holiday' => 'required|boolean',
        'overday' => 'required|boolean',
        'description' => 'nullable|string|max:255'
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
    public function approvedBy()
    {
        return $this->belongsTo(\App\Models\Hr\Employee::class, 'approved_by_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function employee()
    {
        return $this->belongsTo(\App\Models\Hr\Employee::class, 'employee_id');
    }

    public function benefit(){
        return $this->hasOneThrough(\App\Models\Hr\SalaryBenefit::class, \App\Models\Hr\Employee::class, 'id', 'employee_id', 'employee_id')->overtime();
    }

    public function getOvertimeDateAttribute($value){
        return localFormatDate($value);
    }

    public function getAmountAttribute($value){
        return localNumberFormat($value, 0);
    }

    public function isSundayOvertime(){
        return Carbon::parse($this->attributes['overtime_date'])->dayOfWeek == Carbon::SUNDAY;
    }

    public function getRawStartHourDate(){
        $validDate = $this->startValidOvertimeDate ?? $this->attributes['overtime_date'];
        return $validDate.' '.$this->attributes['start_hour'];
    }    

    public function getRawEndHourDate(){
        // if($this->attributes['overday']){
        //     return Carbon::parse($this->attributes['overtime_date'])->addDay()->format('Y-m-d').' '.$this->attributes['end_hour'];    
        // }
        $validDate = $this->endValidOvertimeDate ?? $this->attributes['overtime_date'];
        return $validDate.' '.$this->attributes['end_hour'];
    }
    
    public function setValidOvertimeDate(Workshift $workshift){        
        // contoh lembur jam 22:00 sd 00:00 baik shift 2 (lembur akhir)  maupun shift 3 (lembur awal)
        if($this->attributes['start_hour'] > $this->attributes['end_hour']){
            $this->endValidOvertimeDate = Carbon::parse($this->attributes['overtime_date'])->addDay()->format('Y-m-d');            
        }
        // case awal lembur mulai jam 12 malam
        if($this->attributes['start_hour'] == '00:00:00'){
            $this->endValidOvertimeDate = Carbon::parse($this->attributes['overtime_date'])->addDay()->format('Y-m-d');
            $this->startValidOvertimeDate = $this->endValidOvertimeDate;
        }
        // jam kerja 00:00 sd 04:00
        // contoh lembur 20:00 sd 23:00
        // contoh lembur 04:00 sd 08:00
        // lembur akhir atau ditengah shift 3
        if($workshift->isEndOverDay()){
            // contoh lembur 20:00 sd 23:00
            // kemungkinan lembur akhir, maka overtime_date + 1
            if($this->attributes['start_hour'] > '12:00'){
                $this->endValidOvertimeDate = $this->attributes['overtime_date'];
            }else{
                $this->endValidOvertimeDate = Carbon::parse($this->attributes['overtime_date'])->addDay()->format('Y-m-d');
            }
            // kemungkinan lembur awal, maka overtime                
            if($this->attributes['start_hour'] < $this->attributes['end_hour']){
                $this->startValidOvertimeDate = $this->endValidOvertimeDate;
            }            
        }
    }
}
