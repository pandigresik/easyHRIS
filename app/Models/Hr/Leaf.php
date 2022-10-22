<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Leaf",
 *      required={"leave_start", "leave_end", "amount", "status", "step_approval", "amount_approval"},
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
 *          property="reason_id",
 *          description="reason_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="leave_start",
 *          description="leave_start",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="leave_end",
 *          description="leave_end",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="amount",
 *          description="amount",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          description="status",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="step_approval",
 *          description="step of approval",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="amount_approval",
 *          description="amount of approval",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      )
 * )
 */
class Leaf extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'leaves';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'employee_id',
        'reason_id',
        'leave_start',
        'leave_end',
        'amount',
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
        'reason_id' => 'integer',
        'leave_start' => 'datetime',
        'leave_end' => 'datetime',
        'amount' => 'integer',
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
        'employee_id' => 'nullable',
        'reason_id' => 'nullable',
        'leave_start' => 'required',
        'leave_end' => 'required',
        // 'amount' => 'required',
        // 'status' => 'required|string|max:2',
        // 'step_approval' => 'required|boolean',
        // 'amount_approval' => 'required|boolean',
        'description' => 'nullable|string|max:255'
    ];

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

    // public function getLeaveStartAttribute($value){
    //     return localFormatDateTime($value);
    // }

    // public function getLeaveEndAttribute($value){
    //     return localFormatDateTime($value);
    // }
}
