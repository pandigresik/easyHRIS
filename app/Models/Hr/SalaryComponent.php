<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="SalaryComponent",
 *      required={"fixed"},
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
class SalaryComponent extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'salary_components';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'code',
        'name',
        'state',
        'fixed'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'name' => 'string',
        'state' => 'string',
        'fixed' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'nullable|string|max:7',
        'name' => 'nullable|string|max:255',
        'state' => 'nullable|string|max:1',
        'fixed' => 'required|boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function companyCosts()
    {
        return $this->hasMany(\App\Models\Hr\CompanyCost::class, 'component_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function payrollDetails()
    {
        return $this->hasMany(\App\Models\Hr\PayrollDetail::class, 'component_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function salaryAllowances()
    {
        return $this->hasMany(\App\Models\Hr\SalaryAllowance::class, 'component_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function salaryBenefitHistories()
    {
        return $this->hasMany(\App\Models\Hr\SalaryBenefitHistory::class, 'component_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function salaryBenefits()
    {
        return $this->hasMany(\App\Models\Hr\SalaryBenefit::class, 'component_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function salaryGroupDetails()
    {
        return $this->hasMany(\App\Models\Hr\SalaryGroupDetail::class, 'component_id');
    }

    public function getStateAttribute($value){
        return $value == 'p' ? 'Plus' : 'Minus';
    }
}
