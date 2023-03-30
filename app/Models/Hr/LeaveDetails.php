<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="LeaveDetails",
 *      required={"leave_id", "leave_date"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="leave_id",
 *          description="leave_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="leave_date",
 *          description="leave_date",
 *          type="string",
 *          format="date"
 *      )
 * )
 */
class LeaveDetails extends Model
{
    use HasFactory;
    //    use SoftDeletes;

    public $table = 'leave_details';
    
    const CREATED_AT = NULL;
    const UPDATED_AT = NULL;
    const CREATED_BY = NULL;
    const UPDATED_BY = NULL;


    protected $dates = ['deleted_at'];



    public $fillable = [
        'leave_id',
        'leave_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'leave_id' => 'integer',
        'leave_date' => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'leave_id' => 'required',
        'leave_date' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function leave()
    {
        return $this->belongsTo(\App\Models\Hr\Leaf::class, 'leave_id');
    }

    public function scopeApprove($query){
        $approveState = Leaf::APPROVE_STATE;
        return $query->join('leaves', function($q) use ($approveState) {
            $q->on('leave_details.leave_id','=','leaves.id')
                ->where('status', $approveState)
                ->whereNull('deleted_at');
        });
    }

    public function scopeEmployeeApprove($query, $employee){
        $approveState = Leaf::APPROVE_STATE;
        return $query->join('leaves', function($q) use ($approveState, $employee) {
            $q->on('leave_details.leave_id','=','leaves.id')
                ->where('status', $approveState)
                ->whereNull('deleted_at')
                ->whereIn('employee_id', $employee);
        });
    }

    public function scopeShiftmentGroupApprove($query, $shiftmentGroup){
        $approveState = Leaf::APPROVE_STATE;
        $shiftmentGroup = is_array($shiftmentGroup) ? $shiftmentGroup : [$shiftmentGroup];
        return $query->join('leaves', function($q) use ($approveState, $shiftmentGroup) {
            $q->on('leave_details.leave_id','=','leaves.id')
                ->where('status', $approveState)
                ->whereNull('deleted_at')
                ->whereIn('employee_id', function($q) use ($shiftmentGroup){
                    return $q->select(['id'])->from('employees')->whereIn('shiftment_group_id', $shiftmentGroup);
                });
        });
    }    
}
