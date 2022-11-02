<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="PayrollPeriod",
 *      required={"name", "year", "month", "start_period", "end_period", "closed"},
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
 *          property="name",
 *          description="name",
 *          type="string"
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
 *          property="start_period",
 *          description="start_period",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="end_period",
 *          description="end_period",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="closed",
 *          description="closed",
 *          type="boolean"
 *      )
 * )
 */
class PayrollPeriod extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'payroll_periods';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'company_id',
        'name',
        'year',
        'month',
        'start_period',
        'end_period',
        'type_period',
        'closed'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'name' => 'string',
        'year' => 'integer',
        'month' => 'integer',
        'start_period' => 'date',
        'end_period' => 'date',
        'closed' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company_id' => 'nullable',
        'name' => 'required|string|max:255',
        'year' => 'required',
        'month' => 'required',
        'start_period' => 'required',
        'end_period' => 'required',
        'closed' => 'required|boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function company()
    {
        return $this->belongsTo(\App\Models\Base\Company::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function payrolls()
    {
        return $this->hasMany(\App\Models\Hr\Payroll::class, 'payroll_period_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function taxes()
    {
        return $this->hasMany(\App\Models\Hr\Tax::class, 'period_id');
    }

    public function getStartPeriodAttribute($value){
        return localFormatDate($value);
    }

    public function getEndPeriodAttribute($value){
        return localFormatDate($value);
    }

    public function getRangePeriodAttribute($value){
        return $this->start_period.' - '.$this->end_period;
    }

    public function scopeWeekly($query){
        return $query->where(['type_period' => 'weekly']);
    }

    public function scopeBiweekly($query){
        return $query->where(['type_period' => 'biweekly']);
    }

    public function scopeMonthly($query){
        return $query->where(['type_period' => 'monthly']);
    }

    public function scopeClosed($query){
        return $query->where(['closed' => 1]);
    }
}
