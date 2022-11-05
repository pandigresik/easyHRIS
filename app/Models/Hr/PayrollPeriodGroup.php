<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="PayrollPeriodGroup",
 *      required={"name", "type_period"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="type_period",
 *          description="type_period",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      )
 * )
 */
class PayrollPeriodGroup extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'payroll_period_groups';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const PAYROLL_PERIOD = [
        'daily' => 'daily',
        'weekly' => 'weekly',
        'biweekly' => 'biweekly',
        'monthly' => 'monthly'
    ];

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'type_period',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'type_period' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:50',
        'type_period' => 'required|string',
        'description' => 'nullable|string|max:255'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function employees()
    {
        return $this->hasMany(\App\Models\Hr\Employee::class, 'payroll_period_group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function payrollPeriods()
    {
        return $this->hasMany(\App\Models\Hr\PayrollPeriod::class, 'payroll_period_group_id');
    }

    public function scopeWeekly($query){
        return $query->where('type_period', 'weekly');
    }

    public function scopeBiweekly($query){
        return $query->where('type_period', 'biweekly');
    }

    public function scopeDaily($query){
        return $query->where('type_period', 'daily');
    }

    public function scopeMonthly($query){
        return $query->where('type_period', 'monthly');
    }
}
