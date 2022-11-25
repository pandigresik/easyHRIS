<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Payroll",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="company_id",
 *          description="company_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="year",
 *          description="year",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="month",
 *          description="month",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="closed",
 *          description="closed",
 *          type="boolean"
 *      )
 * )
 */
class Payroll extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'payrolls';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'employee_id',
        'payroll_period_id',
        'take_home_pay',
        'take_home_pay_key',
        'additional_info'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'payroll_period_id' => 'integer',
        'take_home_pay' => 'string',
        'take_home_pay_key' => 'string',
        'additional_info' => 'array'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'employee_id' => 'nullable',
        'payroll_period_id' => 'nullable',
        'take_home_pay' => 'nullable|string',
        'take_home_pay_key' => 'nullable|string|max:255'
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
    public function payrollPeriod()
    {
        return $this->belongsTo(\App\Models\Hr\PayrollPeriod::class, 'payroll_period_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function companyCosts()
    {
        return $this->hasMany(\App\Models\Base\CompanyCost::class, 'payroll_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function payrollDetails()
    {
        return $this->hasMany(\App\Models\Hr\PayrollDetail::class, 'payroll_id');
    }

    public function getTakeHomePayAttribute($value){
        return localNumberFormat($value, 0);
    }
}
