<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Overtime",
 *      required={"overtime_date", "start_hour", "end_hour", "raw_value", "calculated_value", "holiday", "overday"},
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
class Overtime extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'overtimes';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'employee_id',
        'shiftment_id',
        'approved_by_id',
        'overtime_date',
        'start_hour',
        'end_hour',
        'raw_value',
        'calculated_value',
        'holiday',
        'overday',
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
        'overtime_date' => 'date',
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
        'employee_id' => 'nullable',
        'shiftment_id' => 'nullable',
        'approved_by_id' => 'nullable',
        'overtime_date' => 'required',
        'start_hour' => 'required',
        'end_hour' => 'required',
        'raw_value' => 'required|numeric',
        'calculated_value' => 'required|numeric',
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
}
