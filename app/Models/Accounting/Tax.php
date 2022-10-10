<?php

namespace App\Models\Accounting;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Tax",
 *      required={""},
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
 *          property="old_tax_group",
 *          description="old_tax_group",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="new_tax_group",
 *          description="new_tax_group",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="old_risk_ratio",
 *          description="old_risk_ratio",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="new_risk_ratio",
 *          description="new_risk_ratio",
 *          type="string"
 *      )
 * )
 */
class Tax extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'taxs';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'period_id',
        'employee_id',
        'tax_group',
        'untaxable',
        'taxable',
        'tax_value',
        'tax_key'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'period_id' => 'integer',
        'employee_id' => 'integer',
        'tax_group' => 'string',
        'untaxable' => 'string',
        'taxable' => 'string',
        'tax_value' => 'string',
        'tax_key' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'period_id' => 'nullable',
        'employee_id' => 'nullable',
        'tax_group' => 'nullable|string|max:3',
        'untaxable' => 'nullable|string',
        'taxable' => 'nullable|string',
        'tax_value' => 'nullable|string',
        'tax_key' => 'nullable|string|max:255'
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
    public function period()
    {
        return $this->belongsTo(\App\Models\Hr\PayrollPeriod::class, 'period_id');
    }
}
