<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="GroupingPayrollEmployeeReport",
 *      required={"employee_id", "grouping_payroll_entity_id"},
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
 *          property="grouping_payroll_entity_id",
 *          description="grouping_payroll_entity_id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class GroupingPayrollEmployeeReport extends Model
{
    use HasFactory;        

    public $table = 'grouping_payroll_employee_report';
    
    const CREATED_AT = NULL;
    const UPDATED_AT = NULL;
    const CREATED_BY = NULL;
    const UPDATED_BY = NULL;


    protected $dates = ['deleted_at'];



    public $fillable = [
        'employee_id',
        'grouping_payroll_entity_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'grouping_payroll_entity_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'employee_id' => 'required',
        'grouping_payroll_entity_id' => 'required'
    ];

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
    public function groupPayrollEntity()
    {
        return $this->belongsTo(\App\Models\Hr\GroupingPayrollEntity::class, 'grouping_payroll_entity_id');
    }
}
