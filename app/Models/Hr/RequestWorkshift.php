<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use App\Traits\ApprovalModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="RequestWorkshift",
 *      required={"employee_id", "shiftment_id", "shiftment_id_origin", "work_date"},
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
 *          property="shiftment_id_origin",
 *          description="shiftment_id_origin",
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
 *          property="status",
 *          description="status",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      )
 * )
 */
class RequestWorkshift extends Model
{
    use HasFactory;
    use SoftDeletes;
    use ApprovalModelTrait;
    public $table = 'request_workshifts';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const INITIAL_STATE = 'A';
    const APPROVE_STATE = 'A';

    protected $dates = ['deleted_at'];
    // protected $appends =  ['approve'];


    public $fillable = [
        'employee_id',
        'shiftment_id',
        'shiftment_id_origin',
        'work_date',
        'start_hour',
        'end_hour',
        'status',
        'step_approval',
        'amount_approval',
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
        'shiftment_id_origin' => 'integer',
        'work_date' => 'date',
        'start_hour' => 'datetime',
        'end_hour' => 'datetime',
        'status' => 'string',
        'step_approval' => 'integer',
        'amount_approval' => 'integer',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'employee_id' => 'required',
        'shiftment_id' => 'required',
        // 'shiftment_id_origin' => 'required',
        'work_date' => 'required',
        // 'status' => 'nullable|string|max:2',
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
    public function employee()
    {
        return $this->belongsTo(\App\Models\Hr\Employee::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function shiftmentOrigin()
    {
        return $this->belongsTo(\App\Models\Hr\Shiftment::class, 'shiftment_id_origin');
    }

    public function scopeApprove($query){
        return $query->whereStatus(self::APPROVE_STATE);
    }

    public function isApprove(){
        return $this->attributes['status'] == self::APPROVE_STATE;
    }

    public function getWorkDateAttribute($value){
        return localFormatDate($value);
    }

    // public function getApproveAttribute($value){
    //     return self::APPROVE_STATE;
    // }

    public function getStartHourAttribute($value){
        return localFormatDateTime($value);
    }

    public function getEndHourAttribute($value){
        return localFormatDateTime($value);
    }
}
