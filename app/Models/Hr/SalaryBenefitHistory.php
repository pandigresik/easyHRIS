<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="SalaryBenefitHistory",
 *      required={""},
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
class SalaryBenefitHistory extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'salary_benefit_histories';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'employee_id',
        'component_id',
        'contract_id',
        'new_benefit_value',
        'old_benefit_value',
        'benefit_key',
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
        'component_id' => 'integer',
        'contract_id' => 'integer',
        'new_benefit_value' => 'string',
        'old_benefit_value' => 'string',
        'benefit_key' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'employee_id' => 'nullable',
        'component_id' => 'nullable',
        'contract_id' => 'nullable',
        'new_benefit_value' => 'nullable|string',
        'old_benefit_value' => 'nullable|string',
        'benefit_key' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:255'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function contract()
    {
        return $this->belongsTo(\App\Models\Hr\Contract::class, 'contract_id');
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
    public function component()
    {
        return $this->belongsTo(\App\Models\Hr\SalaryComponent::class, 'component_id');
    }
}
